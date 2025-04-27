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
        $codigoContribuyente = session('codigo_contribuyente') ??
            session('cod_usuario') ?? null; // Valor por defecto para pruebas

        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);

        if (!$codigoContribuyente) {
            // Si no hay código de contribuyente, redirigir al login
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // Obtener datos del contribuyente
        $contribuyente = UsuariosAdmins::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener los filtros
        $tipoAdministrador = $request->tipoAdministrador ?? '%';
        $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

        // Obtener las usuarios detalladas
        $usuarios = UsuariosAdmins::obtenerUsuarios($tipoAdministrador, $estadoSeleccionado);

        // Preparar datos para la vista
        $estados = UsuariosAdmins::obtenerEstadosDisponibles();
        $tiposAdmins = UsuariosAdmins::obtenerTipoAdminDisponibles();
        $fechaActual = Carbon::now()->format('d/m/Y');
        Debugbar::info('usuarios', $usuarios);
        $viewData = [
            'contribuyente' => $contribuyente,
            'Usuarios' => $usuarios,
            'estadosDisponibles' => $estados,
            'tipoAdministrador' => $tipoAdministrador,
            'estadoSeleccionado' => $estadoSeleccionado,
            'tiposAdmins' => $tiposAdmins,
            'fechaActual' => $fechaActual,
            'usuario' => $usuario
        ];

        return view('usuarios', $viewData);
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

    public function update(UpdateUsuarioRequest $request)
    {


        // Asignar los valores del formulario a variables
        $vlogin = $request->input('user_id');
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
        if ($tipoAdministrador == 1) {
            $vestado = '002'; // Administrador
        } else {
            $vestado = '003'; // Moderador
        }

        // Llamar al modelo UsuariosAdmins para actualizar el usuario
        $result = UsuariosAdmins::actualizarUsuario(
            $vlogin,
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
                    'message' => 'Usuario actualizado con éxito.'
                ]
            ]);
        } else {
            return redirect()->back()->with([
                'modal_open_edit' => true,
                'user_id' => $vlogin,
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

        $vlogin = $request->input('user_id');

        $result = UsuariosAdmins::eliminarUsuario($vlogin);

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
