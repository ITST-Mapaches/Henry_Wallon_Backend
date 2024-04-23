<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docentes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'docentes';

    protected $primaryKey = "id";

    protected $fillable = [
        'cedula_prof',
        'id_persona',
    ];
}
