<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Home\PrincipalController;
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

    Route::get('/',[LoginController::class, 'formLogin'])->name('login');

    Route::post('/',[LoginController::class, 'login']);

});

// REDIRIGE A LOS USUARIO LOGUEADOS
Route::middleware('check.login')->group(function () {

    Route::post('/logout',[LogoutController::class, 'logout'])->name('logout');

    Route::get('/principal',[PrincipalController::class, 'viewPrincipal'])->name('principal');

    Route::get('/consolidado', function () {
        return view('consolidado'); // Muestra resources/views/about.blade.php
    });

    Route::get('/detallado', function () {
        return view('detallado'); // Muestra resources/views/about.blade.php
    });

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



