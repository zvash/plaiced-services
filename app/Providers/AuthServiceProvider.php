<?php

namespace App\Providers;

use App\Http\Controllers\Api\DealPostController;
use App\Http\Controllers\Api\DealProductController;
use App\Http\Controllers\Api\DealTimelineController;
use App\Http\Controllers\Api\Likes\BrandLikeController;
use App\Http\Controllers\Api\Likes\ContentLikeController;
use App\Http\Controllers\Api\Payments\BrandPaymentController;
use App\Http\Controllers\Api\Payments\ContentPaymentController;
use App\Http\Controllers\Api\Payments\DealPaymentController;
use App\Http\Controllers\Api\Payments\PaymentController;
use App\Http\Controllers\Api\Surveys\DealSurveyController;
use App\Policies\Controllers\BrandLikeControllerPolicy;
use App\Policies\Controllers\BrandPaymentControllerPolicy;
use App\Policies\Controllers\ContentLikeControllerPolicy;
use App\Policies\Controllers\ContentPaymentControllerPolicy;
use App\Policies\Controllers\DealPaymentControllerPolicy;
use App\Policies\Controllers\DealPostControllerPolicy;
use App\Policies\Controllers\DealProductControllerPolicy;
use App\Policies\Controllers\DealSurveyControllerPolicy;
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
        DealSurveyController::class => DealSurveyControllerPolicy::class,
        DealProductController::class => DealProductControllerPolicy::class,
        DealPaymentController::class => DealPaymentControllerPolicy::class,
        DealTimelineController::class => DealTimelineControllerPolicy::class,
        BrandPaymentController::class => BrandPaymentControllerPolicy::class,
        ContentPaymentController::class => ContentPaymentControllerPolicy::class,
        ContentLikeController::class => ContentLikeControllerPolicy::class,
        BrandLikeController::class => BrandLikeControllerPolicy::class,
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
