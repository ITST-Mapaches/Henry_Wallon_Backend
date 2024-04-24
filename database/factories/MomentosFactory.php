<?php

namespace Database\Factories;

use App\Models\Alumnos;
use App\Models\Asignaturas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Momentos>
 */
class MomentosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_alumno' => Alumnos::inRandomOrder()->first()->id,
            'id_asignatura' => Asignaturas::inRandomOrder()->first()->id,
            'cal_primer_momento' => fake()->numberBetween(7, 10),
            'cal_segundo_momento' => fake()->numberBetween(7, 10),
            'cal_tercer_momento' => fake()->numberBetween(7, 10),
        ];
    }
}
