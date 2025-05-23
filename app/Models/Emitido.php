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
        @accion = ?, @nu_emi = ?, @anio = ?, @asunto = ?, @contenido = ?,
        @emisor_id = ?, @receptor_id = ?, @tipo_documento_emitido_id = ?, @estado_emitido_id = ?,
        @fecha_emision = ?, @usuario_creacion = ?, @nu_emi_padre = ?,
        @fecha_inicio = ?, @fecha_fin = ?, @pagina = ?, @registros_por_pagina = ?, @nu_cor = ?, @json_anexos = ?";

    return DB::select($sql, [
        $params['accion'] ?? null,
        $params['nu_emi'] ?? null,
        $params['anio'] ?? null,
        $params['asunto'] ?? null,
        $params['contenido'] ?? null,
        $params['emisor_id'] ?? null,
        $params['receptor_id'] ?? null,
        $params['tipo_documento_emitido_id'] ?? null,
        $params['estado_emitido_id'] ?? null,
        $params['fecha_emision'] ?? null,
        $params['usuario_creacion'] ?? null,
        $params['nu_emi_padre'] ?? null,
        $params['fecha_inicio'] ?? null,
        $params['fecha_fin'] ?? null,
        $params['pagina'] ?? 1,
        $params['registros_por_pagina'] ?? 10,
        $params['nu_cor'] ?? 1,
        $params['json_anexos'] ?? null,
    ]);
}

}
