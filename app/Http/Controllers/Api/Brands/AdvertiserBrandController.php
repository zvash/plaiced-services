<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository as Repository;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Models\Advertiser;
use Illuminate\Http\Request;

class AdvertiserBrandController extends Controller
{
    /**
     * Brand repository.
     *
     * @var \App\Http\Repositories\BrandRepository
     */
    protected $repository;

    /**
     * Advertiser brand controller constructor.
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
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Advertiser $advertiser)
    {
        $query = $advertiser->brands()->latest();

        return BrandSummaryResource::collection(
            $request->has('no-pagination')
                ? $query->get()
                : $query->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreBrandRequest $request, Advertiser $advertiser)
    {
        $this->authorize('create', [$this, $advertiser]);

        $resource = new BrandResource(
            $brand = $this->repository->create($request, $advertiser)
        );

        return $resource->withLocation('brands.show', [$brand]);
    }
}
