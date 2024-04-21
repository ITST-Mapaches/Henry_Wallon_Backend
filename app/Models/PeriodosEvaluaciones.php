<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodosEvaluaciones extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'periodo_evaluaciones';

    protected $primaryKey = "id";

    protected $fillable = [
        'activo'
    ];
}
