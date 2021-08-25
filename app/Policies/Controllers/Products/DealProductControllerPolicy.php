<?php

namespace App\Policies\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealProductControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Controller $controller, Deal $deal)
    {
        return $deal->authorize($user);
    }

    /**
     * Determine whether the user can view a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Controller $controller, Deal $deal)
    {
        return $deal->authorize($user);
    }

    /**
     * Determine whether the user can create a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Controller $controller, Deal $deal)
    {
        return $deal->authorize($user);
    }

    /**
     * Determine whether the user can update a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Controller $controller, Deal $deal)
    {
        return $deal->owner instanceof Advertiser && $deal->authorize($user);
    }

    /**
     * Determine whether the user can delete a model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Controller $controller, Deal $deal)
    {
        return $deal->owner instanceof Advertiser && $deal->authorize($user);
    }
}
