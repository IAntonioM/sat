<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeudaConsolidada extends Model
{
    protected $table = 'CONSOLIDADO'; // Ajusta según la tabla real si es necesaria

    /**
     * Obtener las deudas consolidadas de un contribuyente
     *
     * @param string $codigoContribuyente
     * @param string $anio
     * @param string $tipoTributo
     * @return array
     */
    public static function obtenerDeudasConsolidadas($codigoContribuyente, $anio = '%', $tipoTributo = '%')
    {
        // Llamada al procedimiento almacenado
        $msquery = 19; // Valor para DeudasConsolidads_anoconmora_total

        $resultado = DB::select(
            "EXEC pxConsultasWeb2 ?, ?, ?, ?",
            [$msquery, $codigoContribuyente, $anio, $tipoTributo]
        );

        return $resultado;
    }

    /**
     * Obtener el detalle de deudas consolidadas de un contribuyente
     *
     * @param string $codigoContribuyente
     * @param string $anio
     * @param string $tipoTributo
     * @return array
     */
    public static function obtenerDetalleDeudas($codigoContribuyente, $anio = '%', $tipoTributo = '%')
    {
        // Llamada al procedimiento almacenado
        $msquery = 18; // Valor para DeudasConsolidads_anoconmora

        $resultado = DB::select(
            "EXEC pxConsultasWeb2 ?, ?, ?, ?",
            [$msquery, $codigoContribuyente, $anio, $tipoTributo]
        );

        return $resultado;
    }

    /**
     * Obtener datos del contribuyente
     *
     * @param string $codigoContribuyente
     * @return object|null
     */
    public static function obtenerDatosContribuyente($codigoContribuyente)
    {
        // Llamada al procedimiento almacenado
        $msquery = 1; // Valor para datos_contrib

        $resultado = DB::select(
            "EXEC pxConsultasWeb2 ?, ?",
            [$msquery, $codigoContribuyente]
        );

        return $resultado[0] ?? null;
    }

    /**
     * Obtener los años disponibles con deudas para un contribuyente
     *
     * @param string $codigoContribuyente
     * @return array
     */
    public static function obtenerAniosDisponibles($codigoContribuyente)
    {
        return DB::table('CONSOLIDADO')
            ->select(DB::raw('DISTINCT año'))
            ->where('codigo', $codigoContribuyente)
            ->orderBy('año', 'desc')
            ->pluck('año')
            ->toArray();
    }

    /**
     * Obtener deuda total actual del contribuyente
     *
     * @param string $codigoContribuyente
     * @return float
     */
    public static function obtenerDeudaTotal($codigoContribuyente)
    {
        // Llamada al procedimiento almacenado
        $msquery = 191; // Valor para DeudasConsolidads_anoconmora_total1

        $resultado = DB::select(
            "EXEC pxConsultasWeb2 ?, ?, ?, ?",
            [$msquery, $codigoContribuyente, '%', '%']
        );

        return $resultado[0]->total ?? 0;
    }
}
