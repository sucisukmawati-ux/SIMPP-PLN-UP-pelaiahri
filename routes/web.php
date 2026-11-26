<?php

use App\Http\Controllers\Auth\NameVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])
        ->middleware('throttle:password-reset')
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])
        ->middleware('throttle:password-reset')
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/name/verify', [NameVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/name/verify/{id}/{hash}', [NameVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/name/verification-notification', [NameVerificationController::class, 'send'])
        ->middleware('throttle:verification-notification')
        ->name('verification.send');

    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');
});
