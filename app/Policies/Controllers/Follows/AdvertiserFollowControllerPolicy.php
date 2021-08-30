<?php

namespace App\Policies\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\ContentCreator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertiserFollowControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Advertiser  $advertiser
     * @return bool
     */
    public function viewAny(User $user, Controller $controller, Advertiser $advertiser)
    {
        return $advertiser->user->is($user) || $user->class === ContentCreator::class;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Advertiser  $advertiser
     * @return bool
     */
    public function create(User $user, Controller $controller, Advertiser $advertiser)
    {
        return $user->class === ContentCreator::class && ! $user->followed($advertiser);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Advertiser  $advertiser
     * @return bool
     */
    public function delete(User $user, Controller $controller, Advertiser $advertiser)
    {
        return $user->class === ContentCreator::class && $user->followed($advertiser);
    }
}
