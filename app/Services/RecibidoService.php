<?php

namespace App\Services;

use App\Models\Recibido;

class RecibidoService
{
    public function buscar(array $params)
    {
        $params['accion'] = 2;
        return Recibido::executeProcedure($params);
    }

    public function obtenerPorCorrelativo(string $correlativo)
    {
        return Recibido::executeProcedure([
            'accion' => 2,
            'correlativo' => $correlativo,
        ]);
    }

    public function crear(array $params)
    {
        $params['accion'] = 1;
        return Recibido::executeProcedure($params);
    }

    public function actualizarEstado(string $correlativo, int $estadoId)
    {
        return Recibido::executeProcedure([
            'accion' => 3,
            'correlativo' => $correlativo,
            'estado_recepcion_id' => $estadoId,
        ]);
    }
    //contendeo de documentos no leidos por menu
    public function getDataMenu(array $params)
    {
        $params['accion'] = 20;
        return Recibido::executeProcedure($params);
    }

    //consultar all menus
        public function getAllMenu(array $params)
    {
        $params['accion'] = 21;
        return Recibido::executeProcedure($params);
    }


    public function accionMarcador(array $params)
    {
        $params['accion'] = 5;
        return Recibido::executeProcedure($params);
    }



    // Puedes agregar más métodos para acciones 4, 5, 6
}
