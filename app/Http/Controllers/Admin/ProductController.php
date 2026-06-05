<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProdutoRequest;
use App\Http\Requests\Admin\UpdateProdutoRequest;
use App\Models\Produto;
use App\Services\Admin\CategoriaService;
use App\Services\Admin\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProdutoService $produtoService,
        protected CategoriaService $categoriaService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'categoria_id', 'ativo']);
        $produtos = $this->produtoService->listar($filters);
        $categorias = $this->categoriaService->listarTodas();

        return view('admin.products.index', compact('produtos', 'categorias'));
    }

    public function create(): View
    {
        $categorias = $this->categoriaService->listarTodas();
        return view('admin.products.create', compact('categorias'));
    }

    public function store(StoreProdutoRequest $request)
    {
        $this->produtoService->criar($request);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $product): View
    {
        $product->load('categoria');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Produto $product): View
    {
        $categorias = $this->categoriaService->listarTodas();
        return view('admin.products.edit', compact('product', 'categorias'));
    }

    public function update(UpdateProdutoRequest $request, $product)
    {
        $product = Produto::findOrFail($product);
        $this->produtoService->atualizar($request, $product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Request $request, Produto $product)
    {
        $this->produtoService->deletar($product);

        // 👉 Se for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produto removido com sucesso!',
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produto removido com sucesso!');
    }

    public function table(Request $request): View
    {
        $filters = $request->only(['search', 'categoria_id', 'ativo']);
        $produtos = $this->produtoService->listar($filters);

        return view('admin.products.table', compact('produtos'));
    }
}