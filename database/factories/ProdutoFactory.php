<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = fake()->unique()->words(3, true);

        $tiposPele = ['oleosa', 'seca', 'mista', 'sensível', 'normal', 'todas'];

        return [
            'categoria_id'   => Categoria::factory(),
            'nome'           => ucfirst($nome) . ' Natural',
            'slug'           => Str::slug($nome) . '-' . Str::random(5),
            'descricao'      => fake()->paragraph(3),
            'composicao'     => fake()->paragraph(2) . ' Ingredientes: ' . implode(', ', fake()->words(6)),
            'preco'          => fake()->randomFloat(2, 19, 250),
            'caminho_imagem' => 'produtos/' . Str::random(10) . '.jpg',
            'ativo'          => true,
            'tipo_pele'      => fake()->randomElement($tiposPele),

            // SEO
            'meta_titulo'     => fake()->sentence(4),
            'meta_descricao'  => fake()->sentence(12),
            'meta_imagem'     => 'seo/' . Str::random(10) . '.jpg',
        ];
    }

    /**
     * Estado: produto inativo.
     */
    public function inativo(): static
    {
        return $this->state(fn () => ['ativo' => false]);
    }
}
