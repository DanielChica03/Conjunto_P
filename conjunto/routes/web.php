<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\productoscontroller;
use App\Http\Controllers\inventariocontroller;
use App\Http\Controllers\proveedorescontroller;
use App\Http\Controllers\movimientoscontroller;
use App\Http\Controllers\Auth\LoginManualController;
use App\Http\Controllers\comprascontroller;
use App\Http\Controllers\ventascontroller;
use App\Http\Controllers\deudacontroller;
use App\Http\Controllers\pagoscontroller;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginManualController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::resource('usuarios',UsuariosController::class);
Route::resource('productos',productoscontroller::class);
Route::resource('inventario',inventariocontroller::class);
Route::resource('proveedores', proveedorescontroller::class)->parameters([
    'proveedores' => 'proveedor',
]);
Route::resource('compras',comprascontroller::class);
Route::resource('ventas',ventascontroller::class);
Route::resource('deudas',deudacontroller::class);
Route::resource('pagos',pagoscontroller::class);

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin');
})->name('dashboard.admin');
Route::get('/admin/index', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/dashboard/cajero', function () {
    return view('dashboard.cajero');
})->name('dashboard.cajero');

Route::get('/dashboard/cliente', function () {
    return view('dashboard.cliente');
})->name('dashboard.cliente');


