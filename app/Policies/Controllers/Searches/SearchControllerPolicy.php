<?php

namespace App\Policies\Controllers\Searches;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can perform an action.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function perform(User $user, Controller $controller)
    {
        return $user->isAdvertiser() || $user->isContentCreator();
    }
}
