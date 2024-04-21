<?php

namespace Database\Seeders;

use App\Models\PeriodosEvaluaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodosEvaluacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeriodosEvaluaciones::factory(1)->create();
    }
}
