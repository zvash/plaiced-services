<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandPaymentController extends Controller
{
    /**
     * brand payment controller constructor.
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Brand $brand)
    {
        $this->authorize('viewAny', [$this, $brand]);

        return PaymentResource::collection(
            $brand->payments()
                ->whereUserId($request->user()->id)
                ->paginate(15)
        );
    }
}
