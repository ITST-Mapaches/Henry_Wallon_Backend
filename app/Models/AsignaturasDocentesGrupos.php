<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturasDocentesGrupos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'asignaturas_docentes_grupos';

    protected $primaryKey = "id";

    protected $fillable = [
        'id_asignatura',
        'id_docente',
        'id_grupo',
    ];
}
