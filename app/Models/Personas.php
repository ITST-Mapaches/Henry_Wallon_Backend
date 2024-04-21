<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $primaryKey = "id";

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'nacimiento',
        'id_sexo',
        'id_admin',
    ];
}
