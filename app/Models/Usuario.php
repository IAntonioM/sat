<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'dbo.MUSUARIO';

    protected $fillable = [
        'cidusu',
        'vclave',
        //'user_tipo',
    ];

    protected $hidden = [
        'vclave',
    ];

    public function getAuthPassword()
    {
        return $this->vclave;
    }

    public $timestamps = false;

    public function validateUserCredentials(string $usuario, string $password)
    {
        return DB::table('musuario')
            ->where('vcodcontr', $usuario)
            ->whereRaw("CAST(vpass AS VARCHAR(20)) = ?", [$password])
            ->first();
    }
    public function updatePassword(string $usuario, string $passwordActual, string $nuevoPassword)
    {
        $update = DB::update(
            "UPDATE musuario
             SET vpreg = '1', vpass = CAST(? AS varbinary)
             WHERE vcodcontr = ?
               AND CAST(vpass AS varchar(20)) = ?
               AND vestado = '001'",
            [$nuevoPassword, $usuario, $passwordActual]
        );

        if ($update > 0) {
            return DB::table('musuario')
                ->where('vcodcontr', $usuario)
                ->whereRaw("CAST(vpass AS VARCHAR(20)) = ?", [$nuevoPassword])
                ->where('vestado', '001')
                ->first();
        }

        return null;
    }

}
