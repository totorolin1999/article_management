<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Articles
Route::get('articles', [ArticleController::class, 'index']);
Route::post('articles', [ArticleController::class, 'store']);
Route::get('articles/{id}', [ArticleController::class, 'show']);
Route::get('articles/{id}/edit', [ArticleController::class, 'edit']);
Route::put('articles/{id}', [ArticleController::class, 'update']);
Route::put('articles/{id}/edit', [ArticleController::class, 'update']); // 相容舊路由
Route::delete('articles/{id}', [ArticleController::class, 'destroy']);
Route::delete('articles/{id}/delete', [ArticleController::class, 'destroy']); // 相容舊路由

// Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::get('categories/{id}/edit', [CategoryController::class, 'edit']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::put('categories/{id}/edit', [CategoryController::class, 'update']); // 相容舊路由
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
Route::delete('categories/{id}/delete', [CategoryController::class, 'destroy']); // 相容舊路由

// Tags
Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tags/{id}', [TagController::class, 'show']);
Route::get('tags/{id}/edit', [TagController::class, 'edit']);
Route::put('tags/{id}', [TagController::class, 'update']);
Route::put('tags/{id}/edit', [TagController::class, 'update']); // 相容舊路由
Route::delete('tags/{id}', [TagController::class, 'destroy']);
Route::delete('tags/{id}/delete', [TagController::class, 'destroy']); // 相容舊路由
