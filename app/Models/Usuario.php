<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
