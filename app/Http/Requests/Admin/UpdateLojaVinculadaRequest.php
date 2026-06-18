<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLojaVinculadaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'endereco' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:100'],
            'estado' => ['required', 'string', 'max:2', 'min:2'],
            'telefone' => ['nullable', 'string', 'max:50'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'link_google_maps' => ['nullable', 'string', 'max:500'],
            'ativo' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado.max' => 'O estado deve ter exatamente 2 caracteres (ex: SP, RJ).',
            'estado.min' => 'O estado deve ter exatamente 2 caracteres (ex: SP, RJ).',
        ];
    }
}