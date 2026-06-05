@extends('layouts.admin')
@section('title', $post->titulo)

@section('content')
<div class="page-header">
    <div>
        <h3>{{ $post->titulo }}</h3>
        <p>Visualizar postagem.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary-custom">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        @if($post->caminho_imagem)
            <img src="{{ asset('storage/' . $post->caminho_imagem) }}" alt="{{ $post->titulo }}" class="img-fluid rounded-3 mb-4" style="max-height: 300px;object-fit:cover;">
        @endif

        @if($post->publicado_em)
            <p class="text-muted mb-3" style="font-size:13px;">
                <i class="bi bi-calendar me-1"></i>{{ $post->publicado_em->format('d/m/Y') }}
            </p>
        @endif

        @if($post->resumo)
            <blockquote class="text-muted italic border-start border-3 ps-4 mb-4" style="border-color:var(--secondary)!important;">
                {{ $post->resumo }}
            </blockquote>
        @endif

        <div style="line-height:1.8;">
            {!! nl2br(e($post->conteudo)) !!}
        </div>
    </div>
</div>
@endsection