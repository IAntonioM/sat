<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PagosModel extends Model
{
    protected $table = 'PAGOS_PORTAL'; // We'll use raw queries with the stored procedure

    public static function getPagos($vcodcontr, $anio, $tipotributo)
    {
        return DB::select(
            "EXEC pxConsultasWeb2 '21',
                @vcodcontr = '?',
                @paramt2 = '?',
                @paramt3 = '?'",
            [$vcodcontr, $anio, $tipotributo]
        );
    }

    public static function getUserData($vcodcontr)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='1', @vcodcontr=?", [$vcodcontr])[0] ?? null;
    }

    public static function obtenerAniosDisponibles($vcodcontr)
    {
        $result = DB::select(
            'select DISTINCT año from PAGOS_PORTAL where codigo = ?',[$vcodcontr]);
        return $result;
    }

    public static function obtenerTiposTributosDisponibles($vcodcontr)
    {
        $result = DB::select(
            'select DISTINCT tipo, tipo_d from PAGOS_PORTAL where codigo = ?',[$vcodcontr]);
        return $result;
    }

    public static function obtenerTotalPagado($vcodcontr)
    {
        $result = DB::select(
            'select Sum(total) as totalPagado from PAGOS_PORTAL where codigo = ?',[$vcodcontr]);
        return $result;
    }

    public static function obtenerDatosContribuyente($vcodcontr)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='1', @vcodcontr=?", [$vcodcontr])[0] ?? null;
    }
}
