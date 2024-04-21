<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'kardex';

    protected $primaryKey = "id";

    protected $fillable = [
        'id_alumno',
        'id_asignatura',
        'cal_primer_momento',
        'cal_segundo_momento',
        'cal_tercer_momento',
    ];
}
