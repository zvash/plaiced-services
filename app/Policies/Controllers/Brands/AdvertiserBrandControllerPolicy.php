<?php

namespace App\Policies\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertiserBrandControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Controller $controller, Advertiser $advertiser)
    {
        return $user->isAdvertiser() && $advertiser->user->is($user);
    }
}
