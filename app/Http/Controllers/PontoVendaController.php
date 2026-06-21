<?php

namespace App\Http\Controllers;

use App\Models\PontoVenda;

class PontoVendaController extends Controller
{
    public function index()
    {
        $pontos = PontoVenda::ativos()->orderBy('nome')->get();
        return view('pontos-venda', compact('pontos'));
    }
}