<?php

namespace App\Services;

use App\Models\Usuario;
use Barryvdh\Debugbar\Facades\Debugbar;

class UsuarioService
{
    public function buscarUsuario(array $params)
    {
        $params['accion'] = 1; // Acción 1: búsqueda
        Debugbar::info('🔍 Buscando usuario con parámetros:', $params);
        return Usuario::executeProcedure($params);
    }
}
