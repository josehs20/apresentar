<?php

namespace Database\Seeders;

use App\Models\PontoVenda;
use Illuminate\Database\Seeder;

class PontoVendaSeeder extends Seeder
{
    public function run(): void
    {
        $pontos = [
            [
                'nome' => 'Loja Matriz - Jardins',
                'endereco' => 'Rua Oscar Freire, 900',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'telefone' => '(11) 99999-0001',
                'whatsapp' => '(11) 99999-0001',
                'latitude' => -23.5610,
                'longitude' => -46.6630,
                'google_maps_link' => 'https://maps.app.goo.gl/example1',
                'horario_funcionamento' => 'Seg-Sex: 9h-19h | Sáb: 10h-16h',
                'ativo' => true,
            ],
            [
                'nome' => 'Feira Orgânica - Parque Ibirapuera',
                'endereco' => 'Av. Pedro Álvares Cabral, s/n - Portão 3',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'telefone' => '(11) 98888-0002',
                'whatsapp' => '(11) 98888-0002',
                'latitude' => -23.5874,
                'longitude' => -46.6576,
                'horario_funcionamento' => 'Sáb: 7h-13h',
                'ativo' => true,
            ],
            [
                'nome' => 'Empório Natural - Vila Madalena',
                'endereco' => 'Rua Harmonia, 200',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'telefone' => '(11) 97777-0003',
                'whatsapp' => '(11) 97777-0003',
                'latitude' => -23.5466,
                'longitude' => -46.6893,
                'horario_funcionamento' => 'Seg-Sáb: 8h-20h',
                'ativo' => true,
            ],
            [
                'nome' => 'Quitanda Natural - Campinas',
                'endereco' => 'Rua Treze de Maio, 450',
                'cidade' => 'Campinas',
                'estado' => 'SP',
                'telefone' => '(19) 96666-0004',
                'whatsapp' => '(19) 96666-0004',
                'latitude' => -22.9053,
                'longitude' => -47.0609,
                'horario_funcionamento' => 'Seg-Sex: 8h-18h | Sáb: 8h-12h',
                'ativo' => true,
            ],
            [
                'nome' => 'Boutique Natural - Rio de Janeiro',
                'endereco' => 'Rua Visconde de Pirajá, 550 - Ipanema',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'telefone' => '(21) 95555-0005',
                'whatsapp' => '(21) 95555-0005',
                'latitude' => -22.9838,
                'longitude' => -43.2096,
                'horario_funcionamento' => 'Seg-Sáb: 9h-20h',
                'ativo' => true,
            ],
            [
                'nome' => 'Empório da Serra - Campos do Jordão',
                'endereco' => 'Av. Dr. Januário Miraglia, 1200',
                'cidade' => 'Campos do Jordão',
                'estado' => 'SP',
                'telefone' => '(12) 94444-0006',
                'whatsapp' => '(12) 94444-0006',
                'latitude' => -22.7392,
                'longitude' => -45.5914,
                'horario_funcionamento' => 'Seg-Dom: 9h-18h',
                'ativo' => true,
            ],
            [
                'nome' => 'Loja Virtual - Retirada',
                'endereco' => 'Rua Augusta, 1500 - Consolação',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'telefone' => '(11) 93333-0007',
                'whatsapp' => '(11) 93333-0007',
                'latitude' => -23.5558,
                'longitude' => -46.6590,
                'google_maps_link' => 'https://maps.app.goo.gl/example7',
                'horario_funcionamento' => 'Seg-Sex: 10h-18h',
                'ativo' => false,
            ],
        ];

        foreach ($pontos as $ponto) {
            PontoVenda::create($ponto);
        }

        $this->command->info('✅ ' . count($pontos) . ' pontos de venda criados!');
    }
}