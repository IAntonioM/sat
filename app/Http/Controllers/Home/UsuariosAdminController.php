<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Opciones\UpdateUsuarioRequest;
use App\Http\Requests\Opciones\UsuarioRequest;
use App\Models\UsuariosAdmins;
use Carbon\Carbon;
use App\Models\Contribuyente;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;

class UsuariosAdminController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el código del contribuyente de la sesión o del parámetro
        $codigoContribuyente = session('codigo_contribuyente') ;
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        Debugbar::info('Datos de registro', $usuario);

        // Obtener los filtros
        $tipoAdministrador = $request->tipoAdministrador ?? '%';
        $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

        // Obtener las usuarios detalladas
        $UsuariosList = UsuariosAdmins::obtenerUsuarios($tipoAdministrador, $estadoSeleccionado);

        // Preparar datos para la vista
        $estadosDisponibles = UsuariosAdmins::obtenerEstadosDisponibles();
        $tiposAdmins = UsuariosAdmins::obtenerTipoAdminDisponibles();
        $fechaActual = Carbon::now()->format('d/m/Y');
        Debugbar::info('Datos de registro', $UsuariosList);

        return view('usuarios', compact(
            'UsuariosList',
            'estadosDisponibles',
            'tipoAdministrador',
            'estadoSeleccionado',
            'tiposAdmins',
            'fechaActual',
            'usuario'
        ));

    }

    public function store(UsuarioRequest $request)
    {

        // Asignar los valores del formulario a variables
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $usuario = $request->input('usuario');
        $password = $request->input('password'); // Encriptar la contraseña
        $fechaRegistro = $request->input('fechaRegistro');
        $estado_cuenta = $request->input('estado');
        $tipoAdministrador = $request->input('tipoAdministrador');

        // Separar apellidos en paterno y materno
        $apellidosArray = explode(" ", $apellidos);
        $vpater = $apellidosArray[0] ?? ''; // El primer apellido es el paterno
        $vmater = $apellidosArray[1] ?? ''; // El segundo apellido es el materno, si existe

        // Determinar el estado del usuario según el tipo de administrador
        if ($tipoAdministrador == 1) {
            $vestado = '002'; // Administrador
        } else {
            $vestado = '003'; // Moderador
        }

        // Llamar al modelo UsuariosAdmins para crear el usuario utilizando el procedimiento almacenado
        $result = UsuariosAdmins::crearUsuario($nombres, $vpater, $vmater, $usuario, $vestado, $fechaRegistro, $estado_cuenta, $password);
        Debugbar::info('Datos de registro', $result);

        if ($result) {
            return redirect()->route('UsuariosAdmin')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Usuario creado con éxito.'
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'modal_open_add' => true,
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Hubo un problema al crear el usuario. '
                ]
            ]);
        }
    }

    public function update(UsuarioRequest $request)
    {
        // Asignar los valores del formulario a variables
        $vnrodoc = $request->input('user_id');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $usuario = $request->input('usuario');
        $fechaRegistro = $request->input('fechaRegistro');
        $estado_cuenta = $request->input('estado');
        $tipoAdministrador = $request->input('tipoAdministrador');

        // Password is optional in update
        $password = $request->input('password');

        // Separar apellidos en paterno y materno
        $apellidosArray = explode(" ", $apellidos);
        $vpater = $apellidosArray[0] ?? ''; // El primer apellido es el paterno
        $vmater = $apellidosArray[1] ?? ''; // El segundo apellido es el materno, si existe

        // Determinar el estado del usuario según el tipo de administrador
        if ($tipoAdministrador == 0) {
            $vestado = '002'; // Administrador
        } else {
            $vestado = '003'; // Moderador
        }

        // Llamar al modelo UsuariosAdmins para actualizar el usuario
        $result = UsuariosAdmins::actualizarUsuario(
            $vnrodoc,
            $nombres,
            $vpater,
            $vmater,
            $usuario,
            $vestado,
            $estado_cuenta,
            $password,
            $fechaRegistro
        );

        if ($result) {
            return redirect()->route('UsuariosAdmin')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Usuario actualizado con éxito.'.$tipoAdministrador
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'modal_open_edit' => true,
                'user_id' => $vnrodoc,
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Hubo un problema al actualizar el usuario.'
                ]
            ]);
        }
    }

    public function delete(Request $request)
    {

        $vnrodoc = $request->input('user_id');

        $result = UsuariosAdmins::eliminarUsuario($vnrodoc);

        if ($result) {
            return redirect()->route('UsuariosAdmin')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => '¡Éxito!',
                    'message' => 'Usuario eliminado con éxito.'
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Hubo un problema al eliminar el usuario.'
                ]
            ]);
        }
    }
}
