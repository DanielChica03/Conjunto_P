<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('can:admin-only');
});

// CAJERO
Route::middleware(['auth'])->group(function () {
    Route::get('/cajero/dashboard', [App\Http\Controllers\Cajero\DashboardController::class, 'index'])
        ->name('cajero.dashboard');
});

// CLIENTE
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/dashboard', [App\Http\Controllers\Cliente\DashboardController::class, 'index'])
        ->name('cliente.dashboard');
});