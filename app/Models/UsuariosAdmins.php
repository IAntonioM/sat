<?php

namespace App\Models;

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
        return DB::select('EXEC sp_ListarUsuariosFiltrados @accion = 1, @tipoAdministrador = ?, @estado = ?; ',
            [$tipoAdministrador, $estado]);
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
                           WHEN vestado = 002 THEN \'Moderador\'
                           WHEN vestado = 003 THEN \'Administrador\'
                           ELSE \'Desconocido\' END AS nombre_tipo_admin
                          FROM MUSUARIO WHERE vestado <> \'001\'');
        return $result;
    }
}
