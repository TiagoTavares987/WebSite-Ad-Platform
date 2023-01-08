<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compra>
 */
class CompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'compradorId' => fake()->randomNumber(1),
            'anuncioId' => fake()->randomNumber(2),
            'preco' => fake()->randomNumber(2),
            'quantidade' => fake()->randomNumber(1),
        ];
    }
}
