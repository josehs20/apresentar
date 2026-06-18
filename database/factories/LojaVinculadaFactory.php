<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LojaVinculada>
 */
class LojaVinculadaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->company() . ' Cosméticos',
            'endereco' => fake()->streetAddress(),
            'cidade' => fake()->city(),
            'estado' => fake()->stateAbbr(),
            'telefone' => fake()->phoneNumber(),
            'instagram' => '@' . fake()->userName(),
            'link_google_maps' => 'https://maps.google.com/?q=' . fake()->latitude() . ',' . fake()->longitude(),
            'ativo' => true,
        ];
    }

    public function inativo(): static
    {
        return $this->state(fn (array $attributes) => [
            'ativo' => false,
        ]);
    }
}