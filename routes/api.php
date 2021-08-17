<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BrandPaymentController;
use App\Http\Controllers\Api\CommunityNewsController;
use App\Http\Controllers\Api\ContentCreatorSurveyController;
use App\Http\Controllers\Api\ContentPaymentController;
use App\Http\Controllers\Api\DealPaymentController;
use App\Http\Controllers\Api\DealPostController;
use App\Http\Controllers\Api\DealProductController;
use App\Http\Controllers\Api\DealSurveyController;
use App\Http\Controllers\Api\DealTimelineController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SpotlightController;
use App\Http\Controllers\Api\WishlistController;
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

Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('read', [NotificationController::class, 'read'])->name('read');
});

Route::apiResource('wishlists', WishlistController::class)->only('store');
Route::apiResource('blogs', BlogController::class)->only('index', 'show');
Route::apiResource('pages', PageController::class)->only('index', 'show');
Route::apiResource('spotlights', SpotlightController::class)->only('index');
Route::apiResource('payments', PaymentController::class)->only('index', 'show');
Route::apiResource('sections', SectionController::class)->only('index', 'show');
Route::apiResource('resources', ResourceController::class)->only('index', 'show');
Route::apiResource('community-news', CommunityNewsController::class)->only('index', 'show');

Route::apiResource('deals.products', DealProductController::class)->shallow();
Route::apiResource('deals.payments', DealPaymentController::class)->only('index', 'store');
Route::apiResource('deals.posts', DealPostController::class)->shallow()->only('store', 'destroy');
Route::apiResource('deals.timelines', DealTimelineController::class)->shallow()->only('index', 'show');
Route::apiResource('deals.surveys', DealSurveyController::class)->only('index', 'store');
Route::apiResource('brands.payments', BrandPaymentController::class)->only('index');
Route::apiResource('contents.payments', ContentPaymentController::class)->only('index');
Route::apiResource('content-creators.surveys', ContentCreatorSurveyController::class)->only('index');
