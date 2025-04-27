<?php

namespace App\Models;

use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuariosAdmins extends Model
{
    protected $table = 'MUSUARIO';
    public $timestamps = false;

    /**
     * Obtiene los datos del contribuyente
     *
     * @param string $codigoContribuyente
     * @return array
     */
    public static function obtenerDatosContribuyente($codigoContribuyente)
    {
        $result = DB::select('EXEC pxConsultasWeb2 @msquery = ?, @paramt1 = ?', [1, $codigoContribuyente]);
        return $result ? $result[0] : null;
    }

    /**
     * Obtiene el detalle de las deudas por periodo
     *
     * @param string $tipoAdministrador
     * @param string $estado
     * @return array
     */
    public static function obtenerUsuarios($tipoAdministrador, $estado)
    {
        return DB::select(
            'EXEC sp_ListarUsuariosFiltrados @accion = 1, @tipoAdministrador = ?, @estado = ?; ',
            [$tipoAdministrador, $estado]
        );
    }

    /**
     * Obtiene los estados disponibles
     *
     * @return array
     */
    public static function obtenerEstadosDisponibles()
    {
        $result = DB::select('SELECT DISTINCT vestado_cuenta, CASE
                           WHEN vestado_cuenta = 1 THEN \'Activo\'
                           WHEN vestado_cuenta = 0 THEN \'Desactivado\'
                           ELSE \'Desconocido\' END AS nombre_estado
                          FROM MUSUARIO WHERE vestado <> \'001\'');
        return $result;
    }

    /**
     * Obtiene los estados disponibles
     *
     * @return array
     */
    public static function obtenerTipoAdminDisponibles()
    {
        $result = DB::select('SELECT DISTINCT vestado, CASE
                           WHEN vestado = 002 THEN \'Administrador\'
                           WHEN vestado = 003 THEN \'Moderador\'
                           ELSE \'Desconocido\' END AS nombre_tipo_admin
                          FROM MUSUARIO WHERE vestado <> \'001\'');
        return $result;
    }
    public static function crearUsuario($vnombre, $vpater, $vmater, $vusuario, $vestado, $dfecregist, $vestado_cuenta, $vpass)
    {
        try {
            $result = DB::select('EXEC sp_UsuarioAdmin @accion = ?, @vnombre = ?, @vpater = ?, @vmater = ?, @vusuario = ?, @vestado = ?, @vestado_cuenta = ?, @dfecregist = ?, @vpass = ?, @vlogin = ?', [
                1, // @accion = 1
                $vnombre,
                $vpater,
                $vmater,
                $vusuario,
                $vestado,
                $vestado_cuenta,
                $dfecregist,
                $vpass,
                null // @vlogin
            ]);

            // Since the stored procedure now returns data, check if result contains data
            return !empty($result) ? $result : false;
        } catch (\Exception $e) {
            return false;
        }
    }
    public static function actualizarUsuario($vlogin, $vnombre, $vpater, $vmater, $vusuario, $vestado, $vestado_cuenta, $vpass, $dfecregist)
    {
        $query = 'EXEC sp_UsuarioAdmin
                @accion = ?,
                @vnombre = ?,
                @vpater = ?,
                @vmater = ?,
                @vusuario = ?,
                @dfecregist = ?,
                @vestado = ?,
                @vestado_cuenta = ?,
                @vpass = ?,
                @vlogin = ?';

        $params = [
            2,             // @accion = 2 (Actualizar)
            $vnombre,
            $vpater,
            $vmater,
            $vusuario,
            $dfecregist,   // ¡No lo olvides!
            $vestado,
            $vestado_cuenta,
            $vpass,
            $vlogin        // Debe ir al final según el SP
        ];

        try {
            $result = DB::select($query, $params);
            return !empty($result) ? $result[0] : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function eliminarUsuario($vlogin)
    {
        // Ejecutar el procedimiento almacenado para la acción 3 (Eliminar usuario)
        $result = DB::select('EXEC sp_UsuarioAdmin @accion = 3, @vlogin = ?', [$vlogin]);

        return $result ? true : false;
    }
}
