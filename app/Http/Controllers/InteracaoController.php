<?php

namespace App\Http\Controllers;

use App\Models\Interacao;
use App\Models\Produto;
use App\Models\TipoInteracao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InteracaoController extends Controller
{
    /**
     * Registra a interação e redireciona conforme o tipo.
     *
     * @param  int  $produto
     * @param  string  $tipo  (whatsapp, instagram, etc)
     * @return RedirectResponse
     */
    public function redirect(string $tipo, int $produto): RedirectResponse
    {
        $tipoInteracao = TipoInteracao::where('nome', $tipo)
            ->where('ativo', true)
            ->firstOrFail();

        $produtoModel = Produto::where('id', $produto)
            ->where('ativo', true)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            Interacao::create([
                'produto_id'        => $produtoModel->id,
                'tipo_interacao_id' => $tipoInteracao->id,
                'ip'                => request()->ip(),
                'user_agent'        => request()->userAgent(),
                'criado_em'         => now(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error but still redirect
            logger()->error('Erro ao registrar interação: ' . $e->getMessage());
        }

        // Redirecionar conforme o tipo
        return match ($tipo) {
            'whatsapp' => $this->redirectWhatsApp($produtoModel),
            'instagram' => $this->redirectInstagram(),
            default => $this->redirectWhatsApp($produtoModel),
        };
    }

    private function redirectWhatsApp(Produto $produto): RedirectResponse
    {
        $numero = config('app.whatsapp_number', '5511999999999');
        $mensagem = "Olá! Tenho interesse no produto {$produto->nome}";
        $url = "https://wa.me/{$numero}?text=" . urlencode($mensagem);

        return redirect()->away($url);
    }

    private function redirectInstagram(): RedirectResponse
    {
        $perfil = config('app.instagram_profile', 'https://instagram.com/seuperfil');

        return redirect()->away($perfil);
    }
}