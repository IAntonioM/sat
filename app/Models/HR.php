<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HR extends Model
{
    /**
     * Get user data using stored procedure
     *
     * @param string $userId
     * @return object
     */
    public static function getUserData($userId)
    {
        $result = DB::select("EXEC pxConsultasWeb2 '4', @vcodcontr=?", [$userId]);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get summary data using stored procedure
     *
     * @param string $userId
     * @param string $fecha
     * @param string $cejerci
     * @return object
     */
    public static function getResumenData($userId, $fecha, $cejerci)
    {
        $result = DB::select("EXEC pxConsultasWeb2 '19', ?, '', '', ?, ?", [
            $userId,
            $fecha,
            $cejerci
        ]);

        return !empty($result) ? $result[0] : null;
    }

    /**
     * Get count data using stored procedure
     *
     * @param string $userId
     * @return int
     */
    public static function obtenerDatosContribuyente($userId)
    {
        $result = DB::select("EXEC pxConsultasWeb2 '11', ?", [$userId]);

        // Asumiendo que solo esperas un contribuyente, devuelve el primero
        return $result[0] ?? null;
    }


    /**
     * Get property data using stored procedure
     *
     * @param string $userId
     * @param string $year
     * @return array
     */
    public static function getPropertyData($userId, $year)
    {
        return DB::select("EXEC pxConsultasWeb2 @msquery=4, @vcodcontr=?, @paramt5=?", [
            $userId,
            $year
        ]);
    }

    /**
     * Get property details using stored procedure
     *
     * @param string $userId
     * @param string $xid_anexo
     * @return array
     */
    public static function getPropertyDetails($userId, $xid_anexo)
    {
        return DB::select("EXEC pxConsultasWeb2 '7', ?, ?", [
            $userId,
            $xid_anexo
        ]);
    }

    public static function obtenerRelacionPredios($codigoContribuyente, $year)
    {
        $query = "EXEC pxConsultasWeb2 @msquery = 4, @vcodcontr = ?, @paramt5 = ?";
        $params = [$codigoContribuyente, $year];

        return DB::select($query, $params);
    }

    public static function obtenerTotales($codigoContribuyente, $year)
    {
        $query = "EXEC pxConsultasWeb2 @msquery = 4, @vcodcontr = ?, @paramt5 = ?";
        $result = DB::select($query, [$codigoContribuyente, $year]);

        $total_predios = count($result);
        $total_afecto = $total_predios; // puedes poner lógica si es distinto
        $total_base_imponible = array_sum(array_map(fn($r) => $r->Valor_Afecto ?? 0, $result));

        // Tomamos el primer registro como fuente de totales
        $first = $result[0] ?? null;

        return [
            'total_predios' => $total_predios,
            'total_afecto' => $total_afecto,
            'base_imponible' => $total_base_imponible,
            'base_exonerada' => $first->base_exonerada ?? 0,
            'imp_anual' => $first->imp_anual ?? 0,
            'imp_trime' => $first->imp_trime ?? 0,
            'costo_emi' => $first->costo_emi ?? 0,
            'total' => $first->total ?? 0,
        ];
    }
}
