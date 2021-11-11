<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
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

            if ($this->hasFile($request, 'avatar')) {
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

            if ($this->hasFile($request, 'avatar')) {
                $attributes['avatar'] = $request->file('avatar')->store('users/avatars', 's3');
            }

            if ($this->hasFile($request, 'relation_avatar')) {
                $path = Str::snake(Str::plural(preg_replace('/.*\\\\/', '', $attributes['class']))).'/avatars';
                $attributes['relation_avatar'] = $request->file('relation_avatar')->store($path, 's3');
            }

            [$userAttributes, $relationAttributes] = collect($attributes)->partition(
                fn ($attribute, $key) => in_array($key, [
                    'first_name',
                    'last_name',
                    'email',
                    'company_position',
                    'password',
                    'class',
                    'find_us',
                    'avatar',
                    'ip',
                ])
            );

            $user = User::create($userAttributes->all());

            if ($relationAttributes->has('relation_avatar')) {
                $relationAttributes->put('avatar', $relationAttributes->get('relation_avatar'))->pull('relation_avatar');
            }
            /** @var \Illuminate\Database\Eloquent\Model $relation */
            $relation = new $userAttributes['class']($relationAttributes->all());
            $relation->user()->associate($user);
            $relation->save();

            return $user;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Check request has avatar file.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @return bool
     */
    protected function hasFile(Request $request, string $key)
    {
        return $request->hasFile($key)
            && $request->file($key)->isValid();
    }
}
