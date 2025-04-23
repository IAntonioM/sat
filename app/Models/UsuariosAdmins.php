<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuariosAdmins extends Model
{
    protected $table = 'MUSUARIO';
    public $timestamps = false;

    public static function listarUsuarios($params)
    {
        // Valores por defecto para los parámetros de filtrado
        $parametros = [
            'Accion' => 1,
            'cidusu' => $params['cidusu'] ?? null,
            'nombreCompleto' => $params['nombreCompleto'] ?? null,
            'fechaRegistroInicio' => $params['fechaRegistroInicio'] ?? null,
            'fechaRegistroFin' => $params['fechaRegistroFin'] ?? null,
            'tipoAdministrador' => $params['tipoAdministrador'] ?? null,
            'estado' => $params['estado'] ?? null
        ];

        return DB::select("
        EXEC dbo.sp_ListarUsuariosFiltrados
            @Accion = :Accion,
            @cidusu = :cidusu,
            @nombreCompleto = :nombreCompleto,
            @fechaRegistroInicio = :fechaRegistroInicio,
            @fechaRegistroFin = :fechaRegistroFin,
            @tipoAdministrador = :tipoAdministrador,
            @estado = :estado
    ", $parametros);
    }

    public static function obtenerEstadosDisponibles()
    {
        $result = DB::select('SELECT DISTINCT vestado_cuenta, CASE
                           WHEN vestado_cuenta = 1 THEN \'Activo\'
                           WHEN vestado_cuenta = 0 THEN \'Desactivado\'
                           ELSE \'Desconocido\' END AS nombre_estado
                          FROM MUSUARIO WHERE vestado <> \'001\'');
        return $result;
    }
}
