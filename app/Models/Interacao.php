<?php

namespace App\Models;

use Database\Factories\InteracaoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'produto_id',
    'tipo_interacao_id',
    'ip',
    'user_agent',
    'criado_em',
])]
class Interacao extends Model
{
    /** @use HasFactory<InteracaoFactory> */
    use HasFactory;

    /**
     * Tabela não possui colunas de created_at/updated_at
     * tradicionais, apenas `criado_em`.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'interacoes';
    /**
     * Casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'criado_em' => 'datetime',
        ];
    }

    /**
     * Interação pertence a um Produto (opcional).
     */
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    /**
     * Interação pertence a um TipoInteracao.
     */
    public function tipoInteracao(): BelongsTo
    {
        return $this->belongsTo(TipoInteracao::class);
    }
}
