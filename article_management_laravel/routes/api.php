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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles', [ArticleController::class, 'index']);
Route::post('articles', [ArticleController::class, 'store']);
Route::get('articles/{id}', [ArticleController::class, 'show']);
Route::get('articles/{id}/edit', [ArticleController::class, 'edit']);
Route::put('articles/{id}/edit', [ArticleController::class, 'update']);
Route::delete('articles/{id}/delete', [ArticleController::class, 'destroy']);

Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::get('categories/{id}/edit', [CategoryController::class, 'edit']);
Route::put('categories/{id}/edit', [CategoryController::class, 'update']);
Route::delete('categories/{id}/delete', [CategoryController::class, 'destroy']);

Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tags/{id}', [TagController::class, 'show']);
Route::get('tags/{id}/edit', [TagController::class, 'edit']);
Route::put('tags/{id}/edit', [TagController::class, 'update']);
Route::delete('tags/{id}/delete', [TagController::class, 'destroy']);
