<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Advertiser;
use App\Models\Brand;
use App\Models\Social;
use Illuminate\Database\DatabaseManager as Database;
use Illuminate\Filesystem\FilesystemManager as Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandRepository extends Repository
{
    /**
     * Storage file manager object.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $storage;

    /**
     * Brand repository constructor.
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
     * Create a brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertiser  $advertiser
     * @return \App\Models\Brand
     *
     * @throws \Throwable
     */
    public function create(Request $request, Advertiser $advertiser)
    {
        $callback = function (Request $request, Advertiser $advertiser) {
            [$relations, $attributes] = collect($request->validated())->partition(
                fn ($attribute, $key) => in_array($key, [
                    'socials',
                    'assets',
                    'videos',
                ])
            );

            $attributes = $attributes->merge([
                'avatar' => $attributes->get('avatar')->store('brands/avatar', 's3'),
            ])->toArray();

            $brand = $advertiser->brands()->create($attributes);

            $relations->each(
                fn ($relation, $key) => $this->{$key}($request, $relation, $brand)
            );

            return $brand->load(['category', 'subcategory']);
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Delete a brand.
     *
     * @param  \App\Models\Brand  $brand
     * @return void
     *
     * @throws \Throwable
     */
    public function delete(Brand $brand)
    {
        $callback = function (Brand $brand) {
            $brand->socials()->delete();
            $brand->assets()->delete();
            $brand->deals()->delete();

            $brand->delete();
        };

        $this->transaction($callback, $brand);
    }

    /**
     * Create assets for created brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $assets
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    private function assets(Request $request, array $assets, Brand $brand)
    {
        if (! $request->hasFile('assets.*.file')) {
            return;
        }

        foreach ($assets as $asset) {
            if (! $asset['file']->isValid()) {
                continue;
            }

            $brand->assets()->create([
                'title' => $asset['title'],
                'size' => $asset['file']->getSize(),
                'extension' => $asset['file']->extension(),
                'mime_type' => $asset['file']->getClientMimeType(),
                'url' => $asset['file']->store('brands/assets', 's3'),
                'file_name' => $asset['file']->getClientOriginalName(),
            ]);
        }
    }

    /**
     * Create video urls for created brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $videos
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    private function videos(Request $request, array $videos, Brand $brand)
    {
        $brand->assets()->createMany($videos);
    }

    /**
     * Create social urls for created brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $socials
     * @param  \App\Models\Brand  $brand
     * @return void
     */
    private function socials(Request $request, array $socials, Brand $brand)
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

        $brand->socials()->createMany($socials);
    }
}
