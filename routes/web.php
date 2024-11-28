<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Redirect to login if user is not authenticated
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

// Login and Logout Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Dashboard Route with the DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Protect routes based on roles
Route::middleware('auth')->group(function () {
    // Admin can create, edit, and delete posts
    Route::get('create-post', [PostController::class, 'create'])->middleware('role:Admin');
    Route::post('create-post', [PostController::class, 'store'])->middleware('role:Admin');
    Route::get('edit-post/{post}', [PostController::class, 'edit'])->middleware('role:Admin');
    Route::put('edit-post/{post}', [PostController::class, 'update'])->middleware('role:Admin');

    Route::get('/posts/create', [PostController::class, 'create'])->name('create-post');
    Route::post('/posts/create', [PostController::class, 'store'])->name('store-post');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('edit-post');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('update-post');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('edit-post');

    // routes/web.php
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('delete-post');


    // Index route for showing posts
    Route::get('/posts', [PostController::class, 'index'])->name('post.index');


    // Moderator can only edit posts
    Route::get('edit-post/{post}', [PostController::class, 'edit'])->middleware('role:Moderator');
    Route::put('edit-post/{post}', [PostController::class, 'update'])->middleware('role:Moderator');

    // All logged-in users (Admin, Moderator, User) can view posts
    Route::get('posts', [PostController::class, 'index'])->name('view-posts');
});
