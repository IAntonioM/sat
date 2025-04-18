<?php

namespace App\Http\Controllers\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function formLogin(){
        if (session('errors')) {
            Debugbar::error('⚠️ Errores de sesión', session('errors')->all());
        }
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        Debugbar::info($request->all());

        // Ya validados los campos por el FormRequest
        $usuario = $request->input('usuario');
        $password = $request->input('password');

        // Validar usuario contra la base de datos
        $user = $this->validateUserCredentials($usuario, $password);

        if ($user) {
            return $this->handleSuccessfulLogin($user);
        }

        return $this->handleFailedLogin($request);
    }

    /**
     * Valida las credenciales del usuario contra la base de datos
     */
    private function validateUserCredentials(string $usuario, string $password)
    {
        return DB::table('musuario')
            ->where('vcodcontr', $usuario)
            ->whereRaw("CAST(vpass AS VARCHAR(20)) = ?", [$password])
            ->first();
    }

    /**
     * Maneja el inicio de sesión exitoso
     */
    private function handleSuccessfulLogin($user)
    {
        Debugbar::info('✅ Usuario autenticado con éxito', $user);

        session([
            'usuario' => $user,
            'cod_usuario' => $user->cidusu,
            'codigo_contribuyente' => $user->vcodcontr // Guarda el código de contribuyente
        ]);

        return redirect()->route('principal');
    }

    /**
     * Maneja el inicio de sesión fallido
     */
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
}
