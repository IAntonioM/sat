<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contribuyente extends Model
{
    protected $table = 'MUSUARIO'; // nombre exacto de la tabla
    protected $primaryKey = 'cidusu'; // clave primaria
    public $incrementing = false; // porque es char(10), no auto-incremental
    protected $keyType = 'string'; // tipo string por ser char
    public $timestamps = false; // si no usás created_at / updated_at

    // Campos protegidos que no deben ser visibles
    protected $hidden = ['vclave', 'vpass', 'vresp'];

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'cidusu',
        'ctipers',
        'vrazon',
        'vnombre',
        'vpater',
        'vmater',
        'vrep',
        'csexo',
        'dfecnac',
        'vdoc',
        'vnrodoc',
        'vcodcontr',
        'ubigeo',
        'vcentp',
        'vdirec',
        'vtel',
        'vcel',
        'vocup',
        'vcorreo',
        'vcorredos',
        'vestado',
        'dfecregist',
        'vgiro',
        'vsistema',
        'vnivel',
        'vpreg'
    ];

    //Obteenr contribuyente por vcodcontr
    public static function obtenerDatosContri($vcodcontr)
    {
        return self::where('vcodcontr', $vcodcontr)->first();
    }

}
