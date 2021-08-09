<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentPaymentController extends Controller
{
    /**
     * Content payment controller constructor.
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
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, Content $content)
    {
        $this->authorize('viewAny', [$this, $content]);

        return PaymentResource::collection(
            $content->payments()
                ->whereUserId($request->user()->id)
                ->latest()
                ->paginate(15)
        );
    }
}
