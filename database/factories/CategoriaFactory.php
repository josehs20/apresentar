<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = fake()->unique()->words(2, true);

        return [
            'nome'      => ucfirst($nome),
            'slug'      => Str::slug($nome) . '-' . Str::random(4),
            'descricao' => fake()->sentence(8),
        ];
    }
}
