<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Detallado extends Model
{
    use HasFactory;

    protected $table = 'DETALLADO'; // Tabla principal inferida del SP

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
     * Obtiene el total de la deuda del contribuyente
     *
     * @param string $codigoContribuyente
     * @return float
     */
    public static function obtenerTotalDeuda($codigoContribuyente)
    {
        $result = DB::select('EXEC pxConsultasWeb2 ?, ?, ?,?', [191, $codigoContribuyente, '%', '%']);
        return $result && isset($result[0]->total) ? $result[0]->total : 0;
    }

    /**
     * Obtiene las deudas detalladas del contribuyente
     *
     * @param string $codigoContribuyente
     * @param string $anio
     * @param string $tipoTributo
     * @return array
     */
    public static function obtenerDeudasDetalladas($codigoContribuyente, $anio = '%', $tipoTributo = '%')
    {
        return DB::select('EXEC pxConsultasWeb2 @msquery = ?, @vcodcontr = ?, @paramt2 = ?, @paramt3 = ?',
            [18, $codigoContribuyente, $anio, $tipoTributo]);
    }

    /**
     * Obtiene el detalle de las deudas por periodo
     *
     * @param string $codigoContribuyente
     * @param string $anio
     * @param string $tipoTributo
     * @return array
     */
    public static function obtenerDetalleDeudas($codigoContribuyente, $anio = '%', $tipoTributo = '%')
    {
        return DB::select('EXEC pxConsultasWeb2 @msquery = ?, @paramt1 = ?, @paramt2 = ?, @paramt3 = ?',
            [3, $codigoContribuyente, $anio, $tipoTributo]);
    }

    /**
     * Obtiene los años disponibles para el contribuyente
     *
     * @param string $codigoContribuyente
     * @return array
     */
    public static function obtenerAniosDisponibles($codigoContribuyente)
    {
        $result = DB::select('SELECT DISTINCT año FROM CONSOLIDADO WHERE codigo = ?', [$codigoContribuyente]);
        return collect($result)->pluck('año')->toArray();
    }

    /**
     * Obtiene los tipos de tributos disponibles
     *
     * @return array
     */
    public static function obtenerTiposTributo()
    {
        return [
            ['id' => '02.01', 'nombre' => 'Impuesto Predial'],
            ['id' => '11.00', 'nombre' => 'Arbitrios Municipales'],
        ];
    }
}
