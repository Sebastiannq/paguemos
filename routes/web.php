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

    // Dashboard Principal (Administrador)
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard.staff');

    // NUEVA: Dashboard Exclusivo para Empleados
    Route::get('/empleado/home', [ProductoController::class, 'indexEmpleado'])->name('empleado.home');
    // Ruta para guardar un apartado desde el panel del empleado
Route::post('/empleado/apartados/guardar', [ProductoController::class, 'storeApartado'])->name('apartados.store');

    // NUEVA: AJAX — Verificar si un código de barras ya existe al crear producto
    Route::get('/dashboard/prenda/verificar-codigo', [ProductoController::class, 'verificarCodigo'])->name('prenda.verificar');

    // AJAX — Buscar prenda por código de barras (Para el módulo de ventas/apartados)
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

Route::get('/dashboard/prenda/buscar/{codigo_barras}', [ProductoController::class, 'buscarPorCodigo']);
Route::get('/dashboard/cliente/buscar/{correo}', [ProductoController::class, 'buscarClientePorCorreo']);