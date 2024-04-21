<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutores>
 */
class TutoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener los IDs de las personas que tienen el rol "docente"
        $personas = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'tutor')
            ->pluck('personas.id')
            ->toArray();

        return [
            'id_persona' => fake()->randomElement($personas),
            'ocupacion' => fake()->word(),
            'id_admin' => 1,
        ];
    }
}
