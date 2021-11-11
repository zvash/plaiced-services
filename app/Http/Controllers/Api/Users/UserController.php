<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository as Repository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Traits\InteractWithPassport;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use InteractWithPassport;

    /**
     * User repository.
     *
     * @var \App\Http\Repositories\UserRepository
     */
    protected $repository;

    /**
     * User controller constructor.
     *
     * @param  \App\Http\Repositories\UserRepository  $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api')->except('store');
        $this->middleware('client:*')->only('store');

        $this->repository = $repository;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Register a new user.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->repository->create($request);

        event(new Registered($user));

        return $this->logUserInWithoutPassword($user);
    }

    /**
     * Update the authenticated user.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request)
    {
        return new UserResource(
            $this->repository->update($request)
        );
    }
}
