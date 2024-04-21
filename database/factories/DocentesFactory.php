<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docentes>
 */
class DocentesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Obtener los IDs de las personas que tienen el rol "docente"
        $idPersonasDocentes = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'docente')
            ->pluck('personas.id')
            ->toArray();

        return [
            'cedula_prof' => substr(uniqid(), 0, 20),
            'id_persona' => fake()->randomElement($idPersonasDocentes),
            'id_admin' => 1,
        ];
    }
}
