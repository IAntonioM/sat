<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Recibido extends Model
{
    protected $table = 'RECIBIDO';
    protected $primaryKey = 'correlativo';
    public $incrementing = false;
    public $timestamps = false;

    public static function executeProcedure(array $params)
    {
        $sql = "EXEC sp_recibido
        @accion = ?, @correlativo = ?, @anio = ?, @emitido_correlativo = ?,
        @estado_recepcion_id = ?, @fecha_recepcion = ?,
        @flag_favorito = ?, @flag_marcador = ?, @flag_archivado = ?,
        @fecha_inicio = ?, @fecha_fin = ?, @usuario_creacion = ?,
        @pagina = ?, @registros_por_pagina = ?,
        @receptor_id = ?, @emisor_id = ?, @asunto = ?, @tipo_documento_emitido_id = ?";

        return DB::select($sql, [
            $params['accion'] ?? null,
            $params['correlativo'] ?? null,
            $params['anio'] ?? null,
            $params['emitido_correlativo'] ?? null,
            $params['estado_recepcion_id'] ?? null,
            $params['fecha_recepcion'] ?? null,
            $params['flag_favorito'] ?? null,
            $params['flag_marcador'] ?? null,
            $params['flag_archivado'] ?? null,
            $params['fecha_inicio'] ?? null,
            $params['fecha_fin'] ?? null,
            $params['usuario_creacion'] ?? null,
            $params['pagina'] ?? 1,
            $params['registros_por_pagina'] ?? 10,
            $params['receptor_id'] ?? null,
            $params['emisor_id'] ?? null,
            $params['asunto'] ?? null,
            $params['tipo_documento_emitido_id'] ?? null,
        ]);
    }
}
