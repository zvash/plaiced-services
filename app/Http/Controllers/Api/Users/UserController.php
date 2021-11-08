<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class UserController extends Controller
{
    /**
     * User controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return UserResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Register a new user
     *
     * @param StoreUserRequest $request
     * @param UserRepository $repository
     * @return
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request, UserRepository $repository)
    {
        $user = $repository->create($request);
        event(new Registered($user));

        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $request->email,
            'password'      => $request->password,
            'scope'         => null,
        ]);

        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return Route::dispatch($token);
    }

    /**
     * Update the authenticated user
     *
     * @param UpdateUserProfileRequest $request
     * @param UserRepository $repository
     * @return UserResource
     * @throws \Throwable
     */
    public function update(UpdateUserProfileRequest $request, UserRepository $repository)
    {
        $user = $repository->updateProfile($request);
        return new UserResource($user);
    }
}
