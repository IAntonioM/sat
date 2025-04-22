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
        $sql = <<<SQL
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
                @cEstacionSolicitud = :cEstacionSolicitud
        SQL;

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
            'cEstacionSolicitud'
        ];

        $filteredParams = array_intersect_key($params, array_flip($requiredParams));

        return DB::select($sql, $filteredParams);
    }


}
