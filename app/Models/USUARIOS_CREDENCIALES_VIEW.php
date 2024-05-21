<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class USUARIOS_CREDENCIALES_VIEW extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'USUARIOS_CREDENCIALES_VIEW';

    protected $primaryKey = "id";

    protected $fillable = ['nombre', 'nombre_usuario', 'password'. 'rol'];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}