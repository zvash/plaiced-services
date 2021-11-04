<?php

namespace App\Policies\Controllers\Contents;

use App\Http\Controllers\Controller;
use App\Models\ContentCreator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentCreatorContentControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Controller $controller, ContentCreator $contentCreator)
    {
        return $user->isContentCreator() && $contentCreator->user->is($user);
    }
}
