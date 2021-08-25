<?php

namespace App\Policies\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentLikeControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Content  $content
     * @return bool
     */
    public function viewAny(User $user, Controller $controller, Content $content)
    {
        return $content->contentCreator->user->is($user) || $user->class === Advertiser::class;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Content  $content
     * @return bool
     */
    public function create(User $user, Controller $controller, Content $content)
    {
        return $user->class === Advertiser::class && ! $user->liked($content);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Content  $content
     * @return bool
     */
    public function delete(User $user, Controller $controller, Content $content)
    {
        return $user->class === Advertiser::class && $user->liked($content);
    }
}
