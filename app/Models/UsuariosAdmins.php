<?php

namespace App\Models;

use DebugBar\DebugBar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

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
            // Usar statement en lugar de DB::select
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('EXEC sp_UsuarioAdmin @accion = ?, @vnombre = ?, @vpater = ?, @vmater = ?, @vusuario = ?, @vestado = ?, @vestado_cuenta = ?, @dfecregist = ?, @vpass = ?, @vlogin = ?');
            $stmt->execute([
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
            $result = [];
            do {
                if ($stmt->columnCount() > 0) {
                    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
                    if (count($rows) > 0) {
                        $result = $rows;
                        break;
                    }
                }
            } while ($stmt->nextRowset());
            return !empty($result) ? $result[0] : $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function actualizarUsuario($vlogin, $vnombre, $vpater, $vmater, $vusuario, $vestado, $vestado_cuenta, $vpass, $dfecregist)
    {
        try {
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('EXEC sp_UsuarioAdmin
                @accion = ?,
                @vnombre = ?,
                @vpater = ?,
                @vmater = ?,
                @vusuario = ?,
                @dfecregist = ?,
                @vestado = ?,
                @vestado_cuenta = ?,
                @vpass = ?,
                @vlogin = ?');
            $stmt->execute([
                2, // @accion = 2 (Actualizar)
                $vnombre,
                $vpater,
                $vmater,
                $vusuario,
                $dfecregist,
                $vestado,
                $vestado_cuenta,
                $vpass,
                $vlogin
            ]);
            if ($stmt->columnCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                return $result ?: true;
            }
            while ($stmt->nextRowset() && $stmt->columnCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                if ($result) return $result;
            }
            return $result; // La operación fue exitosa pero no devolvió datos
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function eliminarUsuario($vlogin)
    {
        return DB::statement('EXEC sp_UsuarioAdmin @accion = 3, @vlogin = ?', [$vlogin]);
    }


}
