<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(): View
    {
        $cards = $this->dashboardService->obterCards();
        $interacoesPorTipo = $this->dashboardService->obterInteracoesPorTipo();
        $interacoesPorDia = $this->dashboardService->obterInteracoesPorDia();
        $produtosMaisClicados = $this->dashboardService->obterProdutosMaisClicados();
        $produtosWhatsApp = $this->dashboardService->obterProdutosMaisClicadosPorTipo('whatsapp');
        $produtosInstagram = $this->dashboardService->obterProdutosMaisClicadosPorTipo('instagram');

        return view('admin.dashboard', compact(
            'cards',
            'interacoesPorTipo',
            'interacoesPorDia',
            'produtosMaisClicados',
            'produtosWhatsApp',
            'produtosInstagram'
        ));
    }

    public function metricas(Request $request): JsonResponse
    {
        $cards = $this->dashboardService->obterCards();
        $interacoesPorTipo = $this->dashboardService->obterInteracoesPorTipo();
        $interacoesPorDia = $this->dashboardService->obterInteracoesPorDia();
        $produtosMaisClicados = $this->dashboardService->obterProdutosMaisClicados();
        $produtosWhatsApp = $this->dashboardService->obterProdutosMaisClicadosPorTipo('whatsapp');
        $produtosInstagram = $this->dashboardService->obterProdutosMaisClicadosPorTipo('instagram');

        return response()->json([
            'cards' => $cards,
            'interacoesPorTipo' => $interacoesPorTipo,
            'interacoesPorDia' => $interacoesPorDia,
            'produtosMaisClicados' => $produtosMaisClicados,
            'produtosWhatsApp' => $produtosWhatsApp,
            'produtosInstagram' => $produtosInstagram,
        ]);
    }
}