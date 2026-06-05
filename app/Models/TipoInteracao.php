<?php

namespace App\Models;

use Database\Factories\TipoInteracaoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nome', 'descricao', 'ativo'])]
class TipoInteracao extends Model
{
    use HasFactory;

    protected $table = 'tipo_interacoes';

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function interacoes(): HasMany
    {
        return $this->hasMany(Interacao::class);
    }
}