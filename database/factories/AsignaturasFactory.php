<?php

namespace Database\Factories;

use App\Models\PeriodosEscolares;
use App\Models\Personas;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asignaturas>
 */
class AsignaturasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'clave' => substr(uniqid(), 0, 10),
            'nombre' => fake()->name,
            'objetivo' => fake()->paragraph(),
            'id_periodo' => PeriodosEscolares::inRandomOrder()->first()->id,
            'calificacion_aprobatoria' => 7,
        ];
    }
}
