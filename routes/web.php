<?php

use App\Http\Controllers\Auth\ChangePassword;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SolicitarAccesoController;
use App\Http\Controllers\Home\PrincipalController;
use App\Http\Controllers\Home\DeudaConsolidadaController;
use App\Http\Controllers\Home\DetalladoController;
use App\Http\Controllers\Home\HlaController;
use App\Http\Controllers\Home\HRController;
use App\Http\Controllers\Home\ReporteController;
use App\Http\Controllers\Home\PUController;
use App\Http\Controllers\Home\PRController;
use App\Http\Controllers\Home\UsuariosAdminController;
use App\Http\Controllers\Home\PendientesController;
use App\Http\Controllers\Home\PerfilController;
use App\Http\Controllers\Home\RecordPapeletaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
// Rutas para invitados
Route::middleware('guest.redirect')->group(function () {
    Route::get('/', [LoginController::class, 'formLogin'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
    Route::get('/solicitarAcceso', [SolicitarAccesoController::class, 'index'])->name('solicitarAcceso');
    Route::post('/solicitarAcceso', [SolicitarAccesoController::class, 'insertarSolcitudAcceso']);
});

// Ruta de cambio de clave obligatorio
Route::middleware(['check.login', 'cforce.password.change'])->group(function () {
    Route::get('/cambiarClave', [ChangePassword::class, 'formCambiarClave'])->name('cambiarClave');
    Route::post('/cambiarClave', [ChangePassword::class, 'cambiarClave']);
});
//logout (accesible para todos los usuarios autenticados)
Route::middleware(['check.login'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Rutas para usuarios autenticados (después de verificar cambio de clave)
Route::middleware(['check.login', 'force.password.change', 'user.access'])->group(function () {
    // Rutas generales para usuarios (vestado 001, 002, 003)
    Route::get('/principal', [PrincipalController::class, 'viewPrincipal'])->name('principal');
    Route::get('/consolidado', [DeudaConsolidadaController::class, 'index'])->name('consolidado');
    Route::post('/consolidado', [DeudaConsolidadaController::class, 'index'])->name('consolidado');
    Route::post('/consolidado/filtrar', [DeudaConsolidadaController::class, 'filtrar'])->name('consolidado.filtrar');
    Route::get('/consolidado/imprimir', [DeudaConsolidadaController::class, 'imprimir'])->name('consolidado.imprimir');
    Route::post('/consolidado/pagar', [DeudaConsolidadaController::class, 'prepararPago'])->name('consolidado.preparar-pago');
    Route::get('/consolidado/pago', function () {
        return redirect()->route('pagos.index');
    })->name('consolidado.pago');

    Route::get('/detallado', [DetalladoController::class, 'index'])->name('detallado');
    Route::post('/detallado', [DetalladoController::class, 'index'])->name('detallado');
    Route::post('/detallado/filtrar', [DetalladoController::class, 'filtrar'])->name('detallado.filtrar');
    Route::get('/detallado/imprimir', [DetalladoController::class, 'imprimir'])->name('detallado.imprimir');
    Route::post('/detallado/pagar', [DetalladoController::class, 'prepararPago'])->name('detallado.preparar-pago');
    Route::get('/detallado/pago', function () {
        return redirect()->route('pagos.index');
    })->name('detallado.pago');

    Route::get('/HR', [HRController::class, 'index'])->name('HR');
    Route::get('/reporte/{tipo}', [ReporteController::class, 'reporte'])->name('reporte');
    Route::get('/pagos', function () {
        return view('pagos');
    });
    Route::get('/HLA', [HlaController::class, 'index'])->name('HLA');
    Route::get('/PU', [PUController::class, 'index'])->name('PU');
    Route::get('/PR', [PRController::class, 'index'])->name('PR');
    Route::get('/record_papeleta', [RecordPapeletaController::class, 'index'])->name('record_papeleta');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/perfil-select/{codigo}', [PerfilController::class, 'select'])->name('SeleccionarPerfil');
});

// lo peude ver vestado 002 y 003
Route::middleware(['check.login', 'force.password.change', 'moderator.access'])->group(function () {
    // Área de moderador
    // Rutas para pendientes
    Route::get('/moderador/Pendiente', [PendientesController::class, 'index'])->name('moderador/Pendiente');
    Route::post('/moderador/Pendiente/filtrar', [PendientesController::class, 'filtrar'])->name('moderador/Pendiente.filtrar');
    Route::get('/moderador/UsuariosAdmin', [UsuariosAdminController::class, 'index'])->name('moderador/UsuariosAdmin');
    Route::post('/moderador/UsuariosAdmin', [UsuariosAdminController::class, 'index'])->name('moderador/UsuariosAdmin');
});

// Rutas exclusivas para administradores (vestado 003)
Route::middleware(['check.login', 'force.password.change', 'admin.access'])->group(function () {
    // Área de administrador
    // En routes/web.php
    Route::get('UsuariosAdmin', [UsuariosAdminController::class, 'index'])->name('UsuariosAdmin');
    Route::post('UsuariosAdmin', [UsuariosAdminController::class, 'index'])->name('UsuariosAdmin');
    Route::post('crearUsuario', [UsuariosAdminController::class, 'store'])->name('crearUsuario');
    Route::post('actualizarUsuario', [UsuariosAdminController::class, 'update'])->name('actualizarUsuario');
    Route::post('eliminarUsuario', [UsuariosAdminController::class, 'delete'])->name('eliminarUsuario');
    // Rutas para pendientes
    Route::get('Pendiente', [PendientesController::class, 'index'])->name('Pendiente');
    Route::post('Pendiente', [PendientesController::class, 'index'])->name('Pendiente');
    Route::post('AceptarSolicitud', [PendientesController::class, 'AceptarSolicitud'])->name('AceptarSolicitud');
    Route::post('DenegarSolicitud', [PendientesController::class, 'DenegarSolicitud'])->name('DenegarSolicitud');

    //Visualizar los archivos
    Route::get('/ver-archivo/{path}', function($path) {
        $path = 'archivos_solicitudAcceso/' . $path;
        if (Storage::exists($path)) {
            return response()->file(storage_path('app/' . $path));
        }
        abort(404);
    })->where('path', '.*')->name('ver.archivo');
});
