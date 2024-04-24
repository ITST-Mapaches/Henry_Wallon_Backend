<?php

namespace Database\Seeders;

use App\Models\AsignaturasDocentesGrupos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturasDocentesGruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AsignaturasDocentesGrupos::factory(30)->create();
    }
}
