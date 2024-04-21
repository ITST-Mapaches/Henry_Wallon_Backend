<?php

namespace Database\Seeders;

use App\Models\Cuentas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cuentas::factory(100)->create();
    }
}
