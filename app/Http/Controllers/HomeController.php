<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoSite;
use App\Models\Postagem;
use App\Models\Produto;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destaques = Produto::with('categoria')
            ->where('ativo', true)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $ultimosPosts = Postagem::whereNotNull('publicado_em')
            ->where('publicado_em', '<=', now())
            ->orderBy('publicado_em', 'desc')
            ->take(3)
            ->get();
            
        $configuracoes = ConfiguracaoSite::all()->pluck('valor', 'chave')->toArray();
        
        $heroImagem      = $configuracoes['hero_imagem'] ?? null;
        $heroTitulo      = $configuracoes['hero_titulo'] ?? null;
        $heroSub         = $configuracoes['hero_subtitulo'] ?? null;
        $heroBadge       = $configuracoes['hero_badge'] ?? null;
        $sobreImagem     = $configuracoes['sobre_imagem'] ?? null;
        $sobreBadge      = $configuracoes['sobre_badge'] ?? null;
        $sobreTitulo     = $configuracoes['sobre_titulo'] ?? null;
        $sobreDescricao  = $configuracoes['sobre_descricao'] ?? null;
        $sobreStat1Valor  = $configuracoes['sobre_stat_1_valor'] ?? null;
        $sobreStat1Titulo = $configuracoes['sobre_stat_1_titulo'] ?? null;
        $sobreStat2Valor  = $configuracoes['sobre_stat_2_valor'] ?? null;
        $sobreStat2Titulo = $configuracoes['sobre_stat_2_titulo'] ?? null;
        $sobreStat3Valor  = $configuracoes['sobre_stat_3_valor'] ?? null;
        $sobreStat3Titulo = $configuracoes['sobre_stat_3_titulo'] ?? null;
        $contatoTelefone = $configuracoes['contato_telefone'] ?? null;
        $contatoEmail    = $configuracoes['contato_email'] ?? null;
        $contatoEndereco = $configuracoes['contato_endereco'] ?? null;
        $instagramUrl    = $configuracoes['instagram_url'] ?? null;

        return view('home', compact(
            'destaques',
            'ultimosPosts',
            'heroImagem',
            'heroTitulo',
            'heroSub',
            'heroBadge',
            'sobreImagem',
            'sobreBadge',
            'sobreTitulo',
            'sobreDescricao',
            'sobreStat1Valor',
            'sobreStat1Titulo',
            'sobreStat2Valor',
            'sobreStat2Titulo',
            'sobreStat3Valor',
            'sobreStat3Titulo',
            'contatoTelefone',
            'contatoEmail',
            'contatoEndereco',
            'instagramUrl',
        ));
    }
}