<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\NewsController;
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
Route::group(['middleware' => ['suggestions']], function () {
    Route::get('/news', [NewsController::class, 'getList'])->name('news_list');
    Route::get('/news/{slug}', [NewsController::class, 'getDetails'])->name('news_item');
    Route::get('/', function () {
        return view('welcome');
    });
});
Route::get('/appeal', [AppealController::class, 'handleGet'])->name('appeal');
Route::post('/appeal', [AppealController::class, 'handlePost'])->name('appeal_post');
