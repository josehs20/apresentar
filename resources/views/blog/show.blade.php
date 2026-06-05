@extends('layouts.app')

@section('meta_title', ($post->meta_titulo ?? $post->titulo) . ' - ' . config('app.name'))
@section('meta_description', $post->meta_descricao ?? strip_tags(Str::limit($post->resumo ?? $post->conteudo, 160)))
@section('meta_image', $post->meta_imagem ?? ($post->caminho_imagem ? asset('storage/' . $post->caminho_imagem) : ''))

@section('content')
<article style="padding:60px 0 80px;">
    <div class="container" style="max-width:720px;">
        {{-- Breadcrumb --}}
        <nav class="mb-4" style="font-size:13px;">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Blog</a>
            <span class="mx-2 text-muted">/</span>
            <span style="color:var(--dark);">{{ $post->titulo }}</span>
        </nav>

        @if($post->caminho_imagem)
        <div class="rounded-4 overflow-hidden mb-5">
            <img src="{{ asset('storage/' . $post->caminho_imagem) }}" alt="{{ $post->titulo }}" class="w-100" style="max-height:400px;object-fit:cover;">
        </div>
        @endif

        @if($post->publicado_em)
        <p class="text-muted mb-2" style="font-size:13px;">{{ $post->publicado_em->format('d \d\e F \d\e Y') }}</p>
        @endif

        <h1 class="fw-bold mb-4" style="font-size:2rem;color:var(--dark);line-height:1.3;">{{ $post->titulo }}</h1>

        @if($post->resumo)
        <div class="mb-4 py-3 px-4 rounded-3" style="border-left:4px solid var(--secondary);background:rgba(166,124,82,0.06);">
            <p class="text-muted mb-0" style="font-style:italic;line-height:1.7;">{{ $post->resumo }}</p>
        </div>
        @endif

        <div style="line-height:1.85;color:#555;">
            {!! nl2br(e($post->conteudo)) !!}
        </div>

        <div class="mt-8 pt-6 border-top">
            <a href="{{ route('blog.index') }}" class="text-decoration-none fw-medium" style="color:var(--primary);">
                <i class="bi bi-arrow-left me-2"></i>Voltar para o Blog
            </a>
        </div>
    </div>
</article>
@endsection