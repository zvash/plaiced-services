<?php

namespace App\Policies\Controllers\Deals;

use App\Http\Controllers\Controller;
use App\Models\ContentCreator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentCreatorDealControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Controller $controller, ContentCreator $contentCreator)
    {
        return $user->class === ContentCreator::class && $contentCreator->user->is($user);
    }
}
