@extends('layouts.app')

@section('meta_title', config('app.name') . ' - Produtos Naturais')
@section('meta_description', 'Descubra nossa linha completa de produtos naturais para cuidados com a pele e bem-estar.')

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="px-lg-4">
                    <p class="text-secondary-custom fw-semibold mb-3" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">{{ $heroBadge ?? 'Produtos Naturais' }}</p>
                    <h1 class="hero-title mb-4">
                        {!! $heroTitulo ?? 'Cuide da sua pele com <span>natureza</span>' !!}
                    </h1>
                    <p class="hero-subtitle mb-5">
                        {{ $heroSub ?? 'Produtos artesanais feitos com ingredientes selecionados. Descubra uma rotina de cuidados que vai transformar seu dia a dia.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('catalog.index') }}" class="btn-primary-custom">
                            <i class="bi bi-bag me-1"></i>Ver Produtos
                        </a>
                        <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" class="btn-whatsapp" target="_blank">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Falar no WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="rounded-4 overflow-hidden shadow-lg" style="max-width:420px;margin:0 auto;background:linear-gradient(135deg,rgba(46,94,78,0.08),rgba(107,79,58,0.08));padding:40px;">
                    <div style="width:100%;aspect-ratio:3/4;background:linear-gradient(135deg,#d4c5b5,#bfae9e);border-radius:16px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        @if($heroImagem)
                            <img src="{{ asset('storage/' . $heroImagem) }}" alt="{{ $heroBadge ?? 'Hero' }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="bi bi-flower2" style="font-size:80px;color:rgba(46,94,78,0.3);"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRODUTOS EM DESTAQUE --}}
@if(isset($destaques) && $destaques->count() > 0)
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Selecionados para você</p>
            <h2 class="fw-bold" style="font-size:2rem;color:var(--dark);">Produtos em Destaque</h2>
        </div>
        <div class="row g-4">
            @foreach($destaques as $i => $produto)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('catalog.show', $produto->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="card-img-wrapper">

                        @if($produto->caminho_imagem)
                                <img src="{{ asset('storage/' . $produto->caminho_imagem) }}" alt="{{ $produto->nome }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-secondary" style="font-size:48px;opacity:0.3;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h6 class="fw-semibold text-dark mb-1" style="font-size:14px;">{{ $produto->nome }}</h6>
                            @if($produto->preco)
                                <p class="text-secondary-custom fw-bold mb-0" style="font-size:14px;">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            @endif
                            <span class="text-muted small" style="font-size:12px;">Ver detalhes →</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('catalog.index') }}" class="btn-outline-custom">
                Ver todos os produtos <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- SOBRE A MARCA --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden" style="background:linear-gradient(135deg,#d4c5b5,#bfae9e);aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    @if($sobreImagem)
                        <img src="{{ asset('storage/' . $sobreImagem) }}" alt="{{ $sobreBadge ?? 'Sobre' }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <i class="bi bi-leaf" style="font-size:80px;color:rgba(46,94,78,0.3);"></i>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <p class="text-secondary-custom fw-semibold mb-3" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">{{ $sobreBadge ?? 'Nossa História' }}</p>
                <h2 class="fw-bold mb-4" style="font-size:2rem;color:var(--dark);">{{ $sobreTitulo ?? 'Feito com amor e natureza' }}</h2>
                <p class="text-muted mb-4" style="line-height:1.8;font-size:16px;">
                    {{ $sobreDescricao ?? 'Acreditamos que o cuidado com a pele começa com ingredientes que você pode reconhecer. Cada produto é desenvolvido com carinho usando o que a natureza tem de melhor para oferecer.' }}
                </p>
                <div class="d-flex gap-4">
                    <div>
                        <div class="fs-3 fw-bold" style="color:var(--accent);">{{ $sobreStat1Valor ?? '100%' }}</div>
                        <div class="text-muted small">{{ $sobreStat1Titulo ?? 'Natural' }}</div>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold" style="color:var(--accent);">{{ $sobreStat2Valor ?? '10+' }}</div>
                        <div class="text-muted small">{{ $sobreStat2Titulo ?? 'Produtos' }}</div>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold" style="color:var(--accent);">{{ $sobreStat3Valor ?? '500+' }}</div>
                        <div class="text-muted small">{{ $sobreStat3Titulo ?? 'Clientes' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ÚLTIMOS BLOG --}}
@if(isset($ultimosPosts) && $ultimosPosts->count() > 0)
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Dicas e Novidades</p>
            <h2 class="fw-bold" style="font-size:2rem;color:var(--dark);">Últimas do Blog</h2>
        </div>
        <div class="row g-4">
            @foreach($ultimosPosts as $post)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                    <div class="blog-card">
                        @if($post->caminho_imagem)
                        <div class="card-img-wrapper">
                            <img src="{{ asset('storage/' . $post->caminho_imagem) }}" alt="{{ $post->titulo }}">
                        </div>
                        @endif
                        <div class="p-4">
                            <p class="text-muted small mb-2">{{ $post->publicado_em ? $post->publicado_em->format('d/m/Y') : '' }}</p>
                            <h5 class="fw-semibold text-dark mb-2">{{ $post->titulo }}</h5>
                            @if($post->resumo)
                                <p class="text-muted small" style="line-height:1.6;">{{ \Illuminate\Support\Str::limit($post->resumo, 120) }}</p>
                            @endif
                            <span class="text-secondary-custom small fw-medium">Ler mais →</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- PONTOS DE VENDA --}}
@if(isset($pontosVenda) && $pontosVenda->count() > 0)
<section style="padding:80px 0;background:var(--light);">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Onde Encontrar</p>
            <h2 class="fw-bold" style="font-size:2rem;color:var(--dark);">Nossos Pontos de Venda</h2>
            <p class="text-muted" style="max-width:500px;margin:0 auto;">Encontre o ponto mais próximo de você</p>
        </div>
        <div class="row g-4">
            @foreach($pontosVenda as $ponto)
            <div class="col-md-6 col-lg-4">
                <div class="blog-card" style="height:100%;">
                    {{-- Mapa estático --}}
                    <div class="card-img-wrapper" style="aspect-ratio:16/9;position:relative;">
                        @if($ponto->latitude && $ponto->longitude)
                        <iframe
                            width="100%"
                            height="100%"
                            style="border:0;pointer-events:none;"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}&z=15&output=embed">
                        </iframe>
                        <div style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:2;" onclick="window.open('https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}','_blank')"></div>
                        @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,var(--light),#EDE7DE);">
                            <i class="bi bi-shop" style="font-size:48px;color:rgba(46,94,78,0.2);"></i>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h5 class="fw-semibold text-dark mb-2">{{ $ponto->nome }}</h5>
                        @if($ponto->endereco)
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $ponto->endereco }}
                                @if($ponto->cidade || $ponto->estado)
                                    <br><span class="ms-3">{{ $ponto->cidade }}{{ $ponto->cidade && $ponto->estado ? '/' : '' }}{{ $ponto->estado }}</span>
                                @endif
                            </p>
                        @endif
                        @if($ponto->horario_funcionamento)
                            <p class="text-muted small mb-2"><i class="bi bi-clock me-1"></i>{{ $ponto->horario_funcionamento }}</p>
                        @endif
                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            @if($ponto->latitude && $ponto->longitude)
                                <a href="https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#ea4335;color:#fff;font-size:12px;padding:5px 14px;">
                                    <i class="bi bi-google me-1"></i>Abrir no Maps
                                </a>
                            @elseif($ponto->google_maps_link)
                                <a href="{{ $ponto->google_maps_link }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#ea4335;color:#fff;font-size:12px;padding:5px 14px;">
                                    <i class="bi bi-google me-1"></i>Abrir no Maps
                                </a>
                            @endif
                            @if($ponto->whatsapp)
                                <a href="{{ $ponto->whatsapp_link }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#25D366;color:#fff;font-size:12px;padding:5px 14px;">
                                    <i class="bi bi-whatsapp me-1"></i>WhatsApp
                                </a>
                            @endif
                      
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('pontos-venda') }}" class="btn-outline-custom">
                Ver todos os pontos <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif
{{-- CONTATO --}}
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Fale Conosco</p>
            <h2 class="fw-bold" style="font-size:2rem;color:var(--dark);">Entre em Contato</h2>
        </div>
        <div class="row justify-content-center g-4">
            @if($contatoTelefone)
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4" style="background:linear-gradient(135deg,rgba(46,94,78,0.06),rgba(107,79,58,0.06));">
                    <div class="mb-3" style="width:56px;height:56px;margin:0 auto;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-whatsapp text-white" style="font-size:24px;"></i>
                    </div>
                    <h5 class="fw-semibold mb-2" style="color:var(--dark);">Telefone / WhatsApp</h5>
                    <p class="text-muted mb-0">{{ $contatoTelefone }}</p>
                </div>
            </div>
            @endif
            @if($contatoEmail)
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4" style="background:linear-gradient(135deg,rgba(46,94,78,0.06),rgba(107,79,58,0.06));">
                    <div class="mb-3" style="width:56px;height:56px;margin:0 auto;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-envelope text-white" style="font-size:24px;"></i>
                    </div>
                    <h5 class="fw-semibold mb-2" style="color:var(--dark);">E-mail</h5>
                    <p class="text-muted mb-0">{{ $contatoEmail }}</p>
                </div>
            </div>
            @endif
            @if($contatoEndereco)
            <div class="col-md-4">
                <div class="text-center p-4 rounded-4" style="background:linear-gradient(135deg,rgba(46,94,78,0.06),rgba(107,79,58,0.06));">
                    <div class="mb-3" style="width:56px;height:56px;margin:0 auto;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-geo-alt text-white" style="font-size:24px;"></i>
                    </div>
                    <h5 class="fw-semibold mb-2" style="color:var(--dark);">Endereço</h5>
                    <p class="text-muted mb-0">{{ $contatoEndereco }}</p>
                </div>
            </div>
            @endif
            @if($instagramUrl)
            <div class="col-md-4">
                <a href="{{ route('interacao.redirect', ['tipo' => 'instagram', 'produto' => 1]) }}" target="_blank" class="text-decoration-none">
                    <div class="text-center p-4 rounded-4" style="background:linear-gradient(135deg,rgba(46,94,78,0.06),rgba(107,79,58,0.06));">
                        <div class="mb-3" style="width:56px;height:56px;margin:0 auto;background:linear-gradient(135deg,#833ab4,#fd1d1d);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-instagram text-white" style="font-size:24px;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2" style="color:var(--dark);">Instagram</h5>
                        <p class="text-muted mb-0">@terra.mar.artesanal</p>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container text-center">
        <h2 class="fw-bold text-white mb-3" style="font-size:2rem;">Pronto para cuidar de você?</h2>
        <p class="text-white-50 mb-5" style="font-size:16px;max-width:500px;margin:0 auto;">
            Fale conosco pelo WhatsApp e descubra o produto ideal para sua pele.
        </p>
        <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" class="btn-whatsapp" target="_blank" style="font-size:16px;padding:16px 36px;">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Falar no WhatsApp
        </a>
    </div>
</section>

@endsection