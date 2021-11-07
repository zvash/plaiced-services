<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DealRepository as Repository;
use App\Http\Requests\UpdateDealShippingRequest as Request;
use App\Models\Deal;

class DealShippingController extends Controller
{
    /**
     * Deal repository.
     *
     * @var \App\Http\Repositories\DealRepository
     */
    protected $repository;

    /**
     * Deal shipping controller constructor.
     *
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\UpdateDealShippingRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function __invoke(Request $request, Deal $deal)
    {
        $this->authorize('perform', [$this, $deal]);

        $this->repository->shipping($request, $deal);

        return response()->noContent();
    }
}
