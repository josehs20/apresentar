<?php

namespace Database\Seeders;

use App\Models\ConfiguracaoSite;
use Illuminate\Database\Seeder;

class ConfiguracaoSiteSeeder extends Seeder
{
    public function run(): void
    {
        $configuracoes = [
            // Hero
            ['chave' => 'hero_imagem',     'valor' => 'site/hero.jpg', 'tipo' => 'imagem', 'grupo' => 'hero', 'descricao' => 'Imagem do Hero (3:4 portrait)'],
            ['chave' => 'hero_titulo',    'valor' => 'Cuide da sua pele com natureza', 'tipo' => 'texto', 'grupo' => 'hero'],
            ['chave' => 'hero_subtitulo', 'valor' => 'Produtos artesanais feitos com ingredientes selecionados. Descubra uma rotina de cuidados que vai transformar seu dia a dia.', 'tipo' => 'texto', 'grupo' => 'hero'],
            ['chave' => 'hero_badge',     'valor' => 'Produtos Naturais', 'tipo' => 'texto', 'grupo' => 'hero'],

            // Sobre
            ['chave' => 'sobre_imagem',      'valor' => 'site/sobre.jpg', 'tipo' => 'imagem', 'grupo' => 'sobre', 'descricao' => 'Imagem da seção Sobre a Marca (4:3)'],
            ['chave' => 'sobre_badge',      'valor' => 'Nossa História', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_titulo',     'valor' => 'Feito com amor e natureza', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_descricao',  'valor' => 'Acreditamos que o cuidado com a pele começa com ingredientes que você pode reconhecer. Cada produto é desenvolvido com carinho usando o que a natureza tem de melhor para oferecer.', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_1_titulo', 'valor' => 'Natural', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_1_valor',  'valor' => '100%', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_2_titulo', 'valor' => 'Produtos', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_2_valor',  'valor' => '10+', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_3_titulo', 'valor' => 'Clientes', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_3_valor',  'valor' => '500+', 'tipo' => 'texto', 'grupo' => 'sobre'],

            // Contato
            ['chave' => 'contato_telefone',  'valor' => '(XX) XXXXX-XXXX', 'tipo' => 'texto', 'grupo' => 'contato'],
            ['chave' => 'contato_email',     'valor' => 'contato@tierramar.com.br', 'tipo' => 'texto', 'grupo' => 'contato'],
            ['chave' => 'contato_endereco',  'valor' => 'Sua cidade, Brasil', 'tipo' => 'texto', 'grupo' => 'contato'],
        ];

        foreach ($configuracoes as $config) {
            ConfiguracaoSite::updateOrCreate(
                ['chave' => $config['chave']],
                $config
            );
        }

        $this->command?->info('ConfiguracoesSiteSeeder: ' . count($configuracoes) . ' configurações garantidas.');
    }
}