<?php

namespace Database\Factories;

use App\Models\Alumnos;
use App\Models\Asignaturas;
use App\Models\Docentes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeguimientosIndividuales>
 */
class SeguimientosIndividualesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => fake()->word(),
            'id_alumno' => Alumnos::inRandomOrder()->first()->id,
            'id_asignatura' => Asignaturas::inRandomOrder()->first()->id,
            'id_docente' => Docentes::inRandomOrder()->first()->id,
        ];
    }
}
