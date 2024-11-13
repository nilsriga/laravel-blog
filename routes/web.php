<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Publicly accessible route for posts (also accessible to authenticated users)
Route::get('/', [PostController::class, 'index'])->name('home');

// Authenticated-only routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class)->except(['index']); // All post routes except index are protected
    Route::resource('comments', CommentController::class);
});

Route::get('/categories/{category}', [PostController::class, 'category'])->name('categories.posts');

Route::get('/search', [PostController::class, 'search'])->name('search');

require __DIR__.'/auth.php';
