<?php

namespace App\Http\Controllers\Api\Advertisers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexSortRequest;
use App\Http\Resources\Summaries\AdvertiserSummaryResource;
use App\Models\Advertiser;

class AdvertiserController extends Controller
{
    /**
     * Advertiser controller constructor.
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
     * @param  \App\Http\Requests\IndexSortRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexSortRequest $request)
    {
        $attributes = $request->validated();

        return AdvertiserSummaryResource::collection(
            Advertiser::wherePrivate(false)
                ->orderBy($attributes['sort_by'], $attributes['sort_type'])
                ->paginate(15)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Advertiser $advertiser)
    {
        return new AdvertiserSummaryResource($advertiser);
    }
}
