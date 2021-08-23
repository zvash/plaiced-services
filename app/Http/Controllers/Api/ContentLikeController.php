<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\Content;
use App\Models\Like;
use Illuminate\Http\Request;

class ContentLikeController extends Controller
{
    /**
     * Like content controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Content $content)
    {
        $this->authorize('viewAny', [$this, $content]);

        return LikeResource::collection(
            $content->likes()->latest()->with('likable')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Content $content)
    {
        $this->authorize('create', [$this, $content]);

        $like = new Like;

        $like->likable()->associate($content);

        $request->user()->likes()->save($like);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Content $content)
    {
        $this->authorize('delete', [$this, $content]);

        $content->likes()->whereUserId($request->user()->id)->delete();

        return response()->noContent();
    }
}
