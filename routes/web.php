<?php

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

Route::get('/', function () {
    return view('login');
});


Route::get('/principal', function () {
    return view('principal');
});

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

