<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealPaymentRequest as Request;
use App\Http\Resources\PaymentResource;
use App\Models\Deal;
use App\Models\Payment;

class DealPaymentController extends Controller
{
    /**
     * Deal payment controller constructor.
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

        return PaymentResource::collection(array_filter([$deal->payment]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDealPaymentRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        $payment = new Payment($request->validated());
        $payment->deal()->associate($deal);

        $resource = new PaymentResource(
            $payment = $request->user()->payments()->save($payment)
        );

        return $resource->withLocation('payments.show', [$payment]);
    }
}
