<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository as Repository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Traits\Passport\PassportToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Client;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use PassportToken;

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
        //$this->middleware('client:*')->only('store');

        $this->repository = $repository;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Register a new user.
     *
     * @param StoreUserRequest $request
     * @return Response
     *
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->repository->create($request);
        event(new Registered($user));
        $client = Client::wherePasswordClient(true)->first();
        return $this->logUserInWithoutPassword($user);
    }

    /**
     * Update the authenticated user.
     *
     * @param UpdateUserRequest $request
     * @return UserResource
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
