<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTipoInteracaoRequest;
use App\Http\Requests\Admin\UpdateTipoInteracaoRequest;
use App\Models\TipoInteracao;
use App\Services\Admin\TipoInteracaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipoInteracaoController extends Controller
{
    public function __construct(
        protected TipoInteracaoService $tipoInteracaoService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $tipos = $this->tipoInteracaoService->listar($filters);

        return view('admin.tipos-interacao.index', compact('tipos'));
    }

    public function store(StoreTipoInteracaoRequest $request): JsonResponse
    {
        $tipo = $this->tipoInteracaoService->criar($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tipo de interação criado com sucesso!',
            'data'    => $tipo,
        ]);
    }

    public function update(UpdateTipoInteracaoRequest $request, TipoInteracao $tipoInteracao): JsonResponse
    {
        $tipo = $this->tipoInteracaoService->atualizar($tipoInteracao, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tipo de interação atualizado com sucesso!',
            'data'    => $tipo,
        ]);
    }

    public function destroy(TipoInteracao $tipoInteracao): JsonResponse
    {
        if ($tipoInteracao->interacoes()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir um tipo que possui interações vinculadas.',
            ], 422);
        }

        $this->tipoInteracaoService->deletar($tipoInteracao);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de interação removido com sucesso!',
        ]);
    }

    public function toggleAtivo(TipoInteracao $tipoInteracao): JsonResponse
    {
        if ($tipoInteracao->ativo) {
            $this->tipoInteracaoService->desativar($tipoInteracao);
            $message = 'Tipo de interação desativado.';
        } else {
            $this->tipoInteracaoService->ativar($tipoInteracao);
            $message = 'Tipo de interação ativado.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $tipoInteracao->fresh(),
        ]);
    }

    public function table(Request $request): View
    {
        $filters = $request->only(['search']);
        $tipos = $this->tipoInteracaoService->listar($filters);

        return view('admin.tipos-interacao.table', compact('tipos'));
    }

    public function listAll(): JsonResponse
    {
        return response()->json([
            'data' => $this->tipoInteracaoService->listarTodas(),
        ]);
    }
}