<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\User;
use Illuminate\Database\DatabaseManager as Database;
use Illuminate\Filesystem\FilesystemManager as Storage;
use Illuminate\Http\Request;

class UserRepository extends Repository
{
    /**
     * Storage file manager object.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $storage;

    /**
     * User repository constructor.
     *
     * @param \Illuminate\Database\DatabaseManager $database
     * @param \Illuminate\Filesystem\FilesystemManager $storage
     * @return void
     */
    public function __construct(Database $database, Storage $storage)
    {
        parent::__construct($database);

        $this->storage = $storage;
    }

    /**
     * Change user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     *
     * @throws \Throwable
     */
    public function changePassword(Request $request)
    {
        $callback = function (Request $request) {
            $attributes = $request->validated();

            $user = $request->user()->fill([
                'ip' => $request->ip(),
                'password' => bcrypt($attributes['new_password']),
            ]);

            return tap($user)->save();
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Update user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     *
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        $callback = function (Request $request) {
            $attributes = array_merge($request->validated(), [
                'ip' => $request->ip(),
            ]);

            if ($this->hasAvatar($request)) {
                $attributes['avatar'] = $request->file('avatar')->store('users/avatars', 's3');
            }

            $user = $request->user()->fill($attributes);

            return tap($user)->save();
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Create a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\User
     *
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $callback = function (Request $request) {
            $attributes = array_merge($request->validated(), [
                'ip' => $request->ip(),
            ]);

            $attributes['password'] = bcrypt($attributes['password']);

            if ($this->hasAvatar($request)) {
                $attributes['avatar'] = $request->file('avatar')->store('users/avatars', 's3');
            }

            [$userAttributes, $relationAttributes] = collect($attributes)->partition(
                fn ($attribute, $key) => in_array($key, [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'class',
                    'find_us',
                    'avatar',
                    'ip',
                ])
            );

            $user = User::create($userAttributes);

            /** @var \Illuminate\Database\Eloquent\Model $relation */
            $relation = new $userAttributes['class']($relationAttributes);
            $relation->user()->associate($user);
            $relation->save();

            return $user;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Check request has avatar file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasAvatar(Request $request)
    {
        return $request->hasFile('avatar')
            && $request->file('avatar')->isValid();
    }
}
