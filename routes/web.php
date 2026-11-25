<?php

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

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:verification-notification')
        ->name('verification.send');

    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/pelanggan/lokasi', [PelangganController::class, 'locations'])->name('pelanggan.locations');
Route::get('/pelanggan/kelola', fn () => redirect()->route('pelanggan.index'))->name('pelanggan.manage');
Route::get('/pelanggan/edit', fn () => redirect()->route('pelanggan.index'));
Route::get('/pelanggan/import', [PelangganController::class, 'importForm'])->name('pelanggan.import.form');
Route::post('/pelanggan/import', [PelangganController::class, 'import'])->name('pelanggan.import');
Route::get('/pelanggan/notifikasi', [PelangganController::class, 'notifications'])->name('pelanggan.notifications');

Route::resource('pelanggan', PelangganController::class)->only([
    'index',
    'show',
    'store',
    'update',
    'destroy',
]);
