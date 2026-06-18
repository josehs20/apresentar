<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLojaVinculadaRequest;
use App\Http\Requests\Admin\UpdateLojaVinculadaRequest;
use App\Models\LojaVinculada;
use App\Services\Admin\LojaVinculadaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LojaVinculadaController extends Controller
{
    public function __construct(
        protected LojaVinculadaService $lojaVinculadaService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'ativo']);
        $lojas = $this->lojaVinculadaService->listar($filters);

        return view('admin.lojas-vinculadas.index', compact('lojas'));
    }

    public function store(StoreLojaVinculadaRequest $request): JsonResponse
    {
        $loja = $this->lojaVinculadaService->criar($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loja vinculada criada com sucesso!',
            'data'    => $loja,
        ]);
    }

    public function create(): View
    {
        return view('admin.lojas-vinculadas.create');
    }

    public function edit(LojaVinculada $lojaVinculada): View
    {
        return view('admin.lojas-vinculadas.edit', compact('lojaVinculada'));
    }

    public function show(LojaVinculada $lojaVinculada): JsonResponse
    {
        return response()->json([
            'data' => $lojaVinculada,
        ]);
    }

    public function update(UpdateLojaVinculadaRequest $request, LojaVinculada $lojaVinculada): JsonResponse
    {
        $loja = $this->lojaVinculadaService->atualizar($lojaVinculada, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Loja vinculada atualizada com sucesso!',
            'data'    => $loja,
        ]);
    }

    public function destroy(LojaVinculada $lojaVinculada): JsonResponse
    {
        $this->lojaVinculadaService->deletar($lojaVinculada);

        return response()->json([
            'success' => true,
            'message' => 'Loja vinculada removida com sucesso!',
        ]);
    }

    public function table(Request $request): View
    {
        $filters = $request->only(['search', 'ativo']);
        $lojas = $this->lojaVinculadaService->listar($filters);

        return view('admin.lojas-vinculadas.table', compact('lojas'));
    }
}