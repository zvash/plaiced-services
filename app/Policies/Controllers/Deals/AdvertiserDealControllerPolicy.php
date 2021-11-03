<?php

namespace App\Policies\Controllers\Deals;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertiserDealControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Controller $controller, Advertiser $advertiser)
    {
        return $user->class === Advertiser::class && $advertiser->user->is($user);
    }
}
