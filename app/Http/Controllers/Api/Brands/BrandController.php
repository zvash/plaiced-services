<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Brand controller constructor.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $brands = Brand::when($request->has('feature'),
            fn (Builder $query, bool $feature) => $query->whereFeatured($feature)
        )->latest()->paginate(15);

        return BrandSummaryResource::collection($brands);
    }

    /**
     * Display the specified resource listing.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Brand $brand)
    {
        return new BrandSummaryResource($brand);
    }
}
