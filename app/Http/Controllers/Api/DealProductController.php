<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealProductRequest;
use App\Http\Requests\UpdateDealProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Deal;
use App\Models\Product;

class DealProductController extends Controller
{
    /**
     * Deal product controller constructor.
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
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreDealProductRequest $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        $product = $deal->products()->create($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
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
     */
    public function update(UpdateDealProductRequest $request, Product $product)
    {
        $this->authorize('update', [$this, $product->deal]);

        $product->fill($request->validated())->save();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', [$this, $product->deal]);

        $product->delete();

        return response()->noContent();
    }
}
