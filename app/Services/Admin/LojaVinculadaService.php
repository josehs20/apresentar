<?php

namespace App\Services\Admin;

use App\Models\LojaVinculada;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class LojaVinculadaService
{
    public function listar(array $filters = []): LengthAwarePaginator
    {
        $query = LojaVinculada::orderBy('nome');

        if (!empty($filters['search'])) {
            $query->where('nome', 'like', "%{$filters['search']}%");
        }

        if (!empty($filters['ativo'])) {
            $query->where('ativo', $filters['ativo'] === 'sim');
        }

        return $query->paginate(10);
    }

    public function criar(array $data): LojaVinculada
    {
        DB::beginTransaction();
        try {
            $loja = LojaVinculada::create($data);
            DB::commit();
            return $loja;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar(LojaVinculada $lojaVinculada, array $data): LojaVinculada
    {
        DB::beginTransaction();
        try {
            $lojaVinculada->update($data);
            DB::commit();
            return $lojaVinculada->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletar(LojaVinculada $lojaVinculada): void
    {
        DB::beginTransaction();
        try {
            $lojaVinculada->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarAtivas()
    {
        return LojaVinculada::where('ativo', true)->orderBy('nome')->get();
    }
}