<?php

namespace Database\Seeders;

use DB;
use App\Models\Tutores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TutoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personas = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'tutor')
            ->pluck('personas.id')
            ->toArray();

        $cantidad = count($personas);

        Tutores::factory($cantidad)->create();
    }
}
