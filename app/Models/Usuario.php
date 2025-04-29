<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $usuario = trim($usuario);
        $password = trim($password);
        $user = DB::table('musuario')
            ->where('vnrodoc', $usuario)
            ->first();

        if ($user && Hash::check($password, $user->vpass)) {
            return $user; // Credenciales válidas
        }

        return null; // Credenciales inválidas
    }

    public function updatePassword(string $usuario, string $passwordActual, string $nuevoPassword)
    {
        $usuario = trim($usuario);
        $passwordActual = trim($passwordActual);
        $nuevoPassword = trim($nuevoPassword);
        $user = DB::table('musuario')
            ->where('vnrodoc', $usuario)
            ->first();
        if ($user && Hash::check($passwordActual, $user->vpass)) {
            $nuevoHash = Hash::make($nuevoPassword);
            DB::table('musuario')
                ->where('vnrodoc', $usuario)
                ->update([
                    'vpass' => $nuevoHash,
                    'vpreg' => '1', // Aquí actualizas el campo vpreg
                ]);
            return DB::table('musuario')
                ->where('vnrodoc', $usuario)
                ->where('vestado', '001')
                ->first();
        }
        return null; // Si no se cumple la validación
    }

    public static function listarCuentasPorNroDoc(string $nroDoc)
    {
        $nroDoc = trim($nroDoc);
        return DB::table('musuario')
            ->where('vnrodoc', $nroDoc)
            ->where('vestado', '<>', '004')
            ->get(); // Devuelve una colección de resultados
    }

    public static function validarNroDocyCodigo(string $vnrodoc, string $vcodcontr): bool
    {
        $vnrodoc = trim($vnrodoc);
        $vcodcontr = trim($vcodcontr);

        return DB::table('musuario')
            ->where('vnrodoc', $vnrodoc)
            ->where('vcodcontr', $vcodcontr)
            ->where('vestado', '<>', '004')
            ->exists();
    }
    public static function existeNroDocumento(string $nroDoc): bool
    {
        $nroDoc = trim($nroDoc);
        return DB::table('musuario')
            ->where('vnrodoc', $nroDoc)
            ->where('vestado', '<>', '004')
            ->exists();
    }
}
