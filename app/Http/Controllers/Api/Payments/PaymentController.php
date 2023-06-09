<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Notification controller constructor.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return PaymentResource::collection(
            $request->user()->payments()->latest()->paginate(15)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', [$this, $payment]);

        return new PaymentResource($payment);
    }
}
