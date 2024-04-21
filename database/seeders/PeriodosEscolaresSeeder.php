<?php

namespace Database\Seeders;

use App\Models\PeriodosEscolares;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodosEscolaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tipo = 'Semestre';

        PeriodosEscolares::factory()->create([
            'numero' => 1,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);

        PeriodosEscolares::factory()->create([
            'numero' => 2,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);

        PeriodosEscolares::factory()->create([
            'numero' => 3,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);

        PeriodosEscolares::factory()->create([
            'numero' => 4,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);

        PeriodosEscolares::factory()->create([
            'numero' => 5,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);

        PeriodosEscolares::factory()->create([
            'numero' => 6,
            'nombre_tipo' => $tipo,
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);
    }
}
