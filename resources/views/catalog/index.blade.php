@extends('layouts.app')

@section('meta_title', 'Catálogo de Produtos - ' . config('app.name'))
@section('meta_description', 'Confira nosso catálogo completo de produtos naturais.')

@section('content')
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Nossos Produtos</p>
            <h1 class="fw-bold" style="font-size:2.5rem;color:var(--dark);">Catálogo</h1>
        </div>

        {{-- Filtros --}}
        @if(isset($categorias) && $categorias->count() > 0)
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-full text-sm fw-medium {{ !request('categoria') ? 'text-white' : '' }}" style="background:{{ !request('categoria') ? 'var(--primary)' : '#fff' }};color:{{ !request('categoria') ? '#fff' : 'var(--dark)' }};border:1px solid rgba(43,43,43,0.1);font-size:13px;transition:all 0.2s;">
                Todos
            </a>
            @foreach($categorias as $cat)
                <a href="{{ route('catalog.index', ['categoria' => $cat->slug]) }}" class="px-4 py-2 rounded-full text-sm fw-medium" style="background:{{ request('categoria') == $cat->slug ? 'var(--primary)' : '#fff' }};color:{{ request('categoria') == $cat->slug ? '#fff' : 'var(--dark)' }};border:1px solid rgba(43,43,43,0.1);font-size:13px;transition:all 0.2s;text-decoration:none;">
                    {{ $cat->nome }}
                </a>
            @endforeach
        </div>
        @endif

        {{-- Grid --}}
        @if($produtos->count() > 0)
        <div class="row g-4">
            @foreach($produtos as $produto)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('catalog.show', $produto->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="card-img-wrapper">
                            @if($produto->caminho_imagem)
                                <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-secondary" style="font-size:40px;opacity:0.3;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h6 class="fw-semibold text-dark mb-1" style="font-size:14px;">{{ $produto->nome }}</h6>
                            @if($produto->categoria)
                                <p class="text-muted mb-1" style="font-size:12px;">{{ $produto->categoria->nome }}</p>
                            @endif
                            @if($produto->preco)
                                <p class="text-secondary-custom fw-bold mb-0" style="font-size:14px;">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($produtos->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $produtos->links('pagination::bootstrap-5') }}
        </div>
        @endif

        @else
        <div class="text-center py-20">
            <i class="bi bi-inbox text-secondary" style="font-size:48px;opacity:0.3;"></i>
            <p class="text-muted mt-3">Nenhum produto encontrado.</p>
        </div>
        @endif
    </div>
</section>
@endsection