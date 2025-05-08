<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/recent', [PostController::class, 'recent'])->name('posts.recent');
Route::get('/posts/author/{author}', [PostController::class, 'byAuthor'])->name('posts.by-author');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/verify-functionality', [PostController::class, 'verifyFunctionality'])->name('verify.functionality');
