<?php

use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(OrdenCompraController::class)->group(function() {
    Route::post('/orden_compra', 'store');
    Route::get("/orden_compra", 'index');
    Route::get("/orden_compra/filter", 'filter');
});

Route::controller(ProductoController::class)->group(function() {
    Route::get('/products', 'index');
    Route::get('/products/sugerencias', 'getSugerencias');
});

Route::controller(ClienteController::class)->group(function() {
    Route::get('/clientes/sugerencias', 'getSugerencias');
});
