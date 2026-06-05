<?php

namespace App\Services\Admin;

use App\Models\Interacao;
use App\Models\Produto;
use App\Models\TipoInteracao;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function obterMetricasGerais(): array
    {
        $totalInteracoes = Interacao::count();

        $whatsappTipo = TipoInteracao::where('nome', 'whatsapp')->first();
        $instagramTipo = TipoInteracao::where('nome', 'instagram')->first();

        $totalWhatsApp = $whatsappTipo ? Interacao::where('tipo_interacao_id', $whatsappTipo->id)->count() : 0;
        $totalInstagram = $instagramTipo ? Interacao::where('tipo_interacao_id', $instagramTipo->id)->count() : 0;

        return [
            'total_interacoes' => $totalInteracoes,
            'total_whatsapp'   => $totalWhatsApp,
            'total_instagram'  => $totalInstagram,
        ];
    }

    public function obterInteracoesPorTipo(): array
    {
        return Interacao::select('tipo_interacoes.nome', DB::raw('count(*) as total'))
            ->join('tipo_interacoes', 'interacoes.tipo_interacao_id', '=', 'tipo_interacoes.id')
            ->groupBy('tipo_interacoes.nome')
            ->pluck('total', 'nome')
            ->toArray();
    }

    public function obterInteracoesPorDia(int $dias = 30): array
    {
        $results = Interacao::select(
            DB::raw('DATE(criado_em) as data'),
            DB::raw('count(*) as total')
        )
            ->where('criado_em', '>=', now()->subDays($dias))
            ->groupBy('data')
            ->orderBy('data')
            ->get()
            ->toArray();

        $datas = [];
        $valores = [];

        foreach ($results as $row) {
            $datas[] = $row['data'];
            $valores[] = (int) $row['total'];
        }

        return [
            'datas'   => $datas,
            'valores' => $valores,
        ];
    }

    public function obterProdutosMaisClicados(int $limite = 10): array
    {
        return Interacao::select('produtos.id', 'produtos.nome', DB::raw('count(*) as total'))
            ->join('produtos', 'interacoes.produto_id', '=', 'produtos.id')
            ->whereNotNull('interacoes.produto_id')
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('total')
            ->limit($limite)
            ->get()
            ->toArray();
    }

    public function obterProdutosMaisClicadosPorTipo(string $tipo, int $limite = 5): array
    {
        $tipoModel = TipoInteracao::where('nome', $tipo)->first();

        if (!$tipoModel) {
            return [];
        }

        return Interacao::select('produtos.id', 'produtos.nome', DB::raw('count(*) as total'))
            ->join('produtos', 'interacoes.produto_id', '=', 'produtos.id')
            ->where('interacoes.tipo_interacao_id', $tipoModel->id)
            ->whereNotNull('interacoes.produto_id')
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderByDesc('total')
            ->limit($limite)
            ->get()
            ->toArray();
    }

    public function obterCards(): array
    {
        $metricas = $this->obterMetricasGerais();

        return [
            ['label' => 'Total de Interações', 'value' => $metricas['total_interacoes'], 'icon' => 'bi-arrow-up-circle', 'color' => 'primary'],
            ['label' => 'Cliques WhatsApp', 'value' => $metricas['total_whatsapp'], 'icon' => 'bi-whatsapp', 'color' => 'success'],
            ['label' => 'Cliques Instagram', 'value' => $metricas['total_instagram'], 'icon' => 'bi-instagram', 'color' => 'danger'],
        ];
    }
}