<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository as Repository;
use App\Http\Requests\StoreDealProductRequest;
use App\Http\Requests\UpdateDealProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Deal;
use App\Models\Product;

class DealProductController extends Controller
{
    /**
     * Product repository.
     *
     * @var \App\Http\Repositories\ProductRepository
     */
    protected $repository;

    /**
     * Deal product controller constructor.
     *
     * @param  \App\Http\Repositories\ProductRepository  $repository
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
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Deal $deal)
    {
        $this->authorize('viewAny', [$this, $deal]);

        return ProductResource::collection(
            $deal->products()->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealProductRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function store(StoreDealProductRequest $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        $resource = new ProductResource(
            $product = $this->repository->create($request, $deal)
        );

        return $resource->withLocation('products.show', [$product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product)
    {
        $this->authorize('view', [$this, $product->deal]);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDealProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function update(UpdateDealProductRequest $request, Product $product)
    {
        $this->authorize('update', [$this, $product->deal]);

        $product = $this->repository->update($request, $product);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', [$this, $product->deal]);

        $this->repository->delete($product);

        return response()->noContent();
    }
}
