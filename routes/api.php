<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsApiController;
use App\Http\Controllers\PostController;
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
Route::middleware('auth.optional')->group(function () {
    Route::apiResource('news', NewsApiController::class)->scoped(['news' => 'slug'])->missing(function () {
        return response()->json(['message' => 'News not found'], 404);
    });
    Route::apiResource('posts', PostController::class)->scoped(['post' => 'slug'])->missing(function () {
        return response()->json(['message' => 'Post not found'], 404);
    });
    Route::apiResource('posts.comments', CommentController::class)->scoped(['post' => 'slug', 'comment' => 'id'])->missing(function () {
        return response()->json(['message' => 'Post or comment not found'], 404);
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthApiController::class, 'login']);
    Route::get('/register', [AuthApiController::class, 'register']);
    Route::get('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
});
Route::get('/profile', [AuthApiController::class, 'profile'])->middleware('auth:sanctum');
