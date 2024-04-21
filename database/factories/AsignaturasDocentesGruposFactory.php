<?php

namespace Database\Factories;

use App\Models\Asignaturas;
use App\Models\Docentes;
use App\Models\Grupos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsignaturasDocentesGrupos>
 */
class AsignaturasDocentesGruposFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_asignatura' => Asignaturas::inRandomOrder()->first()->id,
            'id_docente' => Docentes::inRandomOrder()->first()->id,
            'id_grupo' => Grupos::inRandomOrder()->first()->id,
        ];
    }
}
