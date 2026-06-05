<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostagemRequest;
use App\Http\Requests\Admin\UpdatePostagemRequest;
use App\Models\Postagem;
use App\Services\Admin\PostagemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostagemService $postagemService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search']);
        $postagens = $this->postagemService->listar($filters);

        return view('admin.posts.index', compact('postagens'));
    }

    public function create(): View
    {
        return view('admin.posts.create');
    }

 public function store(StorePostagemRequest $request)
{
    $this->postagemService->criar($request);

    return redirect()
        ->route('admin.posts.index')
        ->with('success', 'Postagem criada com sucesso!');
}

    public function show(Postagem $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Postagem $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

 public function update(UpdatePostagemRequest $request, Postagem $post)
{
    $this->postagemService->atualizar($request, $post);

    return redirect()
        ->route('admin.posts.index')
        ->with('success', 'Postagem atualizada com sucesso!');
}

    public function destroy(Postagem $post): JsonResponse
    {
        $this->postagemService->deletar($post);

        return response()->json([
            'success' => true,
            'message' => 'Postagem removida com sucesso!',
        ]);
    }

    public function table(Request $request): View
    {
        $filters = $request->only(['search']);
        $postagens = $this->postagemService->listar($filters);

        return view('admin.posts.table', compact('postagens'));
    }
}