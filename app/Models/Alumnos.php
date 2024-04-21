<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'alumnos';

    protected $primaryKey = "id";

    protected $fillable = [
        'id_persona',
        'num_control',
        'id_tutor',
        'id_periodo',
        'id_grupo',
        'id_admin',
        'id_generacion',
    ];
}
