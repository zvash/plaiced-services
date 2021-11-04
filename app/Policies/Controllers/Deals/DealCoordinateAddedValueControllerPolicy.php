<?php

namespace App\Policies\Controllers\Deals;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealCoordinateAddedValueControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can request coordinate added value.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function perform(User $user, Controller $controller, Deal $deal)
    {
        return $user->isContentCreator()
            && $deal->isActive()
            && $deal->authorize($user)
            && is_null($deal->coordinate_added_value);
    }
}
