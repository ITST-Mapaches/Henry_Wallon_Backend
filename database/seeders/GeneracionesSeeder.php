<?php

namespace Database\Seeders;

use App\Models\Generaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Generaciones::factory()->create([
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
        ]);
    }
}
