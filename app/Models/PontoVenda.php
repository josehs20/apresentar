<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoVenda extends Model
{
    protected $table = 'pontos_venda';

    protected $fillable = [
        'nome',
        'endereco',
        'cidade',
        'estado',
        'telefone',
        'whatsapp',
        'latitude',
        'longitude',
        'google_maps_link',
        'horario_funcionamento',
        'ativo',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'ativo' => 'boolean',
    ];

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->whatsapp) {
            return null;
        }
        $numero = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/55{$numero}";
    }
}