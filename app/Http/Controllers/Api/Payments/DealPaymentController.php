<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PaymentRepository as Repository;
use App\Http\Requests\StoreDealPaymentRequest as Request;
use App\Http\Resources\PaymentResource;
use App\Models\Deal;

class DealPaymentController extends Controller
{
    /**
     * Payment repository.
     *
     * @var \App\Http\Repositories\PaymentRepository
     */
    protected $repository;

    /**
     * Deal payment controller constructor.
     *
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

        return PaymentResource::collection(array_filter([$deal->payment]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealPaymentRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        $resource = new PaymentResource(
            $payment = $this->repository->create($request, $deal)
        );

        return $resource->withLocation('payments.show', [$payment]);
    }
}
