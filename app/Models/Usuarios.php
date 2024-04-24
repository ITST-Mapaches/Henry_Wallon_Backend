<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = "id";

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'nacimiento',
        'telefono',
        'nombre_usuario',
        'contrasena',
        'activo',
        'id_sexo',
        'id_rol',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
        ];
    }
}
