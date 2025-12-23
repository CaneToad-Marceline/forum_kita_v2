<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModeratorApiController;

// Public Auth Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Auth Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Moderator API Routes (Protected - requires authentication and moderator role)
Route::middleware(['auth:sanctum', 'moderator'])->prefix('moderator')->group(function () {
    
    // Get all users with post count
    Route::get('/users', [ModeratorApiController::class, 'getUsers']);
    
    // Get specific user's posts
    Route::get('/users/{id}/posts', [ModeratorApiController::class, 'getUserPosts']);
    
    // Delete any post (moderator power)
    Route::delete('/posts/{id}', [ModeratorApiController::class, 'deletePost']);
    
    // Get forum statistics
    Route::get('/stats', [ModeratorApiController::class, 'getStats']);
    
    // Export user posts as JSON
    Route::get('/users/{id}/export', [ModeratorApiController::class, 'exportUserPosts']);
    
});