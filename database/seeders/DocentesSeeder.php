<?php

namespace Database\Seeders;

use App\Models\Docentes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DocentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //obtiene los docentes
        $docentes = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'docente')
            ->pluck('usuarios.id')
            ->toArray();

        //cuenta la cantidad para crear los registros
        $cantidad = count($docentes);

        Docentes::factory($cantidad)->create();
    }
}
