<?php

namespace Database\Seeders;

use App\Models\ConfiguracaoSite;
use Illuminate\Database\Seeder;

class ConfiguracaoCoresSeeder extends Seeder
{
    public function run(): void
    {
        $cores = [
            [
                'chave'     => 'cor_primary',
                'valor'     => '#76877D',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Cor principal da marca (botões, links, ícones principais)',
            ],
            [
                'chave'     => 'cor_secondary',
                'valor'     => '#96958A',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Títulos de seções e elementos institucionais',
            ],
            [
                'chave'     => 'cor_accent',
                'valor'     => '#88B8A9',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Destaques e CTAs (botões de conversão)',
            ],
            [
                'chave'     => 'cor_border_soft',
                'valor'     => '#B2CBAE',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Bordas suaves de cards e divisores',
            ],
            [
                'chave'     => 'cor_light',
                'valor'     => '#F8F6F0',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Fundo principal (off-white premium)',
            ],
            [
                'chave'     => 'cor_dark',
                'valor'     => '#2B2B2B',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Textos de leitura',
            ],
            [
                'chave'     => 'cor_primary_light',
                'valor'     => '#8B9F95',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Variação clara da cor principal (hover)',
            ],
            [
                'chave'     => 'cor_accent_light',
                'valor'     => '#9CC8BB',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Variação clara da cor de destaque (hover)',
            ],
            [
                'chave'     => 'cor_light_2',
                'valor'     => '#F0EDE5',
                'tipo'      => 'cor',
                'grupo'     => 'cores',
                'descricao' => 'Segundo tom de fundo (gradientes, hover)',
            ],
        ];

        foreach ($cores as $cor) {
            ConfiguracaoSite::firstOrCreate(
                ['chave' => $cor['chave']],
                $cor
            );
        }

        ConfiguracaoSite::limparCache();
    }
}