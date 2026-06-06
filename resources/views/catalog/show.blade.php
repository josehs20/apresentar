@extends('layouts.app')

@section('meta_title', ($produto->meta_titulo ?? $produto->nome) . ' - ' . config('app.name'))
@section('meta_description', $produto->meta_descricao ?? strip_tags(Str::limit($produto->descricao, 160)))
@section('meta_image', $produto->meta_imagem ?? $produto->imagem_url)

@section('content')
<section style="padding:60px 0 80px;">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="mb-4" style="font-size:13px;">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Catálogo</a>
            <span class="mx-2 text-muted">/</span>
            <span style="color:var(--dark);">{{ $produto->nome }}</span>
        </nav>

        <div class="row g-5">
            {{-- Imagem --}}
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden shadow-sm">
                    @if($produto->caminho_imagem)
                        <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}" class="w-100" style="max-height:500px;object-fit:cover;">
                    @else
                        <div style="aspect-ratio:1;background:var(--light);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image text-secondary" style="font-size:60px;opacity:0.3;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="col-lg-6">
                @if($produto->categoria)
                    <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">{{ $produto->categoria->nome }}</p>
                @endif
                <h1 class="fw-bold mb-3" style="font-size:2rem;color:var(--dark);">{{ $produto->nome }}</h1>

                @if($produto->preco)
                    <p class="fs-3 fw-bold mb-4" style="color:var(--primary);">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                @endif

                @if($produto->descricao)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Descrição</h6>
                    <p class="text-muted" style="line-height:1.8;">{{ $produto->descricao }}</p>
                </div>
                @endif

                @if($produto->composicao)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">Composição</h6>
                    <p class="text-muted" style="line-height:1.8;">{{ $produto->composicao }}</p>
                </div>
                @endif

                @if($produto->tipo_pele)
                <div class="mb-5">
                    <h6 class="fw-semibold mb-2">Tipo de Pele</h6>
                    <span class="px-3 py-1 rounded-pill fw-medium" style="font-size:13px;background:rgba(46,94,78,0.1);color:var(--accent);">{{ $produto->tipo_pele }}</span>
                </div>
                @endif

                {{-- Ações --}}
                <div class="d-flex flex-column flex-sm-row gap-3">
                    @if(isset($whatsappTipoId))
                    <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => $produto->id]) }}" class="btn-whatsapp flex-fill text-center justify-content-center" target="_blank" style="font-size:15px;padding:14px 24px;">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Comprar via WhatsApp
                    </a>
                    @endif

                    @if(isset($instagramTipoId))
                    <a href="{{ route('interacao.redirect', ['tipo' => 'instagram', 'produto' => $produto->id]) }}" class="btn btn-outline-custom flex-fill text-center justify-content-center" target="_blank" style="padding:14px 24px;background:linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045);border:none;color:#fff;">
                        <i class="bi bi-instagram me-1"></i> Ver no Instagram
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection