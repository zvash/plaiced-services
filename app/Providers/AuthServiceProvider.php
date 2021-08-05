<?php

namespace App\Providers;

use App\Http\Controllers\Api\DealPostController;
use App\Http\Controllers\Api\DealProductController;
use App\Http\Controllers\Api\DealTimelineController;
use App\Policies\Controllers\DealPostControllerPolicy;
use App\Policies\Controllers\DealProductControllerPolicy;
use App\Policies\Controllers\DealTimelineControllerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DealPostController::class => DealPostControllerPolicy::class,
        DealProductController::class => DealProductControllerPolicy::class,
        DealTimelineController::class => DealTimelineControllerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
