<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StorePostagemRequest;
use App\Http\Requests\Admin\UpdatePostagemRequest;
use App\Jobs\ProcessarImagem;
use App\Models\Postagem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class PostagemService
{
    public function listar(array $filters = []): LengthAwarePaginator
    {
        $query = Postagem::orderBy('created_at', 'desc');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('titulo', 'like', "%{$filters['search']}%")
                  ->orWhere('resumo', 'like', "%{$filters['search']}%");
            });
        }

        return $query->paginate(10);
    }

    public function criar(StorePostagemRequest $request): Postagem
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $postagem = Postagem::create($data);

            if ($request->hasFile('imagem')) {
                $caminho = $request->file('imagem')->store('temp', 'local');
                ProcessarImagem::dispatch($caminho, Postagem::class, $postagem->id);
            }

            DB::commit();
            return $postagem->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar(UpdatePostagemRequest $request, Postagem $postagem): Postagem
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $postagem->update($data);

            if ($request->hasFile('imagem')) {
                if ($postagem->caminho_imagem) {
                    Storage::disk('public')->delete($postagem->caminho_imagem);
                }

                $caminho = $request->file('imagem')->store('temp', 'local');
                ProcessarImagem::dispatch($caminho, Postagem::class, $postagem->id);
            }

            DB::commit();
            return $postagem->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletar(Postagem $postagem): void
    {
        DB::beginTransaction();
        try {
            if ($postagem->caminho_imagem) {
                Storage::disk('public')->delete($postagem->caminho_imagem);
            }
            $postagem->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}