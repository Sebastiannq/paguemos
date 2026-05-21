<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Staff (Administradores y Empleados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.staff'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard.staff');

    // AJAX — buscar prenda por código de barras
    Route::get('/dashboard/prenda/buscar/{codigo_barras}', [ProductoController::class, 'buscarPorCodigo'])->name('prenda.buscar');

    // CRUD Prendas
    Route::post('/dashboard/prenda', [ProductoController::class, 'store'])->name('prenda.store');
    Route::put('/dashboard/prenda/{codigo_barras}', [ProductoController::class, 'update'])->name('prenda.update');
    Route::delete('/dashboard/prenda/{codigo_barras}', [ProductoController::class, 'destroy'])->name('prenda.destroy');

    // Ventas / Operaciones
    Route::post('/dashboard/venta', [VentaController::class, 'store'])->name('venta.store');

    // CRUD Usuarios
    Route::post('/dashboard/usuario', [UsuarioController::class, 'store'])->name('usuario.store');
    Route::put('/dashboard/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::delete('/dashboard/usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

});

/*
|--------------------------------------------------------------------------
| Clientes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.client'])->group(function () {

    Route::get('/tienda', [ProductoController::class, 'catalog'])->name('client.home');

    Route::get('/carrito', function () {
        return view('client.cart');
    })->name('client.cart');

    Route::get('/perfil', function () {
        return view('client.profile');
    })->name('client.profile');

});