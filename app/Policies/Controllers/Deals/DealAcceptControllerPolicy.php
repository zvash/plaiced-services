<?php

namespace App\Policies\Controllers\Deals;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealAcceptControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can accept the deal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function perform(User $user, Controller $controller, Deal $deal)
    {
        return $deal->isPending()
            && $deal->owner->user->isNot($user)
            && $deal->authorize($user);
    }
}
