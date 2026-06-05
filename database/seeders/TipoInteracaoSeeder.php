<?php

namespace Database\Seeders;

use App\Models\TipoInteracao;
use Illuminate\Database\Seeder;

/**
 * Popula a tabela `tipo_interacoes` com os tipos iniciais.
 *
 * Novos tipos podem ser adicionados sem migration, apenas incluindo-os
 * no array abaixo e rodando este seeder novamente (ele é idempotente).
 */
class TipoInteracaoSeeder extends Seeder
{
    /**
     * Lista de tipos padrão do sistema.
     *
     * @var array<string, string>
     */
    protected array $tipos = [
        'whatsapp'  => 'Clique no botão de WhatsApp do produto',
        'instagram' => 'Clique no link do Instagram da loja',
    ];

    public function run(): void
    {
        foreach ($this->tipos as $nome => $descricao) {
            TipoInteracao::query()->updateOrCreate(
                ['nome' => $nome],
                ['descricao' => $descricao],
            );
        }

        $this->command?->info('TipoInteracaoSeeder: ' . count($this->tipos) . ' tipos de interação garantidos.');
    }
}
