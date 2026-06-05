<?php

namespace App\Http\Controllers;

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

        return view('home', compact('destaques', 'ultimosPosts'));
    }
}