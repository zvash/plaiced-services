<?php

use App\Http\Controllers\Api\Advertisers\AdvertiserController;
use App\Http\Controllers\Api\Blogs\BlogController;
use App\Http\Controllers\Api\Brands\AdvertiserBrandController;
use App\Http\Controllers\Api\Brands\BrandCategoryController;
use App\Http\Controllers\Api\Brands\BrandController;
use App\Http\Controllers\Api\CommunityNews\CommunityNewsController;
use App\Http\Controllers\Api\ContentCreators\ContentCreatorController;
use App\Http\Controllers\Api\Contents\ContentCategoryController;
use App\Http\Controllers\Api\Contents\ContentController;
use App\Http\Controllers\Api\Contents\ContentCreatorContentController;
use App\Http\Controllers\Api\Countries\CountryController;
use App\Http\Controllers\Api\Deals\DealAcceptController;
use App\Http\Controllers\Api\Deals\DealCancelController;
use App\Http\Controllers\Api\Deals\DealController;
use App\Http\Controllers\Api\Deals\DealCoordinateAddedValueController;
use App\Http\Controllers\Api\Deals\DealMediaAccountabilityController;
use App\Http\Controllers\Api\Deals\DealRejectController;
use App\Http\Controllers\Api\Deals\DealShippingController;
use App\Http\Controllers\Api\DropdownGroups\DropdownGroupController;
use App\Http\Controllers\Api\Follows\AdvertiserFollowController;
use App\Http\Controllers\Api\Follows\ContentCreatorFollowController;
use App\Http\Controllers\Api\Follows\FollowController;
use App\Http\Controllers\Api\Follows\UserFollowController;
use App\Http\Controllers\Api\Likes\BrandLikeController;
use App\Http\Controllers\Api\Likes\ContentLikeController;
use App\Http\Controllers\Api\Likes\LikeController;
use App\Http\Controllers\Api\Likes\UserLikeController;
use App\Http\Controllers\Api\Notifications\NotificationController;
use App\Http\Controllers\Api\Pages\PageController;
use App\Http\Controllers\Api\Payments\BrandPaymentController;
use App\Http\Controllers\Api\Payments\ContentPaymentController;
use App\Http\Controllers\Api\Payments\DealPaymentController;
use App\Http\Controllers\Api\Payments\PaymentController;
use App\Http\Controllers\Api\Posts\DealPostController;
use App\Http\Controllers\Api\Products\DealProductController;
use App\Http\Controllers\Api\Resources\ResourceController;
use App\Http\Controllers\Api\Searches\SearchController;
use App\Http\Controllers\Api\Sections\SectionController;
use App\Http\Controllers\Api\Spotlights\SpotlightController;
use App\Http\Controllers\Api\Surveys\AdvertiserSurveyController;
use App\Http\Controllers\Api\Surveys\BrandSurveyController;
use App\Http\Controllers\Api\Surveys\ContentCreatorSurveyController;
use App\Http\Controllers\Api\Surveys\ContentSurveyController;
use App\Http\Controllers\Api\Surveys\DealSurveyController;
use App\Http\Controllers\Api\Timelines\DealTimelineController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Users\UserPasswordController;
use App\Http\Controllers\Api\Users\UserVerificationController;
use App\Http\Controllers\Api\Wishlists\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('email/verify/{id}/{hash}', [UserVerificationController::class, 'verify'])->name('verification.verify');

// User routes
Route::prefix('users')->name('users.')->group(function () {
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::put('/', [UserController::class, 'update'])->name('update');
    Route::get('me', [UserController::class, 'show'])->name('show');

    Route::put('password', [UserPasswordController::class, 'update'])->name('change-password');
    Route::post('verify/resend', [UserVerificationController::class, 'resend'])->name('verification.send');
});

// Notification routes
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('read', [NotificationController::class, 'read'])->name('read');
});

// Website routes
Route::apiResource('countries', CountryController::class)->only('index');
Route::apiResource('blogs', BlogController::class)->only('index', 'show');
Route::apiResource('pages', PageController::class)->only('index', 'show');
Route::apiResource('spotlights', SpotlightController::class)->only('index');
Route::apiResource('sections', SectionController::class)->only('index', 'show');

// Resource routes
Route::apiResource('resources', ResourceController::class)->only('index', 'show');

// Wishlist routes
Route::apiResource('wishlists', WishlistController::class)->only('store');

// Community news routes
Route::apiResource('community-news', CommunityNewsController::class)->only('index', 'show');

// Product routes
Route::apiResource('deals.products', DealProductController::class)->shallow();

// Post routes
Route::apiResource('deals.posts', DealPostController::class)->shallow()->only('store', 'destroy');

// Timeline routes
Route::apiResource('deals.timelines', DealTimelineController::class)->shallow()->only('index', 'show');

// Payment routes
Route::apiResource('payments', PaymentController::class)->only('index', 'show');
Route::apiResource('brands.payments', BrandPaymentController::class)->only('index');
Route::apiResource('contents.payments', ContentPaymentController::class)->only('index');
Route::apiResource('deals.payments', DealPaymentController::class)->only('index', 'store');

// Survey routes
Route::apiResource('deals.surveys', DealSurveyController::class)->only('index', 'store');
Route::apiResource('brands.surveys', BrandSurveyController::class)->only('index');
Route::apiResource('contents.surveys', ContentSurveyController::class)->only('index');
Route::apiResource('advertisers.surveys', AdvertiserSurveyController::class)->only('index');
Route::apiResource('content-creators.surveys', ContentCreatorSurveyController::class)->only('index');

// Like routes
Route::delete('contents/{content}/likes', [ContentLikeController::class, 'destroy']);
Route::delete('brands/{brand}/likes', [BrandLikeController::class, 'destroy']);
Route::apiResource('contents.likes', ContentLikeController::class)->only('index', 'store');
Route::apiResource('brands.likes', BrandLikeController::class)->only('index', 'store');
Route::apiResource('users.likes', UserLikeController::class)->only('index');
Route::apiResource('likes', LikeController::class)->only('index');

// Follow routes
Route::delete('content-creators/{content_creator}/follows', [ContentCreatorFollowController::class, 'destroy']);
Route::delete('advertisers/{advertiser}/follows', [AdvertiserFollowController::class, 'destroy']);
Route::apiResource('content-creators.follows', ContentCreatorFollowController::class)->only('index', 'store');
Route::apiResource('advertisers.follows', AdvertiserFollowController::class)->only('index', 'store');
Route::apiResource('users.follows', UserFollowController::class)->only('index');
Route::apiResource('follows', FollowController::class)->only('index');

// Content routes
Route::prefix('contents/categories')->name('contents.categories.')->group(function () {
    Route::get('/', [ContentCategoryController::class, 'index'])->name('index');
    Route::get('{dropdown}', [ContentCategoryController::class, 'show'])->name('show');
});
Route::apiResource('contents', ContentController::class)->only('index', 'show', 'destroy');
Route::apiResource('content-creators.contents', ContentCreatorContentController::class)->only('index', 'store');

// Brand routes
Route::prefix('brands/categories')->name('brands.categories.')->group(function () {
    Route::get('/', [BrandCategoryController::class, 'index'])->name('index');
    Route::get('{dropdown}', [BrandCategoryController::class, 'show'])->name('show');
});
Route::apiResource('brands', BrandController::class)->only('index', 'show', 'destroy');
Route::apiResource('advertisers.brands', AdvertiserBrandController::class)->only('index', 'store');

// Dropdown group routes
Route::apiResource('dropdown-groups.dropdowns', DropdownGroupController::class)->only('index', 'store');

// Deal routes
Route::prefix('deals/{deal}')->name('deals.')->group(function () {
    Route::patch('accept', DealAcceptController::class)->name('accept');
    Route::patch('reject', DealRejectController::class)->name('reject');
    Route::patch('cancel', DealCancelController::class)->name('cancel');
    Route::patch('coordinate', DealCoordinateAddedValueController::class)->name('coordinate');
    Route::patch('accountability', DealMediaAccountabilityController::class)->name('accountability');
    Route::patch('shipping', DealShippingController::class)->name('shipping');
});
Route::apiResource('deals', DealController::class)->except('destroy');

// Content creator routes
Route::apiResource('content-creators', ContentCreatorController::class)->only('index', 'show');

// Advertiser routes
Route::apiResource('advertisers', AdvertiserController::class)->only('index', 'show');

// Search routes
Route::get('search', SearchController::class)->name('search');
