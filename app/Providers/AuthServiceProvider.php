<?php

namespace App\Providers;

use App\Http\Controllers\Api\Brands\AdvertiserBrandController;
use App\Http\Controllers\Api\Brands\BrandController;
use App\Http\Controllers\Api\Contents\ContentController;
use App\Http\Controllers\Api\Contents\ContentCreatorContentController;
use App\Http\Controllers\Api\Follows\AdvertiserFollowController;
use App\Http\Controllers\Api\Follows\ContentCreatorFollowController;
use App\Http\Controllers\Api\Likes\BrandLikeController;
use App\Http\Controllers\Api\Likes\ContentLikeController;
use App\Http\Controllers\Api\Payments\BrandPaymentController;
use App\Http\Controllers\Api\Payments\ContentPaymentController;
use App\Http\Controllers\Api\Payments\DealPaymentController;
use App\Http\Controllers\Api\Payments\PaymentController;
use App\Http\Controllers\Api\Posts\DealPostController;
use App\Http\Controllers\Api\Products\DealProductController;
use App\Http\Controllers\Api\Surveys\DealSurveyController;
use App\Http\Controllers\Api\Timelines\DealTimelineController;
use App\Policies\Controllers\Brands\AdvertiserBrandControllerPolicy;
use App\Policies\Controllers\Brands\BrandControllerPolicy;
use App\Policies\Controllers\Contents\ContentControllerPolicy;
use App\Policies\Controllers\Contents\ContentCreatorContentControllerPolicy;
use App\Policies\Controllers\Follows\AdvertiserFollowControllerPolicy;
use App\Policies\Controllers\Follows\ContentCreatorFollowControllerPolicy;
use App\Policies\Controllers\Likes\BrandLikeControllerPolicy;
use App\Policies\Controllers\Likes\ContentLikeControllerPolicy;
use App\Policies\Controllers\Payments\BrandPaymentControllerPolicy;
use App\Policies\Controllers\Payments\ContentPaymentControllerPolicy;
use App\Policies\Controllers\Payments\DealPaymentControllerPolicy;
use App\Policies\Controllers\Payments\PaymentControllerPolicy;
use App\Policies\Controllers\Posts\DealPostControllerPolicy;
use App\Policies\Controllers\Products\DealProductControllerPolicy;
use App\Policies\Controllers\Surveys\DealSurveyControllerPolicy;
use App\Policies\Controllers\Timelines\DealTimelineControllerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        BrandController::class => BrandControllerPolicy::class,
        ContentController::class => ContentControllerPolicy::class,
        PaymentController::class => PaymentControllerPolicy::class,
        DealPostController::class => DealPostControllerPolicy::class,
        BrandLikeController::class => BrandLikeControllerPolicy::class,
        DealSurveyController::class => DealSurveyControllerPolicy::class,
        ContentLikeController::class => ContentLikeControllerPolicy::class,
        DealProductController::class => DealProductControllerPolicy::class,
        DealPaymentController::class => DealPaymentControllerPolicy::class,
        DealTimelineController::class => DealTimelineControllerPolicy::class,
        BrandPaymentController::class => BrandPaymentControllerPolicy::class,
        ContentPaymentController::class => ContentPaymentControllerPolicy::class,
        AdvertiserBrandController::class => AdvertiserBrandControllerPolicy::class,
        AdvertiserFollowController::class => AdvertiserFollowControllerPolicy::class,
        ContentCreatorFollowController::class => ContentCreatorFollowControllerPolicy::class,
        ContentCreatorContentController::class => ContentCreatorContentControllerPolicy::class,
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
