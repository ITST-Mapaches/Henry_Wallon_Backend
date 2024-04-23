<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Cuentas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'cuentas';

    protected $primaryKey = "id";

    protected $fillable = [
        'telefono',
        'correo',
        'contrasena',
        'activo',
        'id_persona',
        'id_rol',
    ];

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
        ];
    }
}
