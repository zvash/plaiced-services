<?php

namespace App\Providers;

use App\Http\Controllers\Api\BrandPaymentController;
use App\Http\Controllers\Api\ContentPaymentController;
use App\Http\Controllers\Api\DealPaymentController;
use App\Http\Controllers\Api\DealPostController;
use App\Http\Controllers\Api\DealProductController;
use App\Http\Controllers\Api\DealTimelineController;
use App\Http\Controllers\Api\PaymentController;
use App\Policies\Controllers\BrandPaymentControllerPolicy;
use App\Policies\Controllers\ContentPaymentControllerPolicy;
use App\Policies\Controllers\DealPaymentControllerPolicy;
use App\Policies\Controllers\DealPostControllerPolicy;
use App\Policies\Controllers\DealProductControllerPolicy;
use App\Policies\Controllers\DealTimelineControllerPolicy;
use App\Policies\Controllers\PaymentControllerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        PaymentController::class => PaymentControllerPolicy::class,
        DealPostController::class => DealPostControllerPolicy::class,
        DealProductController::class => DealProductControllerPolicy::class,
        DealPaymentController::class => DealPaymentControllerPolicy::class,
        DealTimelineController::class => DealTimelineControllerPolicy::class,
        BrandPaymentController::class => BrandPaymentControllerPolicy::class,
        ContentPaymentController::class => ContentPaymentControllerPolicy::class,
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
