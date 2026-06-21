<?php

namespace Database\Seeders;

use App\Models\ConfiguracaoSite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ConfiguracaoSiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->garantirImagens();

        $configuracoes = [
            // Hero
            ['chave' => 'hero_imagem',     'valor' => 'site/hero.jpg',  'tipo' => 'imagem', 'grupo' => 'hero', 'descricao' => 'Imagem do Hero (3:4 portrait)'],
            ['chave' => 'hero_titulo',     'valor' => 'Cuide da sua pele com <span>natureza</span>', 'tipo' => 'texto', 'grupo' => 'hero'],
            ['chave' => 'hero_subtitulo',  'valor' => 'Produtos artesanais feitos com ingredientes selecionados. Descubra uma rotina de cuidados que vai transformar seu dia a dia.', 'tipo' => 'texto', 'grupo' => 'hero'],
            ['chave' => 'hero_badge',      'valor' => 'Produtos Naturais', 'tipo' => 'texto', 'grupo' => 'hero'],

            // Sobre
            ['chave' => 'sobre_imagem',       'valor' => 'site/sobre.jpg', 'tipo' => 'imagem', 'grupo' => 'sobre'],
            ['chave' => 'sobre_badge',        'valor' => 'Nossa História', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_titulo',       'valor' => 'Feito com amor e natureza', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_descricao',    'valor' => 'Acreditamos que o cuidado com a pele começa com ingredientes que você pode reconhecer. Cada produto é desenvolvido com carinho usando o que a natureza tem de melhor para oferecer.', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_1_titulo','valor' => 'Natural', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_1_valor', 'valor' => '100%', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_2_titulo','valor' => 'Produtos', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_2_valor', 'valor' => '10+', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_3_titulo','valor' => 'Clientes', 'tipo' => 'texto', 'grupo' => 'sobre'],
            ['chave' => 'sobre_stat_3_valor', 'valor' => '500+', 'tipo' => 'texto', 'grupo' => 'sobre'],

            // Contato
            ['chave' => 'contato_telefone', 'valor' => '(XX) XXXXX-XXXX', 'tipo' => 'texto', 'grupo' => 'contato'],
            ['chave' => 'contato_email',    'valor' => 'contato@tierramar.com.br', 'tipo' => 'texto', 'grupo' => 'contato'],
            ['chave' => 'contato_endereco', 'valor' => 'Sua cidade, Brasil', 'tipo' => 'texto', 'grupo' => 'contato'],

            // Redes Sociais
            ['chave' => 'instagram_url',    'valor' => 'https://www.instagram.com/terra.mar.artesanal?igsh=eXl2dnA3ZG1uenA3', 'tipo' => 'texto', 'grupo' => 'redes_sociais'],
        ];

        foreach ($configuracoes as $config) {
            ConfiguracaoSite::updateOrCreate(
                ['chave' => $config['chave']],
                $config
            );
        }

        $this->command?->info('ConfiguracoesSiteSeeder: ' . count($configuracoes) . ' configurações garantidas.');
    }

    /**
     * Baixa imagens reais com fallback (igual CatalogoSeeder)
     */
    private function garantirImagens(): void
    {
        $images = [
            'hero.jpg' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=600&h=800&fit=crop',
            'sobre.jpg' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=800&h=600&fit=crop',
        ];

        foreach ($images as $file => $url) {
            $path = $this->downloadSiteImage($url, $file);

            // fallback caso falhe download
            if (!$path) {
                $this->generatePlaceholder($file);
            }
        }
    }

    /**
     * Download da imagem (padrão CatalogoSeeder)
     */
    protected function downloadSiteImage(string $url, string $filename): ?string
    {
        $this->ensureDir('site');

        $path = 'site/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 8,
                    'user_agent' => 'Mozilla/5.0 (Laravel Seeder)',
                ],
            ]);

            $content = @file_get_contents($url, false, $context);

            if ($content !== false) {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->buffer($content);

                if (str_starts_with($mime, 'image/')) {
                    Storage::disk('public')->put($path, $content);

                    // 🔥 correção de permissão
                    @chmod(Storage::disk('public')->path($path), 0644);

                    return $path;
                }
            }
        } catch (\Exception $e) {
            $this->command?->warn("Erro ao baixar {$filename}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fallback SVG (igual seu padrão antigo, mas com permissão correta)
     */
    private function generatePlaceholder(string $filename): void
    {
        $this->ensureDir('site');

        $path = 'site/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            return;
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600">'
            . '<rect width="100%" height="100%" fill="#d4c5b5"/>'
            . '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"'
            . ' font-size="60" fill="#2e5e4e" opacity="0.3">🌿</text>'
            . '</svg>';

        Storage::disk('public')->put($path, $svg);

        @chmod(Storage::disk('public')->path($path), 0644);

        $this->command?->warn("Placeholder gerado: {$path}");
    }

    /**
     * Garante diretório com permissão correta
     */
    private function ensureDir(string $dir): void
    {
        $disk = Storage::disk('public');

        if (!$disk->exists($dir)) {
            $disk->makeDirectory($dir);

            @chmod($disk->path($dir), 0755);
        }
    }
}