<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoSite;
use Illuminate\Http\Request;

class ConfiguracaoSiteController extends Controller
{
    public function index()
    {
        $configs = ConfiguracaoSite::orderBy('grupo')->get()->groupBy('grupo');

        return view('admin.configuracoes.index', compact('configs'));
    }

    public function create()
    {
        return view('admin.configuracoes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'chave' => 'required|unique:configuracoes_site,chave',
            'valor' => 'nullable',
            'tipo' => 'required',
            'grupo' => 'required',
            'descricao' => 'nullable',
        ]);

        ConfiguracaoSite::create($data);
        ConfiguracaoSite::limparCache();

        return redirect()->route('admin.configuracoes.index')
            ->with('success', 'Configuração criada com sucesso!');
    }

    public function edit($configuracao)
    {
        $configuracao = ConfiguracaoSite::findOrFail($configuracao);
        return view('admin.configuracoes.edit', compact('configuracao'));
    }

    public function update(Request $request, $configuracao)
    {
        $data = $request->validate([
            'valor' => 'nullable',
            'tipo' => 'required',
            'grupo' => 'required',
            'descricao' => 'nullable',
        ]);
        
        $configuracao = ConfiguracaoSite::findOrFail($configuracao);
        $configuracao->update($data);
        ConfiguracaoSite::limparCache();

        return redirect()->route('admin.configuracoes.index')
            ->with('success', 'Configuração atualizada!');
    }

    public function destroy($configuracao)
    {
        $configuracao = ConfiguracaoSite::findOrFail($configuracao);
        $configuracao->delete();
        ConfiguracaoSite::limparCache();

        return back()->with('success', 'Removido!');
    }
}