<?php

namespace Database\Seeders;

use App\Models\Momentos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MomentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Momentos::factory(15)->create();
    }
}
