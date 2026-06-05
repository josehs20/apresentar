<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('categorium');

        return [
            'nome'      => 'required|string|max:255|unique:categorias,nome,' . $id,
            'descricao' => 'nullable|string',
        ];
    }
}