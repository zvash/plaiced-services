<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommunityNewsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SpotlightController;
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

Route::apiResource('blogs', BlogController::class)->only('index', 'show');
Route::apiResource('pages', PageController::class)->only('index', 'show');
Route::apiResource('spotlights', SpotlightController::class)->only('index');
Route::apiResource('sections', SectionController::class)->only('index', 'show');
Route::apiResource('community-news', CommunityNewsController::class)->only('index', 'show');
