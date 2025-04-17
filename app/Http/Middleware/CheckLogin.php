<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('usuario')) {
            return redirect()->route('login')->withErrors(['usuario' => 'Debes iniciar sesión.']);
        }

        return $next($request);
    }
}
