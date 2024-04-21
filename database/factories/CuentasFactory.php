<?php

namespace Database\Factories;

use App\Models\Personas;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuentas>
 */
class CuentasFactory extends Factory
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
            'url_image' => fake()->word,
            'telefono' => substr(uniqid(), 0, 12),
            'correo' => fake()->unique()->safeEmail(),
            'contrasena' => static::$password ??= Hash::make('password'),
            'activo' => fake()->numberBetween(0, 1),
            'id_persona' => Personas::inRandomOrder()->first()->id,
            'id_rol' => Roles::inRandomOrder()->first()->id,
        ];
    }
}
