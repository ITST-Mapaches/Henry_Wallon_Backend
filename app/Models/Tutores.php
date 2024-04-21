<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutores extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tutores';

    protected $primaryKey = "id";

    protected $fillable = [
        'id_persona',
        'ocupacion',
        'id_admin',
    ];
}
