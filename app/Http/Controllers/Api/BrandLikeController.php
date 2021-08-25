<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\Brand;
use App\Models\Like;
use Illuminate\Http\Request;

class BrandLikeController extends Controller
{
    /**
     * Brand like controller constructor.
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Brand $brand)
    {
        $this->authorize('viewAny', [$this, $brand]);

        return LikeResource::collection(
            $brand->likes()->latest()->with('likable')->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Brand $brand)
    {
        $this->authorize('create', [$this, $brand]);

        $like = new Like;

        $like->likable()->associate($brand);

        $request->user()->likes()->save($like);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Brand $brand)
    {
        $this->authorize('delete', [$this, $brand]);

        $brand->likes()->whereUserId($request->user()->id)->delete();

        return response()->noContent();
    }
}
