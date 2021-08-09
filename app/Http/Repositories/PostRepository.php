<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Deal;
use App\Models\Post;
use App\Models\PostAsset;
use Illuminate\Database\DatabaseManager as Database;
use Illuminate\Filesystem\FilesystemManager as Storage;
use Illuminate\Http\Request;

class PostRepository extends Repository
{
    /**
     * Storage file manager object.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $storage;

    /**
     * Post repository constructor.
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
     * Create a deal post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Post
     *
     * @throws \Throwable
     */
    public function create(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            $this->assets($request, $post = $this->post($request, $deal));

            return [$post, $deal->addPostTimeline($post)];
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Delete Post with all relations.
     *
     * @param  \App\Models\Post  $post
     * @return void
     *
     * @throws \Throwable
     */
    public function delete(Post $post)
    {
        $callback = function (Post $post) {
            $post->assets->each(function (PostAsset $asset) {
                // Deleting post assets files from disk storage
                $this->storage->disk('s3')->delete($asset->url);

                $asset->delete();
            });

            $post->timeline()->delete();

            $post->delete();
        };

        return $this->transaction($callback, $post);
    }

    /**
     * Create post for the deal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\Post
     */
    private function post(Request $request, Deal $deal)
    {
        $post = new Post(['description' => $request->description]);
        $post->deal()->associate($deal);

        return $request->user()->posts()->save($post);
    }

    /**
     * Create post assets for created post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return void
     */
    private function assets(Request $request, Post $post)
    {
        if (! $request->hasFile('assets.*.file')) {
            return;
        }

        foreach ($request->assets as $asset) {
            if (! $asset['file']->isValid()) {
                continue;
            }

            $post->assets()->create([
                'title' => $asset['title'],
                'size' => $asset['file']->getSize(),
                'extension' => $asset['file']->extension(),
                'mime_type' => $asset['file']->getClientMimeType(),
                'url' => $asset['file']->store('post-assets', 's3'),
                'file_name' => $asset['file']->getClientOriginalName(),
            ]);
        }
    }
}
