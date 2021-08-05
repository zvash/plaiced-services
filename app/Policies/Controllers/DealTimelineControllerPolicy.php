<?php

namespace App\Policies\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealTimelineControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return mixed
     */
    public function viewAny(User $user, Controller $controller, Deal $deal)
    {
        return $deal->owner->user->is($user);
    }

    /**
     * Determine whether the user can view a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return mixed
     */
    public function view(User $user, Controller $controller, Deal $deal)
    {
        return $deal->owner->user->is($user);
    }
}
