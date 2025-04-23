<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecordPapeleta extends Model
{
    // Nombre real de la tabla
    protected $table = 'RECORD_PAPELETAS';

    // Laravel por defecto espera una columna 'id' como primary key.
    // Si tu tabla tiene otra clave primaria, debes especificarla:
    protected $primaryKey = 'codigo';

    // Si la clave primaria no es autoincremental
    public $incrementing = false;

    // Si la clave primaria no es un entero
    protected $keyType = 'string';

    // Si no estás usando timestamps (created_at, updated_at)
    public $timestamps = false;

    // Opcionalmente, puedes definir los campos que se pueden asignar en masa
    protected $fillable = [
        'codigo',
        'nrodoc',
        'nombre',
        'nro_papeleta',
        'placa',
        'infraccion',
        'detalle_infraccion',
        'fecha_infraccion',
        'nrodoc_propietario',
        'nombre_propietario',
        'infractor',
        'estado',
        'deuda',
        'deuda_dscto',
    ];
    public static function listarPapeletas($codigo = null, $termBusq = null)
    {
        return DB::select('EXEC RecordPapeletas @accion = ?, @term_busq = ?, @codigo = ?', [1, $termBusq, $codigo]);
    }

    public static function totalPagar($codigo)
    {
        return DB::select('EXEC RecordPapeletas @accion = ?, @codigo = ?', [2, $codigo]);
    }
}
