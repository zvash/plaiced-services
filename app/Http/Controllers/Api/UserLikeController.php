<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, User $user)
    {
        return LikeResource::collection(
            $user->likes()
                ->with('likable')
                ->latest()
                ->paginate(15)
        );
    }
}
