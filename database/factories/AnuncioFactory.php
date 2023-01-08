<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anuncio>
 */
class AnuncioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendedorId' => fake()->randomNumber(1),
            'nome' => fake()->name(),
            'descricao' => fake()->name(),
            'preco' => fake()->randomNumber(3),
            'quantidade' => fake()->randomNumber(1),
            'apagado' => fake()->randomElement([true, false]),
        ];
    }
}
