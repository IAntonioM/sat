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
        @accion = ?, @nu_emi = ?, @nu_cor = ?, @anio = ?, @emitido_correlativo = ?,
        @estado_recepcion_id = ?, @fecha_recepcion = ?,
        @flag_favorito_receptor = ?, @flag_marcador_receptor = ?, @flag_archivado_receptor = ?,
        @flag_favorito_emisor = ?, @flag_marcador_emisor = ?, @flag_archivado_emisor = ?,
        @fecha_inicio = ?, @fecha_fin = ?, @usuario_creacion = ?,
        @pagina = ?, @registros_por_pagina = ?,
        @receptor_id = ?, @emisor_id = ?, @asunto = ?, @tipo_documento_emitido_id = ?";

        return DB::select($sql, [
            $params['accion'] ?? null,
            $params['nu_emi'] ?? null,
            $params['nu_cor'] ?? null,
            $params['anio'] ?? null,
            $params['emitido_correlativo'] ?? null,
            $params['estado_recepcion_id'] ?? null,
            $params['fecha_recepcion'] ?? null,
            $params['flag_favorito_receptor'] ?? null,
            $params['flag_marcador_receptor'] ?? null,
            $params['flag_archivado_receptor'] ?? null,
            $params['flag_favorito_emisor'] ?? null,
            $params['flag_marcador_emisor'] ?? null,
            $params['flag_archivado_emisor'] ?? null,
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
