<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Roles;
use App\Models\Sexos;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Humberto',
            'ap_paterno' => 'De La Cruz',
            'ap_materno' => 'Domínguez',
            'nacimiento' => '2002-12-13',
            'telefono' => '2311343979',
            'nombre_usuario' => 'HumbertDz',
            'contrasena' => Hash::make('h13h12h2002'),
            'activo' => 1,
            'id_sexo' => Sexos::inRandomOrder()->first()->id,
            'id_rol' => 1,
            'remember_token' => Str::random(10),
        ];
    }
}
