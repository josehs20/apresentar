<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoInteracaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'      => 'required|string|max:50|unique:tipo_interacoes,nome',
            'descricao' => 'nullable|string|max:255',
            'ativo'     => 'boolean',
        ];
    }
}