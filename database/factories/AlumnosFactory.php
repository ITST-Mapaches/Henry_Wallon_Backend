<?php

namespace Database\Factories;

use App\Models\Generaciones;
use App\Models\Grupos;
use App\Models\PeriodosEscolares;
use App\Models\Personas;
use App\Models\Tutores;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumnos>
 */
class AlumnosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuarios = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'alumno')
            ->pluck('usuarios.id')
            ->toArray();

        $tutores = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'tutor')
            ->pluck('usuarios.id')
            ->toArray();

        return [
            'id_usuario' => fake()->randomElement($usuarios),
            'num_control' => substr(uniqid(), 0, 15),
            'id_usuario_tutor' => fake()->randomElement($tutores),
            'id_periodo' => PeriodosEscolares::inRandomOrder()->first()->id,
            'id_grupo' => Grupos::inRandomOrder()->first()->id,
        ];
    }
}
