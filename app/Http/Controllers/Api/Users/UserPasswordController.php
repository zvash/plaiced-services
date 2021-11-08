<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserPasswordController extends Controller
{
    /**
     * UserPassword controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param ChangeUserPasswordRequest $request
     * @param UserRepository $repository
     * @return UserResource
     * @throws \Throwable
     */
    public function update(ChangeUserPasswordRequest $request, UserRepository $repository)
    {
        $user = $repository->changePassword($request);
        return new UserResource($user);
    }
}
