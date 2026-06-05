<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\TipoInteracao;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Produto::with('categoria')
            ->where('ativo', true);

        if ($request->filled('categoria')) {
            $query->whereHas('categoria', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        $produtos = $query->orderBy('nome')->paginate(12);
        $categorias = Categoria::orderBy('nome')->get();

        return view('catalog.index', compact('produtos', 'categorias'));
    }

    public function show(string $slug): View
    {
        $produto = Produto::with('categoria')
            ->where('slug', $slug)
            ->where('ativo', true)
            ->firstOrFail();

        $whatsappTipo = TipoInteracao::where('nome', 'whatsapp')->first();
        $instagramTipo = TipoInteracao::where('nome', 'instagram')->first();

        $whatsappTipoId = $whatsappTipo?->id;
        $instagramTipoId = $instagramTipo?->id;

        return view('catalog.show', compact(
            'produto',
            'whatsappTipoId',
            'instagramTipoId'
        ));
    }
}