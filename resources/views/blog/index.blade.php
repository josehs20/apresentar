@extends('layouts.app')

@section('meta_title', 'Blog - ' . config('app.name'))
@section('meta_description', 'Fique por dentro das novidades, dicas e conteúdos sobre cuidados com a pele.')

@section('content')
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Conteúdos</p>
            <h1 class="fw-bold" style="font-size:2.5rem;color:var(--dark);">Blog</h1>
        </div>

        @if($posts->count() > 0)
        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
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
                                <p class="text-muted small mb-3" style="line-height:1.6;">{{ \Illuminate\Support\Str::limit($post->resumo, 150) }}</p>
                            @endif
                            <span class="text-secondary-custom small fw-medium">Ler mais →</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($posts->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
        @endif

        @else
        <div class="text-center py-20">
            <i class="bi bi-file-text text-secondary" style="font-size:48px;opacity:0.3;"></i>
            <p class="text-muted mt-3">Nenhuma postagem encontrada.</p>
        </div>
        @endif
    </div>
</section>
@endsection