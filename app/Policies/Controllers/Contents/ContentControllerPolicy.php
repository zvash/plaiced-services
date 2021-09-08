<?php

namespace App\Policies\Controllers\Contents;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Controller $controller, Content $content)
    {
        return $content->contentCreator->user->is($user);
    }
}
