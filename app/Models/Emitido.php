<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Emitido extends Model
{
    protected $table = 'EMITIDO';
    protected $primaryKey = 'correlativo';
    public $incrementing = false;
    public $timestamps = false;

    public static function executeProcedure(array $params)
    {
        $sql = "EXEC sp_emitido
            @accion = ?, @correlativo = ?, @anio = ?, @asunto = ?, @contenido = ?,
            @emisor_id = ?, @receptor_id = ?, @tipo_documento_emitido_id = ?, @estado_emitido_id = ?,
            @fecha_emision = ?, @usuario_creacion = ?, @padre_correlativo = ?,
            @fecha_inicio = ?, @fecha_fin = ?, @pagina = ?, @registros_por_pagina = ?";

        return DB::select($sql, [
            $params['accion'] ?? null,
            $params['correlativo'] ?? null,
            $params['anio'] ?? null,
            $params['asunto'] ?? null,
            $params['contenido'] ?? null,
            $params['emisor_id'] ?? null,
            $params['receptor_id'] ?? null,
            $params['tipo_documento_emitido_id'] ?? null,
            $params['estado_emitido_id'] ?? null,
            $params['fecha_emision'] ?? null,
            $params['usuario_creacion'] ?? null,
            $params['padre_correlativo'] ?? null,
            $params['fecha_inicio'] ?? null,
            $params['fecha_fin'] ?? null,
            $params['pagina'] ?? 1,
            $params['registros_por_pagina'] ?? 10,
        ]);
    }
}
