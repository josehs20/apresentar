<?php

namespace Database\Factories;

use App\Models\Postagem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Postagem>
 */
class PostagemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = fake()->unique()->sentence(5);

        return [
            'titulo'         => rtrim($titulo, '.'),
            'slug'           => Str::slug($titulo) . '-' . Str::random(5),
            'resumo'         => fake()->paragraph(2),
            'conteudo'       => collect(range(1, 5))
                ->map(fn () => '<p>' . fake()->paragraph(6) . '</p>')
                ->implode("\n"),
            'caminho_imagem' => 'postagens/' . Str::random(10) . '.jpg',
            'publicado_em'   => fake()->dateTimeBetween('-1 year', 'now'),

            // SEO
            'meta_titulo'    => fake()->sentence(5),
            'meta_descricao' => fake()->sentence(15),
            'meta_imagem'    => 'seo/' . Str::random(10) . '.jpg',
        ];
    }

    /**
     * Estado: postagem ainda não publicada (rascunho).
     */
    public function rascunho(): static
    {
        return $this->state(fn () => ['publicado_em' => null]);
    }
}
