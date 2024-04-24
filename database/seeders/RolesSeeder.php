<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::factory()->create([
            'rol' => 'Administrador',
        ]);

        Roles::factory()->create([
            'rol' => 'Docente',
        ]);

        Roles::factory()->create([
            'rol' => 'Alumno',
        ]);

        Roles::factory()->create([
            'rol' => 'Tutor',
        ]);
    }
}
