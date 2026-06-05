<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoInteracaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('tipo_interacao');

        return [
            'nome'      => 'required|string|max:50|unique:tipo_interacoes,nome,' . $id,
            'descricao' => 'nullable|string|max:255',
            'ativo'     => 'boolean',
        ];
    }
}