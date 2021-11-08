<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Advertiser;
use App\Models\Content;
use App\Models\ContentCreator;
use App\Models\Social;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Database\DatabaseManager as Database;
use Illuminate\Filesystem\FilesystemManager as Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserRepository extends Repository
{
    /**
     * Storage file manager object.
     *
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $storage;

    /**
     * Content repository constructor.
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
     * Change user's password
     *
     * @param ChangeUserPasswordRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function changePassword(ChangeUserPasswordRequest $request)
    {
        $callback = function (ChangeUserPasswordRequest $request) {
            $attributes = $request->validated();
            $user = $request->user();
            $ip = $request->ip();
            $user->setAttribute('password', bcrypt($attributes['new_password']))
                ->setAttribute('ip', $ip)
                ->save();
            return $user;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Update user's profile
     *
     * @param UpdateUserProfileRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $callback = function (ChangeUserPasswordRequest $request) {
            $attributes = $request->validated();
            $attributes['ip'] = $request->ip();
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $path = \Illuminate\Support\Facades\Storage::putFile('users/avatar', $file, true);
                $attributes['avatar'] = $path;
            }
            $user = $request->user();
            foreach ($attributes as $key => $value) {
                $user->setAttribute($key, $value);
            }
            $user->save();
            return $user;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * @param StoreUserRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function create(StoreUserRequest $request)
    {
        $callback = function (StoreUserRequest $request) {
            $attributes = $request->validated();
            $attributes['ip'] = $request->ip();
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $path = \Illuminate\Support\Facades\Storage::putFile('users/avatar', $file, true);
                $attributes['avatar'] = $path;
            }
            $userAttributes = array_filter($attributes, function ($key) {
                return in_array($key, [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'class',
                    'find_us',
                    'avatar',
                    'ip',
                ]);
            }, ARRAY_FILTER_USE_KEY);
            $userAttributes['password'] = bcrypt($userAttributes['password']);
            $user = new User($userAttributes);
            $user->save();
            $relationAttributes = array_filter($attributes, function ($key) {
                return in_array($key, [
                    'avatar',
                    'title',
                    'small_description',
                    'description',
                    'website',
                    'telephone',
                    'alt_telephone',
                    'address',
                    'city',
                    'state',
                    'postal_code',
                    'country_id',
                    'type',
                ]);
            });
            $relationClass = $user->class;
            $relation = new $relationClass($relationAttributes);
            $relation->user_id = $user->id;
            $relation->save();
            return $user;
        };

        return $this->transaction($callback, ...func_get_args());
    }
}
