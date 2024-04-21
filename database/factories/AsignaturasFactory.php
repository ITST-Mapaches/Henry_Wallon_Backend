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
        $admins = DB::table('personas')
            ->join('cuentas', 'personas.id', '=', 'cuentas.id_persona')
            ->join('roles', 'cuentas.id_rol', '=', 'roles.id')
            ->where('roles.rol', 'administrador')
            ->pluck('personas.id')
            ->toArray();

        return [
            'clave' => substr(uniqid(), 0, 10),
            'nombre' => fake()->name,
            'competencia' => fake()->paragraph(),
            'id_periodo' => PeriodosEscolares::inRandomOrder()->first()->id,
            'id_admin' => fake()->randomElement($admins)
        ];
    }
}
