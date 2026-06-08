<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
// Esta es la ruta por defecto que ya tenías (déjala ahí quieta)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// 👇 AQUÍ PEGAS TU NUEVA RUTA PARA EL PROYECTO PAGUEMENOS 👇

// Esta es la ruta POST que tu app de Android va a buscar para registrar la ropa
Route::post('/prendas/registrar', [ProductoController::class, 'registrarPrendaDesdeAndroid']);
Route::get('/prendas/parametros', [ProductoController::class, 'obtenerParametrosPrenda']);