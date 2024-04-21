<?php

namespace Database\Seeders;

use App\Models\Kardex;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KardexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kardex::factory(15)->create();
    }
}
