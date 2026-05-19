<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas de la Aplicación
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Login, Registro y Cierre de Sesión)
|--------------------------------------------------------------------------
*/

// Inicio de Sesión
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.store');

// Registro de Nuevos Clientes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');

// Desconexión
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas para el Staff (Administradores y Empleados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.staff'])->group(function () {
    
    // Vista principal del Dashboard (Listado del Inventario)
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard.staff');
    
    // Operaciones CRUD para el Inventario de Prendas
    Route::post('/dashboard/prenda', [ProductoController::class, 'store'])->name('prenda.store');
    Route::put('/dashboard/prenda/{id}', [ProductoController::class, 'update'])->name('prenda.update');
    Route::delete('/dashboard/prenda/{id}', [ProductoController::class, 'destroy'])->name('prenda.destroy');
    
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas para Clientes Activos
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.client'])->group(function () {
    
    // Tienda Principal / Catálogo
    Route::get('/tienda', function () {
        return view('client.home');
    })->name('client.home');
    
    // Carrito de Compras
    Route::get('/carrito', function () {
        return view('client.cart');
    })->name('client.cart');
    
    // Perfil del Cliente
    Route::get('/perfil', function () {
        return view('client.profile');
    })->name('client.profile');
    
});