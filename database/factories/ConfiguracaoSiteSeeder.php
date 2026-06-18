<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ConfiguracaoSite;

class ConfiguracaoSiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->hero();
        $this->sobre();
        $this->contato();
        $this->geral();
    }

    private function hero()
    {
        ConfiguracaoSite::insert([
            [
                'chave' => 'hero.titulo',
                'valor' => 'Beleza Natural Artesanal',
                'tipo' => 'texto',
                'grupo' => 'hero',
                'descricao' => 'Título principal da home',
            ],
            [
                'chave' => 'hero.subtitulo',
                'valor' => 'Cuidado natural para sua pele com ingredientes selecionados',
                'tipo' => 'texto',
                'grupo' => 'hero',
                'descricao' => 'Subtítulo da home',
            ],
            [
                'chave' => 'hero.imagem',
                'valor' => 'hero/' . Str::random(10) . '.jpg',
                'tipo' => 'imagem',
                'grupo' => 'hero',
                'descricao' => 'Imagem principal do hero',
            ],
        ]);
    }

    private function sobre()
    {
        ConfiguracaoSite::insert([
            [
                'chave' => 'sobre.titulo',
                'valor' => 'Sobre a marca',
                'tipo' => 'texto',
                'grupo' => 'sobre',
                'descricao' => 'Título da seção sobre',
            ],
            [
                'chave' => 'sobre.texto',
                'valor' => fake()->paragraph(4),
                'tipo' => 'html',
                'grupo' => 'sobre',
                'descricao' => 'Texto institucional',
            ],
            [
                'chave' => 'sobre.imagem',
                'valor' => 'sobre/' . Str::random(10) . '.jpg',
                'tipo' => 'imagem',
                'grupo' => 'sobre',
                'descricao' => 'Imagem da seção sobre',
            ],
        ]);
    }

    private function contato()
    {
        ConfiguracaoSite::insert([
            [
                'chave' => 'contato.whatsapp_numero',
                'valor' => '5599999999999',
                'tipo' => 'texto',
                'grupo' => 'contato',
                'descricao' => 'Número do WhatsApp',
            ],
            [
                'chave' => 'contato.instagram_url',
                'valor' => 'https://instagram.com/seuuser',
                'tipo' => 'texto',
                'grupo' => 'contato',
                'descricao' => 'Link do Instagram',
            ],
        ]);
    }

    private function geral()
    {
        ConfiguracaoSite::insert([
            [
                'chave' => 'seo.meta_title',
                'valor' => fake()->sentence(5),
                'tipo' => 'texto',
                'grupo' => 'geral',
                'descricao' => 'Meta title global',
            ],
            [
                'chave' => 'seo.meta_description',
                'valor' => fake()->sentence(12),
                'tipo' => 'texto',
                'grupo' => 'geral',
                'descricao' => 'Meta description global',
            ],
            [
                'chave' => 'seo.meta_image',
                'valor' => 'seo/' . Str::random(10) . '.jpg',
                'tipo' => 'imagem',
                'grupo' => 'geral',
                'descricao' => 'Imagem SEO',
            ],
        ]);
    }
}