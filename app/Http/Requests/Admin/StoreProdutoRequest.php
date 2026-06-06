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
            $preco = $this->preco;

            // Se tiver vírgula, assume formato brasileiro: 1.199,90 ou 119,90
            if (str_contains($preco, ',')) {
                // Remove pontos de milhar: 1.199,90 → 1199,90
                $preco = str_replace('.', '', $preco);
                // Troca vírgula decimal por ponto: 1199,90 → 1199.90
                $preco = str_replace(',', '.', $preco);
            }
            // Se não tiver vírgula, assume que já está no formato americano (119.90) ou inteiro (119)

            $this->merge([
                'preco' => $preco
            ]);
        }
    }
}