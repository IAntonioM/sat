<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuariosAdmins extends Model
{
    protected $table = 'MUSUARIO';
    protected $primaryKey = 'iCodPreTramite';
    public $timestamps = false;

    public static function listarUsuarios($params)
    {
        $sql = "
        EXEC dbo.sp_ListarUsuariosFiltrados
            @Accion = 1,
            @cidusu = cidusu,
            @nombreCompleto = nombreCompleto,
            @fechaRegistroInicio = fechaRegistroInicio,
            @fechaRegistroFin = fechaRegistroFin,
            @tipoAdministrador = vestado,
            @estado = vesado_cuenta;
    ";

        return DB::select($sql, $params);
    }
}
