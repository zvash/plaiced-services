<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Models\Deal;

class DealCancelController extends Controller
{
    /**
     * Deal cancel controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
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

        $deal->rejected();

        return response()->noContent();
    }
}
