<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/storeUser', [AuthController::class, 'store'])->name('storeUser');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginUser'])->name('loginUser');

Route::middleware('checkUser')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/submitPost', [PostController::class, 'submitPost'])->name('submitPost');

    Route::get('/viewPost/{postId}', [PostController::class, 'viewPost'])->name('viewPost');
    Route::put('/editPost/{postId}', [PostController::class, 'editPost'])->name('editPost');
    Route::delete('/deletePost/{postId}', [PostController::class, 'deletePost'])->name('deletePost');
});