<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    $username = auth()->check()
        ? ucfirst(auth()->user()->username)
        : null;

    return view('welcome', compact('username'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin-only ruta
    Route::middleware('superuser')->get('/admin', function () {
        return view('admin');
    })->name('admin');
});
