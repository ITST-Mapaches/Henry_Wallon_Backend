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

        // Obtener los IDs de los usuarios que tienen el rol "docente"
        $docentes = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'docente')
            ->pluck('usuarios.id')
            ->toArray();

        return [
            'cedula_prof' => substr(uniqid(), 0, 20),
            'id_usuario' => fake()->randomElement($docentes),
        ];
    }
}
