<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id'    => 'required|exists:categorias,id',
            'nome'            => 'required|string|max:255',
            'descricao'       => 'nullable|string',
            'composicao'      => 'nullable|string',
            'preco'           => 'nullable|numeric|min:0',
            'ativo'           => 'boolean',
            'tipo_pele'       => 'nullable|string|max:100',
            'meta_titulo'     => 'nullable|string|max:70',
            'meta_descricao'  => 'nullable|string|max:160',
            'meta_imagem'     => 'nullable|string|max:255',
            'imagem'          => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'imagem.max' => 'A imagem não pode ultrapassar 2MB.',
        ];
    }

    protected function prepareForValidation()
{
    if ($this->preco) {
        $preco = str_replace('.', '', $this->preco); // remove milhar
        $preco = str_replace(',', '.', $preco); // troca vírgula por ponto

        $this->merge([
            'preco' => $preco
        ]);
    }
}
}