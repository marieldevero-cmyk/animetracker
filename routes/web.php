<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/anime', [AnimeController::class, 'index'])->name('anime.index');
    Route::get('/anime/favorites', [AnimeController::class, 'favorites'])->name('anime.favorites');
    Route::get('/anime/watch-list', [AnimeController::class, 'watchList'])->name('anime.watch-list');
    Route::get('/anime/watched', [AnimeController::class, 'watched'])->name('anime.watched');
    Route::get('/anime/{anime}', [AnimeController::class, 'show'])->name('anime.show');
    Route::post('/anime', [AnimeController::class, 'store'])->name('anime.store');
    Route::get('/anime/{anime}/edit', [AnimeController::class, 'edit'])->name('anime.edit');
    Route::put('/anime/{anime}', [AnimeController::class, 'update'])->name('anime.update');
    Route::delete('/anime/{anime}', [AnimeController::class, 'destroy'])->name('anime.destroy');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
