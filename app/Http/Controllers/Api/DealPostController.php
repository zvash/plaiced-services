<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PostRepository as Repository;
use App\Http\Requests\StoreDealPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Deal;
use App\Models\Post;

class DealPostController extends Controller
{
    /**
     * Post repository.
     *
     * @var \App\Http\Repositories\PostRepository
     */
    protected $repository;

    /**
     * Deal post controller constructor.
     *
     * @param  \App\Http\Repositories\PostRepository  $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealPostRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function store(StoreDealPostRequest $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        [$post, $timeline] = $this->repository->create($request, $deal);

        $resource = new PostResource($post);

        return $resource->withLocation('timelines.show', [$timeline]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', [$this, $post]);

        $this->repository->delete($post);

        return response()->noContent();
    }
}
