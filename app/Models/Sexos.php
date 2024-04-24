<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'sexos';

    protected $primaryKey = "id";

    protected $fillable = [
        'nombre'
    ];
}
