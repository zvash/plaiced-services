<?php

namespace App\Http\Controllers\Api\Follows;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Follow controller constructor.
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
        return FollowResource::collection(
            $request->user()
                ->follows()
                ->with('followable')
                ->latest()
                ->paginate(15)
        );
    }
}
