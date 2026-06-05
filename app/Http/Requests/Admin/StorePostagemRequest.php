<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostagemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'          => 'required|string|max:255',
            'resumo'          => 'nullable|string',
            'conteudo'        => 'required|string',
            'publicado_em'    => 'nullable|date',
            'meta_titulo'     => 'nullable|string|max:70',
            'meta_descricao'  => 'nullable|string|max:160',
            'meta_imagem'     => 'nullable|string|max:255',
            'imagem'          => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];
    }
}