<?php

namespace Database\Seeders;

use App\Models\Asignaturas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Asignaturas::factory(30)->create();
    }
}
