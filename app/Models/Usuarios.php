<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

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
    ];
}
