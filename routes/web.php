<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OAuthController;
use App\Http\Middleware\SuggestionManager;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/news', [NewsController::class, 'getList'])->name('news_list');
Route::get('/news/{slug}', [NewsController::class, 'getDetails'])->name('news_item');
Route::get('/appeal', [AppealController::class, 'handleGet'])->name('appeal')->withoutMiddleware([SuggestionManager::class]);
Route::post('/appeal', [AppealController::class, 'handlePost'])->name('appeal_post')->withoutMiddleware([SuggestionManager::class]);
Route::prefix('/auth')->group(function () {
    Route::match(['GET', 'POST'], '/login', [AuthWebController::class, 'login'])->name('web_login');
    Route::match(['GET', 'POST'], '/register', [AuthWebController::class, 'register'])->name('web_register');
    Route::prefix('/oauth')->group(function () {
        Route::get('/redirect', [OAuthController::class, 'redirect'])->name('oauth_redirect');
        Route::get('/callback', [OAuthController::class, 'callback'])->name('oauth_callback');
    });
    Route::get('/logout', [AuthWebController::class, 'logout'])->name('web_logout')->middleware('auth:sanctum');
});
Route::get('/profile', [AuthWebController::class, 'profile'])->name('web_profile')->middleware('auth:sanctum');
