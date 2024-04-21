<?php

namespace Database\Seeders;

use App\Models\SeguimientosIndividuales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeguimientosIndividualesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeguimientosIndividuales::factory(10)->create();
    }
}
