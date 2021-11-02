<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Deal;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentRepository extends Repository
{
    /**
     * Create a deal payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Payment
     *
     * @throws \Throwable
     */
    public function create(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            $deal->addTimeline('DealPayment:Create', [
                'date' => now()->toDayDateTimeString()
            ]);

            $payment = new Payment($request->validated());
            $payment->deal()->associate($deal);
            $payment->user()->associate($request->user());

            return tap($payment)->save();
        };

        return $this->transaction($callback, ...func_get_args());
    }
}
