<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Content;
use App\Models\ContentCreator;
use App\Models\Social;
use App\Models\Talent;
use Illuminate\Database\DatabaseManager as Database;
use Illuminate\Filesystem\FilesystemManager as Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentRepository extends Repository
{
    /**
     * Storage file manager object.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $storage;

    /**
     * Content repository constructor.
     *
     * @param  \Illuminate\Database\DatabaseManager  $database
     * @param  \Illuminate\Filesystem\FilesystemManager  $storage
     * @return void
     */
    public function __construct(Database $database, Storage $storage)
    {
        parent::__construct($database);

        $this->storage = $storage;
    }

    /**
     * Create a content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \App\Models\Content
     *
     * @throws \Throwable
     */
    public function create(Request $request, ContentCreator $contentCreator)
    {
        $callback = function (Request $request, ContentCreator $contentCreator) {
            [$relations, $attributes] = collect($request->validated())->partition(
                fn ($attribute, $key) => in_array($key, [
                    'socials',
                    'assets',
                    'videos',
                    'talents',
                ])
            );

            $attributes = $attributes->merge([
                'avatar' => $attributes->get('avatar')->store('contents/avatar', 's3'),
            ])->toArray();

            $content = $contentCreator->contents()->create($attributes);

            $relations->each(
                fn ($relation, $key) => $this->{$key}($request, $relation, $content)
            );

            return $content->load([
                'viewership',
                'genre',
                'category',
                'subcategory',
                'childSubcategory',
            ]);
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Delete a content.
     *
     * @param  \App\Models\Content  $content
     * @return void
     *
     * @throws \Throwable
     */
    public function delete(Content $content)
    {
        $callback = function (Content $content) {
            $content->socials()->delete();
            $content->assets()->delete();
            $content->deals()->delete();

            $content->delete();
        };

        $this->transaction($callback, $content);
    }

    /**
     * Create assets for created content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $assets
     * @param  \App\Models\Content  $content
     * @return void
     */
    private function assets(Request $request, array $assets, Content $content)
    {
        if (! $request->hasFile('assets.*.file')) {
            return;
        }

        foreach ($assets as $asset) {
            if (! $asset['file']->isValid()) {
                continue;
            }

            $content->assets()->create([
                'title' => $asset['title'],
                'size' => $asset['file']->getSize(),
                'extension' => $asset['file']->extension(),
                'mime_type' => $asset['file']->getClientMimeType(),
                'url' => $asset['file']->store('contents/assets', 's3'),
                'file_name' => $asset['file']->getClientOriginalName(),
            ]);
        }
    }

    /**
     * Create video urls for created content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $videos
     * @param  \App\Models\Content  $content
     * @return void
     */
    private function videos(Request $request, array $videos, Content $content)
    {
        $content->assets()->createMany($videos);
    }

    /**
     * Create social urls for created content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $socials
     * @param  \App\Models\Content  $content
     * @return void
     */
    private function socials(Request $request, array $socials, Content $content)
    {
        $socials = collect($socials)->map(function ($url, $social) {
            $type = constant(
                (string) Str::of($social)
                    ->prepend('::type_')
                    ->upper()
                    ->prepend(Social::class)
            );

            return compact('type', 'url');
        })->values();

        $content->socials()->createMany($socials);
    }

    /**
     * Create talents for created content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $talents
     * @param  \App\Models\Content  $content
     * @return void
     */
    private function talents(Request $request, array $talents, Content $content)
    {
        foreach ($talents as $talent) {
            Talent::create(['title' => $talent['title']])
                ->contents()
                ->attach($content->id, ['type' => (int) $talent['type']]);
        }
    }
}
