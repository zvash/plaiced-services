<?php

namespace App\Http\Controllers\Api\Follows;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use App\Models\ContentCreator;
use App\Models\Follow;
use Illuminate\Http\Request;

class ContentCreatorFollowController extends Controller
{
    /**
     * Content creator follow controller constructor.
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
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(ContentCreator $contentCreator)
    {
        $this->authorize('viewAny', [$this, $contentCreator]);

        return FollowResource::collection(
            $contentCreator->followers()
                ->latest()
                ->with('followable')
                ->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, ContentCreator $contentCreator)
    {
        $this->authorize('create', [$this, $contentCreator]);

        $follow = new Follow();

        $follow->followable()->associate($contentCreator);

        $request->user()->follows()->save($follow);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, ContentCreator $contentCreator)
    {
        $this->authorize('delete', [$this, $contentCreator]);

        $contentCreator->followers()->whereUserId($request->user()->id)->delete();

        return response()->noContent();
    }
}
