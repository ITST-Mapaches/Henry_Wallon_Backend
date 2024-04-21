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

        $personas = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'alumno')
            ->pluck('personas.id')
            ->toArray();

        $cantidad = count($personas);

        Alumnos::factory($cantidad)->create();
    }
}
