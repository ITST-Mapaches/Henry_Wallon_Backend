<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personas>
 */
class PersonasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name,
            'ap_paterno' => fake()->lastName,
            'ap_materno' => fake()->lastName,
            'nacimiento' => fake()->date(),
            'id_sexo' => fake()->numberBetween(1, 2),
            'id_admin' => 1,
        ];
    }
}
