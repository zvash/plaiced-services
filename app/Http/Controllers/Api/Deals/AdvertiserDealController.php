<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexStatusRequest as Request;
use App\Http\Resources\Summaries\DealSummaryResource;
use App\Models\Advertiser;
use App\Models\Deal;

class AdvertiserDealController extends Controller
{
    /**
     * Advertiser deal controller constructor.
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
     * @param  \App\Http\Requests\IndexStatusRequest  $request
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Advertiser $advertiser)
    {
        $this->authorize('viewAny', [$this, $advertiser]);

        return DealSummaryResource::collection(
            Deal::byAdvertiser($advertiser)
                ->when(
                    $request->filled('status'),
                    fn ($query) => $query->whereStatus((int) $request->status)
                )
                ->paginate(15)
        );
    }
}
