<?php

namespace Database\Seeders;

use App\Models\Sexos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sexos::factory()->create([
            'nombre' => 'Masculino',
        ]);

        Sexos::factory()->create([
            'nombre' => 'Femenino',
        ]);
    }
}
