<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository as Repository;
use App\Http\Requests\UpdateUserPasswordRequest as Request;
use App\Http\Resources\UserResource;

class UserPasswordController extends Controller
{
    /**
     * User repository.
     *
     * @var \App\Http\Repositories\UserRepository
     */
    protected $repository;

    /**
     * User password controller constructor.
     *
     * @param  \App\Http\Repositories\UserRepository  $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Update the password of authenticated user.
     *
     * @param  \App\Http\Requests\UpdateUserPasswordRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        return new UserResource(
            $this->repository->changePassword($request)
        );
    }
}
