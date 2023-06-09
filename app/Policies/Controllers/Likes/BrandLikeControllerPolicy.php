<?php

namespace App\Policies\Controllers\Likes;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandLikeControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Brand  $brand
     * @return bool
     */
    public function viewAny(User $user, Controller $controller, Brand $brand)
    {
        return $user->isContentCreator() || $brand->advertiser->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Brand  $brand
     * @return bool
     */
    public function create(User $user, Controller $controller, Brand $brand)
    {
        return $user->isContentCreator() && ! $user->liked($brand);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Brand  $brand
     * @return bool
     */
    public function delete(User $user, Controller $controller, Brand $brand)
    {
        return $user->isContentCreator() && $user->liked($brand);
    }
}
