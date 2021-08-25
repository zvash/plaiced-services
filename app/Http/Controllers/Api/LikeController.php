<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Like controller constructor.
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
        return LikeResource::collection(
            $request->user()
                ->likes()
                ->with('likable')
                ->latest()
                ->paginate(15)
        );
    }
}
