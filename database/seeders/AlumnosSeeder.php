<?php

namespace Database\Seeders;

use App\Models\Alumnos;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlumnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $usuarios = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'alumno')
            ->pluck('usuarios.id')
            ->toArray();

        $cantidad = count($usuarios);

        Alumnos::factory($cantidad)->create();
    }
}
