<?php

namespace App\Policies\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Models\ContentCreator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentCreatorFollowControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return bool
     */
    public function viewAny(User $user, Controller $controller, ContentCreator $contentCreator)
    {
        return $user->isAdvertiser() || $contentCreator->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return bool
     */
    public function create(User $user, Controller $controller, ContentCreator $contentCreator)
    {
        return $user->isAdvertiser() && ! $user->followed($contentCreator);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return bool
     */
    public function delete(User $user, Controller $controller, ContentCreator $contentCreator)
    {
        return $user->isAdvertiser() && $user->followed($contentCreator);
    }
}
