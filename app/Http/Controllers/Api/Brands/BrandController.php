<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository as Repository;
use App\Http\Resources\BrandResource;
use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Brand repository.
     *
     * @var \App\Http\Repositories\BrandRepository
     */
    protected $repository;

    /**
     * Brand controller constructor.
     *
     * @param  \App\Http\Repositories\BrandRepository  $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
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
        return new BrandResource(
            $brand->load(['category', 'subcategory'])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Brand $brand)
    {
        $this->authorize('delete', [$this, $brand]);

        $this->repository->delete($brand);

        return response()->noContent();
    }
}
