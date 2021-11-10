<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DealRepository as Repository;
use App\Models\Deal;

class DealAcceptController extends Controller
{
    /**
     * Deal repository.
     *
     * @var \App\Http\Repositories\DealRepository
     */
    protected $repository;

    /**
     * Deal accept controller constructor.
     *
     * @param  \App\Http\Repositories\DealRepository  $repository
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
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Deal $deal)
    {
        $this->authorize('perform', [$this, $deal]);

        $this->repository->accept($deal);

        return response()->noContent();
    }
}
