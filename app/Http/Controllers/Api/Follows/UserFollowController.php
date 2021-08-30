<?php

namespace App\Http\Controllers\Api\Follows;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use App\Models\User;

class UserFollowController extends Controller
{
    /**
     * User follow controller constructor.
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
        return FollowResource::collection(
            $user->follows()
                ->with('followable')
                ->latest()
                ->paginate(15)
        );
    }
}
