<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interacao;
use App\Services\Admin\TipoInteracaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InteracaoController extends Controller
{
    public function __construct(
        protected TipoInteracaoService $tipoInteracaoService
    ) {}

    public function index(Request $request): View
    {
        $query = Interacao::with(['produto', 'tipoInteracao'])
            ->orderBy('criado_em', 'desc');

        if ($request->filled('tipo_interacao_id')) {
            $query->where('tipo_interacao_id', $request->tipo_interacao_id);
        }

        if ($request->filled('produto_nome')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', "%{$request->produto_nome}%");
            });
        }

        $interacoes = $query->paginate(20);
        $tipos = $this->tipoInteracaoService->listarTodas();

        return view('admin.interactions.index', compact('interacoes', 'tipos'));
    }

    public function destroy($interacao): JsonResponse
    {
        $interacao = Interacao::findOrFail($interacao);
        $interacao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Interação removida com sucesso!',
        ]);
    }
}