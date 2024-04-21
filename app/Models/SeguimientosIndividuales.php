<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientosIndividuales extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'seguimientos_individuales';

    protected $primaryKey = "id";

    protected $fillable = [
        'descripcion',
        'id_alumno',
        'id_asignatura',
        'id_docente',
    ];
}
