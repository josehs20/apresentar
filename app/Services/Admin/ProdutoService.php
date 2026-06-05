<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreProdutoRequest;
use App\Http\Requests\Admin\UpdateProdutoRequest;
use App\Jobs\ProcessarImagem;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ProdutoService
{
    public function listar(array $filters = []): LengthAwarePaginator
    {
        $query = Produto::with('categoria')->orderBy('created_at', 'desc');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['categoria_id'])) {
            $query->where('categoria_id', $filters['categoria_id']);
        }

        if (isset($filters['ativo'])) {
            $query->where('ativo', $filters['ativo']);
        }

        return $query->paginate(10);
    }

    public function criar(StoreProdutoRequest $request): Produto
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $produto = Produto::create($data);

            if ($request->hasFile('imagem')) {
                $caminho = $request->file('imagem')->store('temp', 'local');
                ProcessarImagem::dispatch($caminho, Produto::class, $produto->id);
            }

            DB::commit();
            return $produto->fresh('categoria');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar(UpdateProdutoRequest $request, Produto $produto): Produto
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $produto->update($data);

            if ($request->hasFile('imagem')) {
                if ($produto->caminho_imagem) {
                    Storage::disk('public')->delete($produto->caminho_imagem);
                }

                $caminho = $request->file('imagem')->store('temp', 'local');
                ProcessarImagem::dispatch($caminho, Produto::class, $produto->id);
            }

            DB::commit();
            return $produto->fresh('categoria');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletar(Produto $produto): void
    {
        DB::beginTransaction();
        try {
            if ($produto->caminho_imagem) {
                Storage::disk('public')->delete($produto->caminho_imagem);
            }
            $produto->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}