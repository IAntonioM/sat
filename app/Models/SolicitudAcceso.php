<?php

namespace App\Models;

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

    public static function listarSolicitud($params)
    {
        $sql = "
        EXEC dbo.SolicitudAcceso
            @Accion = 2,
            @nFlgEstado = :nFlgEstado,
            @NombreRuc = :NombreRuc,
            @cAsunto = :cAsunto,
            @dFechaSolicitud = :dFechaSolicitud,
            @dFechaActualizacion = :dFechaActualizacion
    ";

        return DB::select($sql, $params);
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


}
