<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generaciones extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'generaciones';

    protected $primaryKey = "id";

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
    ];
}
