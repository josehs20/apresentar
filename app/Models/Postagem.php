<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\PostagemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'titulo',
    'slug',
    'resumo',
    'conteudo',
    'caminho_imagem',
    'publicado_em',
    'meta_titulo',
    'meta_descricao',
    'meta_imagem',
])]
class Postagem extends Model
{
    /** @use HasFactory<PostagemFactory> */
    use HasFactory, HasUniqueSlug, SoftDeletes;

    /**
     * Nome da tabela (evita pluralização incorreta do Laravel).
     */
    protected $table = 'postagens';

    /**
     * Atributo de origem usado para gerar o slug automaticamente.
     */
    protected string $slugSource = 'titulo';

    /**
     * Casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publicado_em' => 'datetime',
        ];
    }
}
