<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request){
        Auth::guard('usuarios')->logout();

        // Opcional: limpia sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige al inicio
        return redirect('/');
    }
}
