<?php

namespace App\Services\Admin;

use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriaService
{
    public function listar(array $filters = []): LengthAwarePaginator
    {
        $query = Categoria::withCount('produtos')->orderBy('nome');

        if (!empty($filters['search'])) {
            $query->where('nome', 'like', "%{$filters['search']}%");
        }

        return $query->paginate(10);
    }

    public function criar(array $data): Categoria
    {
        DB::beginTransaction();
        try {
            $categoria = Categoria::create($data);
            DB::commit();
            return $categoria;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar(Categoria $categoria, array $data): Categoria
    {
        DB::beginTransaction();
        try {
            $categoria->update($data);
            DB::commit();
            return $categoria->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletar(Categoria $categoria): void
    {
        DB::beginTransaction();
        try {
            $categoria->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarTodas()
    {
        return Categoria::orderBy('nome')->get();
    }
}