<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository extends Repository
{
    /**
     * Create a deal product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Product
     *
     * @throws \Throwable
     */
    public function create(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            $deal->addTimeline('DealProduct:Create');

            return $deal->products()->create($request->validated());
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Update a deal product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \App\Models\Product
     *
     * @throws \Throwable
     */
    public function update(Request $request, Product $product)
    {
        $callback = function (Request $request, Product $product) {
            $product = $product->fill($request->validated());

            if ($product->isDirty()) {
                $product->deal->addTimeline('DealProduct:Update');
            }

            return tap($product)->save();
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Delete product.
     *
     * @param  \App\Models\Product  $product
     * @return bool
     *
     * @throws \Throwable
     */
    public function delete(Product $product)
    {
        $callback = function (Product $product) {
            $product->deal->addTimeline('DealProduct:Delete');

            return $product->delete();
        };

        return $this->transaction($callback, $product);
    }
}
