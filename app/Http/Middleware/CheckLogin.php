<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('codigo_contribuyente')) {
            return redirect()->route('login')->withErrors(['password' => 'Debes iniciar sesión.']);
        }

        return $next($request);
    }
}
