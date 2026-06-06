<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\ProdutoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'categoria_id',
    'nome',
    'slug',
    'descricao',
    'composicao',
    'preco',
    'caminho_imagem',
    'ativo',
    'tipo_pele',
    'meta_titulo',
    'meta_descricao',
    'meta_imagem',
])]
class Produto extends Model
{
    /** @use HasFactory<ProdutoFactory> */
    use HasFactory, HasUniqueSlug, SoftDeletes;

    /**
     * Atributo de origem usado para gerar o slug automaticamente.
     */
    protected string $slugSource = 'nome';

    /**
     * Casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Produto pertence a uma Categoria.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Produto possui várias Interações.
     */
    public function interacoes(): HasMany
    {
        return $this->hasMany(Interacao::class);
    }

    /**
     * Retorna a URL completa da imagem para uso nas views.
     */
    public function getImagemUrlAttribute(): ?string
    {
        if (!$this->caminho_imagem) {
            return null;
        }
        return asset('storage/' . $this->caminho_imagem);
    }

    /**
     * Retorna apenas o nome do arquivo (sem o caminho da pasta).
     */
    public function getImagemNomeAttribute(): ?string
    {
        if (!$this->caminho_imagem) {
            return null;
        }
        return basename($this->caminho_imagem);
    }
}
