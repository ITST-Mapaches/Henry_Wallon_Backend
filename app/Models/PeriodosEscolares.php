<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodosEscolares extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'periodos_escolares';

    protected $primaryKey = "id";

    protected $fillable = [
        'numero',
        'nombre_tipo',
        'fecha_inicio',
        'fecha_fin',
    ];
}
