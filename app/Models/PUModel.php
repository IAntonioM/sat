<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PUModel extends Model
{
    protected $table = 'PU_PORTAL'; // We'll use raw queries with the stored procedure

    public static function getPredioDatos($vcodcontr, $year, $idanexo)
    {
        return DB::select(
            "exec pxConsultasWeb2 @msquery='5', @vcodcontr=?, @paramt5=?, @paramt3=?",
            [$vcodcontr, $year, $idanexo]
        );
    }

    public static function getUserData($vcodcontr)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='1', @vcodcontr=?", [$vcodcontr])[0] ?? null;
    }

    public static function obtenerDatosContribuyente($vcodcontr)
    {
        return DB::select("exec pxConsultasWeb2 @msquery='1', @vcodcontr=?", [$vcodcontr])[0] ?? null;
    }
}
