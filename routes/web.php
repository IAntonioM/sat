<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Home\PrincipalController;
use App\Http\Controllers\Home\DeudaConsolidadaController;
use App\Http\Controllers\Home\DetalladoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('login');
});
*/

// REDIRIGE AL LOGIN A LO USUARIO NO LOGEUADOS
Route::middleware('guest.redirect')->group(function () {

    Route::get('/', [LoginController::class, 'formLogin'])->name('login');

    Route::post('/', [LoginController::class, 'login']);
});

// REDIRIGE A LOS USUARIO LOGUEADOS
Route::middleware('check.login')->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/principal', [PrincipalController::class, 'viewPrincipal'])->name('principal');

    //CONSOLIDADO
    // Muestra resources/views/about.blade.php
    Route::get('/consolidado', [DeudaConsolidadaController::class, 'index'])
    ->name('consolidado');

    // Filtrar deudas consolidadas (mismo método pero con POST)
    Route::post('/consolidadas', [DeudaConsolidadaController::class, 'index'])
    ->name('consolidadas.filtrar');

    // Preparar pago de deudas seleccionadas
    Route::post('/consolidadas/pagar', [DeudaConsolidadaController::class, 'prepararPago'])
    ->name('consolidadas.pagar');

    // Imprimir deudas consolidadas
    Route::get('/consolidadas/imprimir', [DeudaConsolidadaController::class, 'imprimirDeudas'])
    ->name('consolidadas.imprimir');


    //DETALLADO
    // Muestra resources/views/about.blade.php
    Route::get('/detallado', [DetalladoController::class, 'index'])->name('detallado');

    // Filtrar deudas por año y tipo
    Route::post('/detallado/filtrar', [DetalladoController::class, 'filtrar'])->name('detallado.filtrar');

    // Imprimir deudas
    Route::get('/detallado/imprimir', [DetalladoController::class, 'imprimir'])->name('detallado.imprimir');

    // Preparar pago de deudas seleccionadas
    Route::post('/detallado/pagar', [DetalladoController::class, 'prepararPago'])->name('detallado.preparar-pago');

    // Vista de pago (esta ruta debería ir a un controlador de pagos)
    Route::get('/detallado/pago', function () {
        // Redirigir a un controlador de pagos
        return redirect()->route('pagos.index');
    })->name('detallado.pago');










    Route::get('/pagos', function () {
        return view('pagos'); // Muestra resources/views/about.blade.php
    });

    Route::get('/HR', function () {
        return view('HR'); // Muestra resources/views/about.blade.php
    });

    Route::get('/HLA', function () {
        return view('HLA'); // Muestra resources/views/about.blade.php
    });

    Route::get('/PU', function () {
        return view('PU'); // Muestra resources/views/about.blade.php
    });
});
