<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoDocumento extends Model
{
    protected $table = 'T_DOC';
    protected $primaryKey = 'id_doc';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_doc',
        'id_docc',
        'doc',
        'digitos',
        'operador',
        'estacion',
        'nestado',
        'fechor_ing',
    ];

    public static function obtenerTipoDocs($id_doc = null, $id_docc = null, $nestado = null)
    {
        return DB::select(
            "EXEC dbo.ConsultarDoc @Accion = 1, @id_doc = ?, @id_docc = ?, @nestado = ?",
            [$id_doc, $id_docc, $nestado]
        );
    }
}
