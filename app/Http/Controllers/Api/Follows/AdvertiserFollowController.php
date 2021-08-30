<?php

namespace App\Http\Controllers\Api\Follows;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use App\Models\Advertiser;
use App\Models\Follow;
use Illuminate\Http\Request;

class AdvertiserFollowController extends Controller
{
    /**
     * Advertiser follow controller constructor.
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
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Advertiser $advertiser)
    {
        $this->authorize('viewAny', [$this, $advertiser]);

        return FollowResource::collection(
            $advertiser->followers()
                ->latest()
                ->with('followable')
                ->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Advertiser $advertiser)
    {
        $this->authorize('create', [$this, $advertiser]);

        $follow = new Follow;

        $follow->followable()->associate($advertiser);

        $request->user()->follows()->save($follow);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Advertiser $advertiser)
    {
        $this->authorize('delete', [$this, $advertiser]);

        $advertiser->followers()->whereUserId($request->user()->id)->delete();

        return response()->noContent();
    }
}
