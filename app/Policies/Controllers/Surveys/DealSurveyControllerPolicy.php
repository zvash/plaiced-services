<?php

namespace App\Policies\Controllers\Surveys;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealSurveyControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Controllers\Controller  $controller
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Controller $controller, Deal $deal)
    {
        return $deal->authorize($user) && $user->hasSurvey($deal)->doesntExist();
    }
}
