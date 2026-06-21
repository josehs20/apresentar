<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PontoVenda;
use Illuminate\Http\Request;

class PontoVendaController extends Controller
{
    public function index()
    {
        $pontos = PontoVenda::orderBy('nome')->paginate(15);
        return view('admin.pontos-venda.index', compact('pontos'));
    }

    public function create()
    {
        return view('admin.pontos-venda.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'nullable|string',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_maps_link' => 'nullable|string|max:500',
            'horario_funcionamento' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        $data['ativo'] = $request->boolean('ativo');

        PontoVenda::create($data);

        return redirect()->route('admin.pontos-venda.index')
            ->with('success', 'Ponto de venda cadastrado com sucesso!');
    }

    public function edit(PontoVenda $pontoVenda)
    {
        return view('admin.pontos-venda.edit', compact('pontoVenda'));
    }

    public function update(Request $request, PontoVenda $pontoVenda)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'nullable|string',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'google_maps_link' => 'nullable|string|max:500',
            'horario_funcionamento' => 'nullable|string',
            'ativo' => 'boolean',
        ]);

        $data['ativo'] = $request->boolean('ativo');

        $pontoVenda->update($data);

        return redirect()->route('admin.pontos-venda.index')
            ->with('success', 'Ponto de venda atualizado!');
    }

    public function destroy(PontoVenda $pontoVenda)
    {
        $pontoVenda->delete();

        return redirect()->route('admin.pontos-venda.index')
            ->with('success', 'Ponto de venda removido!');
    }
}