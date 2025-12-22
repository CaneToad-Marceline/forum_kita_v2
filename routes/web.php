<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ModeratorController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

//  Public Feed (everyone can view all posts)
Route::get('/dashboard', function() {
    $posts = \App\Models\Post::with('user')->latest()->get();
    return view('dashboard', compact('posts'));
})->name('dashboard');

Route::middleware(['auth', 'moderator'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/', [ModeratorController::class, 'index'])->name('index');
    Route::get('/user/{user}/posts', [ModeratorController::class, 'viewUserPosts'])->name('user.posts');
    Route::get('/user/{user}/export', [ModeratorController::class, 'exportUserPosts'])->name('user.export');
});

//  Authenticated users only
Route::middleware(['auth', 'verified'])->group(function () {
    
    // CRUD for user's own posts
    Route::resource('posts', PostController::class)->except(['show']);
    
    // Comments (create, update, delete)
    Route::resource('comments', CommentController::class)
        ->only(['store', 'update', 'destroy']);
    
    // Profile management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
