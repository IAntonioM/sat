<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePassRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Usuario;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChangePassword extends Controller
{
    protected $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function formCambiarClave(){
        if (session('errors')) {
            Debugbar::error('⚠️ Errores de sesión', session('errors')->all());
        }
        $usuario = Session::get('usuario');
        return view('cambiarClave', compact('usuario'));
    }

    public function cambiarClave(ChangePassRequest $request)
    {
        Debugbar::info($request->all());

        // Ya validados los campos por el FormRequest
        $usuario = $request->input('usuario');
        $password = $request->input('password'); // password actual
        $nuevoPassword = $request->input('password1'); // nuevo password

        $user = $this->usuario->validateUserCredentials($usuario, $password);

        if ($user) {
            $userUpdate = $this->usuario->updatePassword($usuario,$password,$nuevoPassword);
            if($userUpdate){
                return $this->handleSuccessfulLogin($userUpdate);
            }
        }

        return $this->handleFailedLogin($request);
    }

    // SI SE INGRESO DATA ERRONEA
    private function handleFailedLogin($request)
    {
        Debugbar::error('❌ No se inició sesión: Usuario o contraseña incorrectos');

        return back()
            ->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Error al iniciar sesión',
                    'message' => 'Las credenciales no coinciden con algun registro.'
                ]
            ])
            ->withInput($request->only('usuario'));
    }

    //SI EL USAURIO Y CONTRASEÑA SON CORRECTOS
    private function handleSuccessfulLogin($user)
    {
        Debugbar::info('✅ La contraseña de Usuario se actualizo correctamente', $user);


        // SI EL ESTADO DE USAURIO ES INACTIVO
        if ($user->vestado === '004') {
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Usuario Inactivo',
                    'message' => 'Tu cuenta se encuentra inactiva. Contacta al administrador.'
                ]
            ]);
        }

        session([
           // 'usuario' => $user,
            'cod_usuario' => $user->cidusu,
            'codigo_contribuyente' => $user -> vcodcontr
        ]);

        // SI SE REQUIERES CAMBIAR LA CONTRASEÑA
        if (isset($user->vpreg) && $user->vpreg === '0') {
            Debugbar::info('🔐 Se requiere cambio de clave', $user);
            return redirect()->route('cambiarClave')->with([
                'alert' => [
                    'type' => 'warning',
                    'title' => 'Cambio de Clave Requerido',
                    'message' => 'Por favor, cambia tu clave para continuar.'
                ]
            ]);
        }

        // ESTADOS CORRECTOS PARA EL INICIO DE SESION
        if (in_array($user->vestado, ['002', '003'])) {
            return redirect()->route('principal')->with([
                'alert' => [
                    'type' => 'success',
                    'title' => 'Cambio de clave exitoso',
                    'message' => 'BIENVENIDO, ' . ($user->vnombre ?? 'Usuario')
                ]
            ]);
        }

        //DEFAULT
        return redirect()->route('principal')->with([
            'alert' => [
                'type' => 'success',
                'title' => 'Cambio de clave exitoso',
                'message' => 'BIENVENIDO, ' . ($user->vnombre ?? 'Usuario')
            ]
        ]);
    }
}
