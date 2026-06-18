<?php

namespace Database\Factories;

use App\Models\Interacao;
use App\Models\Produto;
use App\Models\TipoInteracao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Interacao>
 */
class InteracaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produto_id'        => Produto::factory(),
            'tipo_interacao_id' => TipoInteracao::factory(),
            'ip'                => fake()->ipv4(),
            'user_agent'        => fake()->userAgent(),
            'criado_em'         => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Estado: interação sem produto vinculado.
     */
    public function semProduto(): static
    {
        return $this->state(fn () => ['produto_id' => null]);
    }
}
