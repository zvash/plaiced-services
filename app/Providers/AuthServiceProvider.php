<?php

namespace App\Providers;

use App\Http\Controllers\Api\Brands\AdvertiserBrandController;
use App\Http\Controllers\Api\Brands\BrandController;
use App\Http\Controllers\Api\Contents\ContentController;
use App\Http\Controllers\Api\Contents\ContentCreatorContentController;
use App\Http\Controllers\Api\Deals\DealAcceptController;
use App\Http\Controllers\Api\Deals\DealCancelController;
use App\Http\Controllers\Api\Deals\DealController;
use App\Http\Controllers\Api\Deals\DealCoordinateAddedValueController;
use App\Http\Controllers\Api\Deals\DealMediaAccountabilityController;
use App\Http\Controllers\Api\Deals\DealRejectController;
use App\Http\Controllers\Api\Deals\DealShippingController;
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
use App\Http\Controllers\Api\Searches\SearchController;
use App\Http\Controllers\Api\Surveys\DealSurveyController;
use App\Http\Controllers\Api\Timelines\DealTimelineController;
use App\Policies\Controllers\Brands\AdvertiserBrandControllerPolicy;
use App\Policies\Controllers\Brands\BrandControllerPolicy;
use App\Policies\Controllers\Contents\ContentControllerPolicy;
use App\Policies\Controllers\Contents\ContentCreatorContentControllerPolicy;
use App\Policies\Controllers\Deals\DealAcceptControllerPolicy;
use App\Policies\Controllers\Deals\DealCancelControllerPolicy;
use App\Policies\Controllers\Deals\DealControllerPolicy;
use App\Policies\Controllers\Deals\DealCoordinateAddedValueControllerPolicy;
use App\Policies\Controllers\Deals\DealMediaAccountabilityControllerPolicy;
use App\Policies\Controllers\Deals\DealRejectControllerPolicy;
use App\Policies\Controllers\Deals\DealShippingControllerPolicy;
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
use App\Policies\Controllers\Searches\SearchControllerPolicy;
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
        // Deals
        DealController::class => DealControllerPolicy::class,
        DealAcceptController::class => DealAcceptControllerPolicy::class,
        DealCancelController::class => DealCancelControllerPolicy::class,
        DealRejectController::class => DealRejectControllerPolicy::class,
        DealShippingController::class => DealShippingControllerPolicy::class,
        DealMediaAccountabilityController::class => DealMediaAccountabilityControllerPolicy::class,
        DealCoordinateAddedValueController::class => DealCoordinateAddedValueControllerPolicy::class,

        // Brands
        BrandController::class => BrandControllerPolicy::class,
        AdvertiserBrandController::class => AdvertiserBrandControllerPolicy::class,

        // Contents
        ContentController::class => ContentControllerPolicy::class,
        ContentCreatorContentController::class => ContentCreatorContentControllerPolicy::class,

        // Payments
        PaymentController::class => PaymentControllerPolicy::class,
        DealPaymentController::class => DealPaymentControllerPolicy::class,
        BrandPaymentController::class => BrandPaymentControllerPolicy::class,
        ContentPaymentController::class => ContentPaymentControllerPolicy::class,

        // Posts
        DealPostController::class => DealPostControllerPolicy::class,

        // Products
        DealProductController::class => DealProductControllerPolicy::class,

        // Likes
        BrandLikeController::class => BrandLikeControllerPolicy::class,
        ContentLikeController::class => ContentLikeControllerPolicy::class,

        // Follows
        AdvertiserFollowController::class => AdvertiserFollowControllerPolicy::class,
        ContentCreatorFollowController::class => ContentCreatorFollowControllerPolicy::class,

        // Surveys
        DealSurveyController::class => DealSurveyControllerPolicy::class,

        // Timelines
        DealTimelineController::class => DealTimelineControllerPolicy::class,

        // Searches
        SearchController::class => SearchControllerPolicy::class,
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
