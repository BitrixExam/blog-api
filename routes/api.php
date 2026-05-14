<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'showPosts']);
    Route::post('/post', [PostController::class, 'storePost']);
    Route::get('/posts/me', [PostController::class, 'showMyPosts']);
});