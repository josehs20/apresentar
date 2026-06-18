<?php

namespace Database\Factories;

use App\Models\TipoInteracao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TipoInteracao>
 */
class TipoInteracaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = [
            'whatsapp'    => 'Clique no botão de WhatsApp do produto',
            'instagram'   => 'Clique no link do Instagram',
            'clique_site' => 'Clique em link externo do site',
            'telefone'    => 'Clique para ligar',
            'email'       => 'Clique no endereço de e-mail',
        ];

        $nome = fake()->unique()->randomElement(array_keys($tipos));

        return [
            'nome'      => $nome,
            'descricao' => $tipos[$nome],
        ];
    }
}
