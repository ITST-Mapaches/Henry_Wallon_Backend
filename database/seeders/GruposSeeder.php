<?php

namespace Database\Seeders;

use App\Models\Grupos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grupos::factory()->create([
            'prefijo' => 'A'
        ]);

        Grupos::factory()->create([
            'prefijo' => 'B'
        ]);

        Grupos::factory()->create([
            'prefijo' => 'C'
        ]);
    }
}
