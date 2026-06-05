<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['chave', 'valor', 'tipo', 'grupo', 'descricao'])]
class ConfiguracaoSite extends Model
{
    protected $table = 'configuracoes_site';

    protected $fillable = [
        'chave',
        'valor',
        'tipo',
        'grupo',
        'descricao'
    ];

    public static function get(string $chave, $default = null)
    {
        return Cache::remember("config:{$chave}", now()->addHour(), function () use ($chave, $default) {
            return self::where('chave', $chave)->value('valor') ?? $default;
        });
    }

    public static function limparCache(): void
    {
        Cache::flush(); // simples (pode otimizar depois)
    }
}