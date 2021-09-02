<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Models\Advertiser;

class AdvertiserBrandController extends Controller
{
    /**
     * Advertiser brand controller constructor.
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
     */
    public function index(Advertiser $advertiser)
    {
        return BrandSummaryResource::collection(
            $advertiser->brands()->latest()->paginate(15)
        );
    }
}
