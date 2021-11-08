<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DealRepository as Repository;
use App\Http\Requests\IndexDealRequest;
use App\Http\Requests\StoreDealRequest;
use App\Http\Resources\DealResource;
use App\Http\Resources\Summaries\DealSummaryResource;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Deal repository.
     *
     * @var \App\Http\Repositories\DealRepository
     */
    protected $repository;

    /**
     * Deal controller constructor.
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
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexDealRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexDealRequest $request)
    {
        return DealSummaryResource::collection(
            Deal::byUser($request->user())
                ->when(
                    $request->filled('status'),
                    fn ($query) => $query->whereStatus((int) $request->status)
                )
                ->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Throwable
     */
    public function store(StoreDealRequest $request)
    {
        $resource = new DealResource(
            $deal = $this->repository->create($request)
        );

        return $resource->withLocation('deals.show', [$deal]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Deal $deal)
    {
        $this->authorize('view', [$this, $deal]);

        return new DealResource($deal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deal $deal)
    {
        // TODO: Implement update request for deal
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        // TODO: Implement destroy request for deal
    }
}
