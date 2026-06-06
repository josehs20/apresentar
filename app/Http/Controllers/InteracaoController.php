<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoSite;
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
        $telefoneRaw = ConfiguracaoSite::get('contato_telefone', '');

        // Remove qualquer caractere não numérico
        $numero = preg_replace('/\D/', '', $telefoneRaw);

        // Garante que tenha no mínimo 10 dígitos (DDD + número)
        if (strlen($numero) < 10) {
            $numero = '5511999999999'; // fallback seguro
        }

        // Se tiver 10 ou 11 dígitos e NÃO começar com 55, adiciona o prefixo do Brasil
        if (strlen($numero) >= 10 && !str_starts_with($numero, '55')) {
            $numero = '55' . $numero;
        }

        // Se for o produto genérico (id=1), usa mensagem de boas-vindas
        // Caso contrário, mensagem personalizada com o nome do produto
        if ($produto->id === 1) {
            $mensagem = "Olá! Gostaria de saber mais sobre os produtos naturais.";
        } else {
            $mensagem = "Olá! Tenho interesse no produto {$produto->nome}.";
        }

        $url = "https://wa.me/{$numero}?text=" . urlencode($mensagem);

        return redirect()->away($url);
    }

    private function redirectInstagram(): RedirectResponse
    {
        $perfil = ConfiguracaoSite::get('instagram_url', 'https://instagram.com/seuperfil');

        return redirect()->away($perfil);
    }
}
