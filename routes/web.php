<?php

use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
