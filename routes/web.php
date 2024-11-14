<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Public routes for posts
Route::get('/', [PostController::class, 'index'])->name('home');  // Index route (public)

// Authenticated-only routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post routes 
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');  // Store route
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');  // Create route
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');  // Edit route
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');  // Update route
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');  // Destroy route

    // Comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
});

// Other routes
Route::get('/categories/{category}', [PostController::class, 'category'])->name('categories.posts');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');  // Show route (public)

// Authentication routes
require __DIR__ . '/auth.php';
