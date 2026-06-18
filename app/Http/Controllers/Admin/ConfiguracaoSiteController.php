<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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

        // Se for upload de imagem, processa o arquivo
        if ($data['tipo'] === 'imagem' && $request->hasFile('imagem')) {
            $data['valor'] = $request->file('imagem')->store('site', 'public');
        }

        ConfiguracaoSite::create($data);
        ConfiguracaoSite::limparCache();
        Cache::forget('cores_site');

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

        // Se for upload de imagem, processa o arquivo e apaga o anterior
        if ($data['tipo'] === 'imagem' && $request->hasFile('imagem')) {
            // Apaga imagem anterior se existir
            if ($configuracao->valor && Storage::disk('public')->exists($configuracao->valor)) {
                Storage::disk('public')->delete($configuracao->valor);
            }
            $data['valor'] = $request->file('imagem')->store('site', 'public');
        }

        $configuracao->update($data);
        ConfiguracaoSite::limparCache();
        Cache::forget('cores_site');

        return redirect()->route('admin.configuracoes.index')
            ->with('success', 'Configuração atualizada!');
    }

    public function destroy($configuracao)
    {
        $configuracao = ConfiguracaoSite::findOrFail($configuracao);

        // Apaga imagem do storage se for do tipo imagem
        if ($configuracao->tipo === 'imagem' && $configuracao->valor && Storage::disk('public')->exists($configuracao->valor)) {
            Storage::disk('public')->delete($configuracao->valor);
        }

        $configuracao->delete();
        ConfiguracaoSite::limparCache();
        Cache::forget('cores_site');

        return back()->with('success', 'Removido!');
    }
}
