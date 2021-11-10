<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository as Repository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class UserController extends Controller
{
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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        event(new Registered($this->repository->create($request)));

        $client = Client::wherePasswordClient(true)->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => null,
        ]);

        return Route::dispatch(
            Request::create('oauth/token', 'POST')
        );
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
