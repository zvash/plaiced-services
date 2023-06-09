<?php

namespace App\Http\Controllers\Api\Likes;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\User;

class UserLikeController extends Controller
{
    /**
     * User like controller constructor.
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(User $user)
    {
        return LikeResource::collection(
            $user->likes()
                ->with('likable')
                ->latest()
                ->paginate(15)
        );
    }
}
