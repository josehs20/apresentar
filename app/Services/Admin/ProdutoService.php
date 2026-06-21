<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreProdutoRequest;
use App\Http\Requests\Admin\UpdateProdutoRequest;
use App\Models\Produto;
use App\Services\Admin\ImagemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            unset($data['imagem']); // Remove o arquivo do array de dados (não é coluna no banco)
            $produto = Produto::create($data);

            if ($request->hasFile('imagem')) {
                $relativePath = ImagemService::processarUpload($request, 'imagem', $produto, 'produtos');
                Log::info('[ProdutoService] Upload processado na criação', ['path' => $relativePath]);
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
            unset($data['imagem']); // Remove o arquivo do array de dados (não é coluna no banco)
            
            Log::info('[ProdutoService] Atualizando produto', [
                'id' => $produto->id,
                'data' => $data,
                'hasFile' => $request->hasFile('imagem'),
            ]);

            $produto->update($data);

            if ($request->hasFile('imagem')) {
                Log::info('[ProdutoService] Processando upload de imagem...');
                $relativePath = ImagemService::processarUpload($request, 'imagem', $produto, 'produtos');
                Log::info('[ProdutoService] Upload processado na atualização', ['path' => $relativePath]);
            }
            DB::commit();
            return $produto->fresh('categoria');
        } catch (\Exception $e) {
            Log::error('[ProdutoService] Erro ao atualizar produto', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
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