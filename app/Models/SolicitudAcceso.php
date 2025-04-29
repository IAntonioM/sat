<?php

namespace App\Models;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolicitudAcceso extends Model
{
    protected $table = 'SOLICITUD_ACCESO';
    protected $primaryKey = 'iCodPreTramite';
    public $timestamps = false;

    protected $fillable = [
        'iCodRemitente',
        'iTipoDocuId',
        'nNumDocuId',
        'cRazonSocial',
        'cApePate',
        'cApeMate',
        'cNombres',
        'cAsunto',
        'cDireccion',
        'correoDestino',
        'cNumeExpe',
        'cNombreOriginal',
        'cNombreNuevo',
        'cExtension',
        'cRutaFile',
        'cSizeFile',
        'fFecIngreso',
        'nFlgEstado',
        'iCodTrabajadorUpdate',
        'fFecEstadoUpdate',
        'cArgumentoRechazo',
        'cCodificacion',
        'iCodTramite',
        'nClave',
        'cCodTipoDoc',
        'dFechaSolicitud',
        'cEstacionSolicitud',
        'cUsuarioActualizacion',
        'dFechaActualizacion',
        'cEstacionActualizacion',
        'telefono'
    ];

    // Opcional: Accessors/Casting fechas
    protected $casts = [
        'fFecIngreso' => 'datetime',
        'fFecEstadoUpdate' => 'datetime',
        'dFechaSolicitud' => 'datetime',
        'dFechaActualizacion' => 'datetime',
    ];

    public static function registrarSolicitud($params)
    {
        $sql = '
            EXEC dbo.SolicitudAcceso
                @Accion = 1,
                @iTipoDocuId = :iTipoDocuId,
                @nNumDocuId = :nNumDocuId,
                @cRazonSocial = :cRazonSocial,
                @cApePate = :cApePate,
                @cApeMate = :cApeMate,
                @cNombres = :cNombres,
                @cAsunto = :cAsunto,
                @cDireccion = :cDireccion,
                @correoDestino = :correoDestino,
                @cExtension = :cExtension,
                @cRutaFile = :cRutaFile,
                @cSizeFile = :cSizeFile,
                @cEstacionSolicitud = :cEstacionSolicitud,
                @telefono = :telefono

        ';

        // Filtramos solo los parámetros necesarios para evitar errores
        $requiredParams = [
            'iTipoDocuId',
            'nNumDocuId',
            'cRazonSocial',
            'cApePate',
            'cApeMate',
            'cNombres',
            'cAsunto',
            'cDireccion',
            'correoDestino',
            'cExtension',
            'cRutaFile',
            'cSizeFile',
            'cEstacionSolicitud',
            'telefono'
        ];

        $filteredParams = array_intersect_key($params, array_flip($requiredParams));

        return DB::select($sql, $filteredParams);
    }
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
    public static function obtenerSolicitudes($estado)
    {
        return DB::select(
            'EXEC SolicitudAcceso @Accion = 2, @nFlgEstado = ?;',
            [$estado]
        );
    }

    /**
     * Obtiene los estados disponibles
     *
     * @return array
     */
    public static function obtenerEstadosDisponibles()
    {
        $result = DB::select('SELECT DISTINCT nFlgEstado, CASE
                           WHEN nFlgEstado = 0 THEN \'Denegado\'
                           WHEN nFlgEstado = 1 THEN \'Aceptado\'
                           WHEN nFlgEstado = 2 THEN \'En espera\'
                           ELSE \'No especificado\' END AS nombre_estado
                          FROM SOLICITUD_ACCESO');
        return $result;
    }


    public static function existeSolicitudPendiente($nNumDocuId)
    {
        $sql = '
            EXEC dbo.SolicitudAcceso
                @Accion = 3,
                @nNumDocuId = :nNumDocuId
        ';

        $result = DB::select($sql, ['nNumDocuId' => $nNumDocuId]);

        return !empty($result) && $result[0]->Existe == 1;
    }

    public static function usuarioRegistrado($nNumDocuId)
    {
        $sql = '
            EXEC dbo.SolicitudAcceso
                @Accion = 4,
                @nNumDocuId = :nNumDocuId
        ';

        $result = DB::select($sql, ['nNumDocuId' => $nNumDocuId]);

        return !empty($result) && $result[0]->Existe == 1;
    }

    public static function aceptarDenegarSolicitud($iCodPreTramite, $nFlgEstado, $cUsuarioActualizacion, $cEstacionActualizacion, $PasswordHash)
    {
        try {
            DB::statement(
                'EXEC dbo.SolicitudAcceso
                @Accion = ?,
                @iCodPreTramite = ?,
                @nFlgEstado = ?,
                @cUsuarioActualizacion = ?,
                @cEstacionActualizacion = ?,
                @PasswordHash = ?',
                [5, $iCodPreTramite, $nFlgEstado, $cUsuarioActualizacion, $cEstacionActualizacion, $PasswordHash]
            );
            return true;
        } catch (\Exception $e) {
            Debugbar::error('Error al procesar la solicitud: ' . $e->getMessage());
            return false;
        }
    }

    public static function traerUsuarioNuevo($nroDoc)
    {
        try {
            $resultado = DB::select(
                'select top 1 * from MUSUARIO where vnrodoc = ? order by cidusu desc',
                [$nroDoc]
            );

            return $resultado ? $resultado[0] : null;
        } catch (\Exception $e) {
            Debugbar::error('Error al procesar la solicitud: ' . $e->getMessage());
            return null;
        }
    }
}

//1 - aceptado
//2 -denegado
//0 pendiente
