<?php

namespace App\Services\Admin;

use App\Models\TipoInteracao;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class TipoInteracaoService
{
    public function listar(array $filters = []): LengthAwarePaginator
    {
        $query = TipoInteracao::withCount('interacoes')->orderBy('nome');

        if (!empty($filters['search'])) {
            $query->where('nome', 'like', "%{$filters['search']}%");
        }

        return $query->paginate(10);
    }

    public function criar(array $data): TipoInteracao
    {
        DB::beginTransaction();
        try {
            $tipo = TipoInteracao::create($data);
            DB::commit();
            return $tipo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizar(TipoInteracao $tipoInteracao, array $data): TipoInteracao
    {
        DB::beginTransaction();
        try {
            $tipoInteracao->update($data);
            DB::commit();
            return $tipoInteracao->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletar(TipoInteracao $tipoInteracao): void
    {
        DB::beginTransaction();
        try {
            $tipoInteracao->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function listarTodas()
    {
        return TipoInteracao::orderBy('nome')->get();
    }

    public function ativar(TipoInteracao $tipoInteracao): TipoInteracao
    {
        DB::beginTransaction();
        try {
            $tipoInteracao->update(['ativo' => true]);
            DB::commit();
            return $tipoInteracao->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function desativar(TipoInteracao $tipoInteracao): TipoInteracao
    {
        DB::beginTransaction();
        try {
            $tipoInteracao->update(['ativo' => false]);
            DB::commit();
            return $tipoInteracao->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}