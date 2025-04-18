<?php

use App\Http\Controllers\Auth\ChangePassword;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Home\PrincipalController;
use App\Http\Controllers\Home\DeudaConsolidadaController;
use App\Http\Controllers\Home\DetalladoController;
use App\Http\Controllers\Home\HRController;
use App\Http\Controllers\Home\ReporteController;
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
    //CERRAR SESION
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    //CAMBIAR CLAVE
    //formulario
    Route::get('/cambiarClave',[ChangePassword::class, 'formCambiarClave'])->name('cambiarClave');

    //cambio de clave
    Route::post('/cambiarClave',[ChangePassword::class, 'cambiarClave']);

    //PANTALLA PRINCIPAL
    Route::get('/principal', [PrincipalController::class, 'viewPrincipal'])->name('principal');

    ///CONSOLIDADO
    // Muestra vista inicial
    Route::get('/consolidado', [DeudaConsolidadaController::class, 'index'])->name('consolidado');

    Route::post('/consolidado', [DeudaConsolidadaController::class, 'index'])->name('consolidado');

    // Filtrar deudas por año y tipo
    Route::post('/consolidado/filtrar', [DeudaConsolidadaController::class, 'filtrar'])->name('consolidado.filtrar');

    // Imprimir deudas
    Route::get('/consolidado/imprimir', [DeudaConsolidadaController::class, 'imprimir'])->name('consolidado.imprimir');

    // Preparar pago de deudas seleccionadas
    Route::post('/consolidado/pagar', [DeudaConsolidadaController::class, 'prepararPago'])->name('consolidado.preparar-pago');

    // Vista de pago (esta ruta debería ir a un controlador de pagos)
    Route::get('/consolidado/pago', function () {return redirect()->route('pagos.index');})->name('consolidado.pago');


    //DETALLADO
    // Muestra resources/views/about.blade.php
    Route::get('/detallado', [DetalladoController::class, 'index'])->name('detallado');

    Route::post('/detallado', [DetalladoController::class, 'index'])->name('detallado');

    // Filtrar deudas por año y tipo
    Route::post('/detallado/filtrar', [DetalladoController::class, 'filtrar'])->name('detallado.filtrar');

    // Imprimir deudas
    Route::get('/detallado/imprimir', [DetalladoController::class, 'imprimir'])->name('detallado.imprimir');

    // Preparar pago de deudas seleccionadas
    Route::post('/detallado/pagar', [DetalladoController::class, 'prepararPago'])->name('detallado.preparar-pago');

    // Vista de pago (esta ruta debería ir a un controlador de pagos)
    Route::get('/detallado/pago', function () {return redirect()->route('pagos.index');})->name('detallado.pago');



    Route::get('/HR', [HRController::class, 'index'])->name('HR');



    Route::get('/reporte/{tipo}', [ReporteController::class, 'reporte'])->name('reporte');




    Route::get('/pagos', function () {
        return view('pagos'); // Muestra resources/views/about.blade.php
    });



    Route::get('/HLA', function () {
        return view('HLA'); // Muestra resources/views/about.blade.php
    });

    Route::get('/PU', function () {
        return view('PU'); // Muestra resources/views/about.blade.php
    });
});
