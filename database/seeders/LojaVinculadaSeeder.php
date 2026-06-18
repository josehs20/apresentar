<?php

namespace Database\Seeders;

use App\Models\LojaVinculada;
use Illuminate\Database\Seeder;

class LojaVinculadaSeeder extends Seeder
{
    public function run(): void
    {
        LojaVinculada::create([
            'nome' => 'Espaço Boho Cosméticos',
            'endereco' => 'Rua das Flores, 123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone' => '(11) 99999-0001',
            'instagram' => '@espacoboho',
            'link_google_maps' => 'https://maps.google.com/?q=-23.550520,-46.633309',
            'ativo' => true,
        ]);

        LojaVinculada::create([
            'nome' => 'Farmácia Naturalle',
            'endereco' => 'Av. Paulista, 1000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone' => '(11) 99999-0002',
            'instagram' => '@farmacianaturalle',
            'link_google_maps' => 'https://maps.google.com/?q=-23.561000,-46.656000',
            'ativo' => true,
        ]);

        LojaVinculada::create([
            'nome' => 'Bem Estar Natural',
            'endereco' => 'Rua Augusta, 500',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone' => '(11) 99999-0003',
            'instagram' => '@bemestarnatural',
            'link_google_maps' => 'https://maps.google.com/?q=-23.555000,-46.660000',
            'ativo' => true,
        ]);

        // Cria mais 2 lojas usando factory para variedade
        LojaVinculada::factory()->count(2)->create();
    }
}