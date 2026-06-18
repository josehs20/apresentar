<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LojaVinculada extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'estado',
        'telefone',
        'instagram',
        'link_google_maps',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }
}