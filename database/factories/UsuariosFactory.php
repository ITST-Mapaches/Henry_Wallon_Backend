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
            'nombre' => fake()->name,
            'ap_paterno' => fake()->lastName(),
            'ap_materno' => fake()->lastName(),
            'nacimiento' => fake()->date(),
            'telefono' => substr(uniqid(), 0, 12),
            'nombre_usuario' => fake()->unique()->userName(),
            'contrasena' => static::$password ??= Hash::make('password'),
            'activo' => fake()->numberBetween(0, 1),
            'id_sexo' => Sexos::inRandomOrder()->first()->id,
            'id_rol' => Roles::inRandomOrder()->first()->id,
            'remember_token' => Str::random(10),
        ];
    }
}
