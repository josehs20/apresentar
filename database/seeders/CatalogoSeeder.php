<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Postagem;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Popula o catálogo inicial: 3 categorias, 10 produtos e 3 postagens.
 *
 * Baixa imagens reais do Unsplash para simular uma vitrine artesanal.
 * É idempotente: cada item é identificado por slug e atualizado (ou criado).
 */
class CatalogoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategorias();
        $this->seedProdutos();
        $this->seedPostagens();
    }

    /**
     * Garante que o diretório de imagens temporárias existe.
     */
    protected function ensureDir(string $dir): void
    {
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
    }

    /**
     * Baixa uma imagem do Unsplash e salva no disco public.
     * Retorna o caminho relativo para salvar no banco.
     */
    protected function downloadImage(string $url, string $filename): ?string
    {
        $this->ensureDir('produtos');
        $this->ensureDir('postagens');

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 15,
                    'user_agent' => 'Mozilla/5.0 (compatible; Laravel Seeder)',
                ],
            ]);

            $imageContent = @file_get_contents($url, false, $context);

            if ($imageContent === false) {
                $this->command?->warn("Não foi possível baixar: {$url}");
                return null;
            }

            // Detectar extensão pelo tipo MIME
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageContent);
            $ext = match ($mimeType) {
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
                default      => 'jpg',
            };

            $path = 'produtos/' . $filename;
            Storage::disk('public')->put($path, $imageContent);

            return $path;
        } catch (\Exception $e) {
            $this->command?->warn("Erro ao baixar imagem: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Baixa imagem para postagens.
     */
    protected function downloadBlogImage(string $url, string $filename): ?string
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 15,
                    'user_agent' => 'Mozilla/5.0 (compatible; Laravel Seeder)',
                ],
            ]);

            $imageContent = @file_get_contents($url, false, $context);

            if ($imageContent === false) {
                $this->command?->warn("Não foi possível baixar: {$url}");
                return null;
            }

            $this->ensureDir('postagens');
            $path = 'postagens/' . $filename;
            Storage::disk('public')->put($path, $imageContent);

            return $path;
        } catch (\Exception $e) {
            $this->command?->warn("Erro ao baixar imagem de blog: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Cria/atualiza 3 categorias base.
     */
    protected function seedCategorias(): void
    {
        $categorias = [
            [
                'nome'      => 'Skincare Facial',
                'slug'      => 'skincare-facial',
                'descricao' => 'Cuidados diários para o rosto: limpeza, hidratação e proteção.',
            ],
            [
                'nome'      => 'Corpo e Banho',
                'slug'      => 'corpo-e-banho',
                'descricao' => 'Sabonetes, esfoliantes, hidratantes e óleos para o corpo.',
            ],
            [
                'nome'      => 'Cabelos',
                'slug'      => 'cabelos',
                'descricao' => 'Shampoos, condicionadores e tratamentos capilares naturais.',
            ],
        ];

        foreach ($categorias as $data) {
            Categoria::query()->updateOrCreate(
                ['slug' => $data['slug']],
                $data,
            );
        }

        $this->command?->info('CatalogoSeeder: ' . count($categorias) . ' categorias garantidas.');
    }

    /**
     * Cria 10 produtos com imagens reais do Unsplash.
     */
    protected function seedProdutos(): void
    {
        // Imagens do Unsplash para cada produto (temática artesanal/natural)
        // Imagens reais do Unsplash (temática artesanal/natural — Terra Mar Artesanal)
        $imageUrls = [
            'hidratante-facial-de-aloe-vera'       => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&h=800&fit=crop',
            'serum-vitamina-c-natural'             => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&h=800&fit=crop',
            'gel-de-limpeza-profunda'              => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&h=800&fit=crop',
            'protetor-solar-mineral-fps-50'        => 'https://images.unsplash.com/photo-1571781926292-c747ce11563f?w=800&h=800&fit=crop',
            'sabonete-liquido-de-calendula'        => 'https://images.unsplash.com/photo-1600857544200-b2f666a9a2ec?w=800&h=800&fit=crop',
            'esfoliante-corporal-de-cafe'          => 'https://images.unsplash.com/photo-1567721913486-6585f069b332?w=800&h=800&fit=crop',
            'oleo-hidratante-de-coco'              => 'https://images.unsplash.com/photo-1526947425960-945c6e72858f?w=800&h=800&fit=crop',
            'shampoo-solido-de-argila'             => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=800&h=800&fit=crop',
            'mascara-capilar-de-abacate'           => 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?w=800&h=800&fit=crop',
            'tonico-antiqueda-natural'             => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&h=800&fit=crop',
        ];

        $produtos = [
            // Skincare Facial
            [
                'categoria' => 'skincare-facial',
                'nome'      => 'Hidratante Facial de Aloe Vera',
                'preco'     => 79.90,
                'tipo_pele' => 'sensível',
                'slug'      => 'hidratante-facial-de-aloe-vera',
            ],
            [
                'categoria' => 'skincare-facial',
                'nome'      => 'Sérum Vitamina C Natural',
                'preco'     => 119.90,
                'tipo_pele' => 'mista',
                'slug'      => 'serum-vitamina-c-natural',
            ],
            [
                'categoria' => 'skincare-facial',
                'nome'      => 'Gel de Limpeza Profunda',
                'preco'     => 49.90,
                'tipo_pele' => 'oleosa',
                'slug'      => 'gel-de-limpeza-profunda',
            ],
            [
                'categoria' => 'skincare-facial',
                'nome'      => 'Protetor Solar Mineral FPS 50',
                'preco'     => 139.90,
                'tipo_pele' => 'todas',
                'slug'      => 'protetor-solar-mineral-fps-50',
            ],

            // Corpo e Banho
            [
                'categoria' => 'corpo-e-banho',
                'nome'      => 'Sabonete Líquido de Calêndula',
                'preco'     => 39.90,
                'tipo_pele' => 'sensível',
                'slug'      => 'sabonete-liquido-de-calendula',
            ],
            [
                'categoria' => 'corpo-e-banho',
                'nome'      => 'Esfoliante Corporal de Café',
                'preco'     => 59.90,
                'tipo_pele' => 'normal',
                'slug'      => 'esfoliante-corporal-de-cafe',
            ],
            [
                'categoria' => 'corpo-e-banho',
                'nome'      => 'Óleo Hidratante de Coco',
                'preco'     => 69.90,
                'tipo_pele' => 'seca',
                'slug'      => 'oleo-hidratante-de-coco',
            ],

            // Cabelos
            [
                'categoria' => 'cabelos',
                'nome'      => 'Shampoo Sólido de Argila',
                'preco'     => 54.90,
                'tipo_pele' => 'normal',
                'slug'      => 'shampoo-solido-de-argila',
            ],
            [
                'categoria' => 'cabelos',
                'nome'      => 'Máscara Capilar de Abacate',
                'preco'     => 89.90,
                'tipo_pele' => 'seca',
                'slug'      => 'mascara-capilar-de-abacate',
            ],
            [
                'categoria' => 'cabelos',
                'nome'      => 'Tônico Antiqueda Natural',
                'preco'     => 99.90,
                'tipo_pele' => 'mista',
                'slug'      => 'tonico-antiqueda-natural',
            ],
        ];

        $categorias = Categoria::query()
            ->whereIn('slug', collect($produtos)->pluck('categoria')->unique())
            ->get()
            ->keyBy('slug');

        $count = 0;
        foreach ($produtos as $p) {
            $categoria = $categorias->get($p['categoria']);
            if (!$categoria) {
                continue;
            }

            $descricao = sprintf(
                'O %s é formulado com ingredientes 100%% naturais, livres de parabenos, sulfatos e fragrâncias sintéticas. Ideal para quem busca uma rotina de beleza mais consciente e saudável.',
                $p['nome']
            );

            $composicao = sprintf(
                'Ingredientes: %s, %s, %s, %s e %s. Sem testes em animais.',
                'Manteiga de karité',
                'Óleo essencial de lavanda',
                'Vitamina E',
                'Extrato de calêndula',
                'Aloe Vera'
            );

            // Baixar imagem do Unsplash
            $imagemPath = null;
            $filename = $p['slug'] . '.jpg';
            if (isset($imageUrls[$p['slug']])) {
                $imagemPath = $this->downloadImage($imageUrls[$p['slug']], $filename);
            }
            $finalPath = $imagemPath ?? 'produtos/' . $filename;

            Produto::query()->updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'categoria_id'   => $categoria->id,
                    'nome'           => $p['nome'],
                    'slug'           => $p['slug'],
                    'descricao'      => $descricao,
                    'composicao'     => $composicao,
                    'preco'          => $p['preco'],
                    'caminho_imagem' => $finalPath,
                    'ativo'          => true,
                    'tipo_pele'      => $p['tipo_pele'],
                    'meta_titulo'    => $p['nome'] . ' | Cosméticos Naturais',
                    'meta_descricao' => $descricao,
                    'meta_imagem'    => $finalPath,
                ],
            );
            $count++;
        }

        $this->command?->info("CatalogoSeeder: {$count} produtos garantidos com imagens reais.");
    }

    /**
     * Cria 3 postagens (artigos do blog) com imagens reais.
     */
    protected function seedPostagens(): void
    {
        // Imagens do Unsplash para postagens do blog
        $blogImages = [
            'dicas-skincare-natural'       => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=1200&h=600&fit=crop',
            'beneficios-cosmeticos-naturais' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=1200&h=600&fit=crop',
            'spa-day-em-casa'              => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=1200&h=600&fit=crop',
        ];

        $postagens = [
            [
                'titulo'      => '5 Dicas Para uma Rotina de Skincare Natural',
                'resumo'      => 'Descubra como montar uma rotina de cuidados com a pele usando apenas ingredientes naturais e sustentáveis.',
                'conteudo'    => 'Ter uma rotina de skincare natural é mais simples do que parece. '
                    . "Neste post, listamos 5 dicas práticas para você começar hoje mesmo.\n\n"
                    . "**1. Conheça o seu tipo de pele**\n"
                    . "Antes de tudo, descubra se a sua pele é oleosa, seca, mista ou sensível. Isso vai guiar todas as suas escolhas de produto.\n\n"
                    . "**2. Limpeza suave**\n"
                    . "Use um gel de limpeza suave, sem sulfatos. Produtos artesanais com calêndula ou camomila são ótimas opções.\n\n"
                    . "**3. Hidratação**\n"
                    . "Um bom hidratante natural faz toda a diferença. Procure por ingredientes como aloe vera, manteiga de karité e óleo de coco.\n\n"
                    . "**4. Proteção solar**\n"
                    . "Use protetor solar mineral todos os dias, mesmo em dias nublados. Sua pele agradece.\n\n"
                    . "**5. Considere o seu estilo de vida**\n"
                    . "Alimentação, sono e estresse também impactam diretamente na saúde da sua pele.",
                'caminho_imagem' => 'postagens/dicas-skincare-natural.jpg',
                'publicado_em'  => now()->subDays(7),
            ],
            [
                'titulo'      => 'Benefícios dos Cosméticos Naturais Para a Sua Pele',
                'resumo'      => 'Entenda por que os cosméticos naturais podem ser uma escolha mais saudável e sustentável para a sua pele.',
                'conteudo'    => 'Os cosméticos naturais são livres de ingredientes sintéticos agressivos, como parabenos, sulfatos e fragrâncias artificiais. '
                    . "Eles utilizam extratos de plantas, óleos essenciais e manteigas vegetais que nutrem a pele de forma suave e eficazes.\n\n"
                    . "Além de cuidar da saúde da pele, esse tipo de produto também respeita o meio ambiente e os animais.\n\n"
                    . "**Ingredientes que fazem a diferença**\n"
                    . "Aloe vera, calêndula, camomila, óleo de coco e manteiga de karité são alguns dos ingredientes mais usados e eficazes.\n\n"
                    . "**Como identificar um cosmético realmente natural**\n"
                    . "Procure por selos de certificação e leia atentamente a lista de ingredientes. Menos ingredientes geralmente significa mais qualidade.",
                'caminho_imagem' => 'postagens/beneficios-cosmeticos-naturais.jpg',
                'publicado_em'  => now()->subDays(15),
            ],
            [
                'titulo'      => 'Como Montar um Spa Day em Casa com Produtos Naturais',
                'resumo'      => 'Transforme a sua casa em um spa relaxante e cuide do corpo e da mente usando apenas ingredientes naturais.',
                'conteudo'    => 'Um spa day em casa é uma excelente maneira de relaxar e cuidar de si. '
                    . "Com produtos naturais, você ainda garante que a sua pele recebe apenas ingredientes saudáveis.\n\n"
                    . "**Preparando o ambiente**\n"
                    . "Acenda velas aromáticas, coloque uma música suave e prepare uma toalha limpa.\n\n"
                    . "**Banho relaxante**\n"
                    . "Use sais de banho e óleos essenciais de lavanda ou eucalipto para um banho aromático.\n\n"
                    . "**Hidratação profunda**\n"
                    . "Aplique uma máscara facial natural e um hidratante corporal com manteiga de karité.\n\n"
                    . "**Finalize com chá**\n"
                    . "Um chá de camomila ou erva-cidreira ajuda a prolongar a sensação de bem-estar depois do spa.",
                'caminho_imagem' => 'postagens/spa-day-em-casa.jpg',
                'publicado_em'  => now()->subDays(30),
            ],
        ];

        $count = 0;
        foreach ($postagens as $p) {
            $slug = Str::slug($p['titulo']);

            // Baixar imagem do blog do Unsplash
            $imagemPath = null;
            if (isset($blogImages[$slug])) {
                $imagemPath = $this->downloadBlogImage($blogImages[$slug], $slug . '.jpg');
            }

            Postagem::query()->updateOrCreate(
                ['slug' => $slug],
                array_merge($p, [
                    'slug'           => $slug,
                    'caminho_imagem' => $imagemPath ?? $p['caminho_imagem'],
                    'meta_titulo'    => $p['titulo'],
                    'meta_descricao' => $p['resumo'],
                    'meta_imagem'    => $imagemPath ?? 'seo/' . $slug . '.jpg',
                ]),
            );
            $count++;
        }

        $this->command?->info("CatalogoSeeder: {$count} postagens garantidas com imagens reais.");
    }
}