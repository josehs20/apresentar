<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoCor;
use Illuminate\Http\Request;

class ConfiguracaoCorController extends Controller
{
    public function edit()
    {
        $config = ConfiguracaoCor::global();
        return view('admin.configuracoes-cores.edit', compact('config'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'primary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'accent_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'border_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $config = ConfiguracaoCor::global();
        $config->update($data);

        return redirect()->route('admin.configuracoes-cores.edit')
            ->with('success', 'Cores atualizadas com sucesso!');
    }
}