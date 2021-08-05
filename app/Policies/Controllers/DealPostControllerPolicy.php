<?php

namespace App\Policies\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPostControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return mixed
     */
    public function create(User $user, Controller $controller, Deal $deal)
    {
        return $deal->authorize($user);
    }

    /**
     * Determine whether the user can delete a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Controller $controller, Post $post)
    {
        return $post->user->is($user) && $post->deal->authorize($user);
    }
}
