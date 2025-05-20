<?php

namespace App\Services;

use App\Models\Emitido;

class EmitidoService
{
    public function buscar(array $params)
    {
        $params['accion'] = 2;
        return Emitido::executeProcedure($params);
    }

    public function obtenerPorCorrelativo(string $correlativo)
    {
        return Emitido::executeProcedure([
            'accion' => 2,
            'correlativo' => $correlativo,
        ]);
    }

    public function obtenerPorEmisor(string $emisorId, int $anio = null, int $pagina = 1, int $registros = 10)
    {
        return Emitido::executeProcedure([
            'accion' => 2,
            'emisor_id' => $emisorId,
            'anio' => $anio,
            'pagina' => $pagina,
            'registros_por_pagina' => $registros,
        ]);
    }

    public function obtenerPorReceptor(string $receptorId, int $anio = null, int $pagina = 1, int $registros = 10)
    {
        return Emitido::executeProcedure([
            'accion' => 2,
            'receptor_id' => $receptorId,
            'anio' => $anio,
            'pagina' => $pagina,
            'registros_por_pagina' => $registros,
        ]);
    }

    public function crear(array $params)
    {
        $params['accion'] = 1;
        return Emitido::executeProcedure($params);
    }

    public function actualizar(array $params)
    {
        $params['accion'] = 3;
        return Emitido::executeProcedure($params);
    }

    public function eliminar(string $correlativo)
    {
        return Emitido::executeProcedure([
            'accion' => 4,
            'correlativo' => $correlativo,
        ]);
    }

    // Puedes agregar métodos para acciones 5 y 6 si están implementadas en el SP
}
