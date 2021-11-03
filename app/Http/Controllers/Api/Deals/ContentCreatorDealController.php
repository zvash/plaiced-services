<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexStatusRequest as Request;
use App\Http\Resources\Summaries\DealSummaryResource;
use App\Models\ContentCreator;
use App\Models\Deal;

class ContentCreatorDealController extends Controller
{
    /**
     * Content creator deal controller constructor.
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
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, ContentCreator $contentCreator)
    {
        $this->authorize('viewAny', [$this, $contentCreator]);

        return DealSummaryResource::collection(
            Deal::byContentCreator($contentCreator)
                ->when(
                    $request->filled('status'),
                    fn ($query) => $query->whereStatus((int) $request->status)
                )
                ->paginate(15)
        );
    }
}
