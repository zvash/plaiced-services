<?php

namespace App\Policies\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Controller $controller, Brand $brand)
    {
        return $brand->advertiser->user->is($user);
    }
}
