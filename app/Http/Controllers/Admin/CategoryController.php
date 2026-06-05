<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriaRequest;
use App\Http\Requests\Admin\UpdateCategoriaRequest;
use App\Models\Categoria;
use App\Services\Admin\CategoriaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoriaService $categoriaService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $categorias = $this->categoriaService->listar($filters);

        return view('admin.categories.index', compact('categorias'));
    }

    public function store(StoreCategoriaRequest $request): JsonResponse
    {
        $categoria = $this->categoriaService->criar($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Categoria criada com sucesso!',
            'data'    => $categoria,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function edit(Categoria $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function show(Categoria $category): JsonResponse
    {
        return response()->json([
            'data' => $category->loadCount('produtos'),
        ]);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $category): JsonResponse
    {
        $categoria = $this->categoriaService->atualizar($category, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Categoria atualizada com sucesso!',
            'data'    => $categoria,
        ]);
    }

    public function destroy(Categoria $category): JsonResponse
    {
        if ($category->produtos()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir uma categoria que possui produtos vinculados.',
            ], 422);
        }

        $this->categoriaService->deletar($category);

        return response()->json([
            'success' => true,
            'message' => 'Categoria removida com sucesso!',
        ]);
    }

    public function table(Request $request): View
    {
        $filters = $request->only(['search']);
        $categorias = $this->categoriaService->listar($filters);

        return view('admin.categories.table', compact('categorias'));
    }

    public function listAll(): JsonResponse
    {
        return response()->json([
            'data' => $this->categoriaService->listarTodas(),
        ]);
    }
}