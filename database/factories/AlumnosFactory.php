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
        $personas = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'alumno')
            ->pluck('personas.id')
            ->toArray();

        $admins = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'administrador')
            ->pluck('personas.id')
            ->toArray();



        return [
            'id_persona' => fake()->randomElement($personas),
            'num_control' => substr(uniqid(), 0, 15),
            'id_tutor' => Tutores::inRandomOrder()->first()->id,
            'id_periodo' => PeriodosEscolares::inRandomOrder()->first()->id,
            'id_grupo' => Grupos::inRandomOrder()->first()->id,
            'id_admin' => fake()->randomElement($admins),
            'id_generacion' => Generaciones::inRandomOrder()->first()->id,
        ];
    }
}
