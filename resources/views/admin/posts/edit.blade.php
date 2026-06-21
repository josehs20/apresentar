@extends('layouts.admin')
@section('title', 'Editar Postagem')

@section('content')
<div class="page-header">
    <div>
        <h3>Editar Postagem</h3>
        <p>Altere a postagem "{{ $post->titulo }}".</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-8">
                    <x-form.input name="titulo" label="Título" required value="{{ $post->titulo }}" />
                </div>
                <div class="col-md-4">
                    <x-form.input name="publicado_em" label="Data de Publicação" type="date" value="{{ $post->publicado_em ? $post->publicado_em->format('Y-m-d') : '' }}" />
                </div>
            </div>

            <x-form.textarea name="resumo" label="Resumo" rows="2" value="{{ $post->resumo }}" />

            <x-form.textarea name="conteudo" label="Conteúdo" rows="10" required value="{{ $post->conteudo }}" />

            <hr class="my-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-image me-2"></i>Imagem</h6>
            <div class="row g-4 align-items-end">
                <div class="col-md-6">
                    <label class="form-label form-label-custom">Alterar Imagem</label>
                    <input type="file" name="imagem" class="form-control form-custom" accept="image/*">
                    <div class="form-text" style="font-size:12px;color:#8a8a8a;">Máx. 2MB. Será processada assincronamente.</div>
                </div>
                @if($post->caminho_imagem)
                <div class="col-md-2">
                    <img src="{{ $post->imagem_url }}" alt="Preview" class="img-thumbnail" style="border-radius:8px;max-height:80px;">
                </div>
                @endif
            </div>

            <hr class="my-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-search-heart me-2"></i>SEO</h6>
            <div class="row g-4">
                <div class="col-md-4">
                    <x-form.input name="meta_titulo" label="Meta Título" maxlength="70" value="{{ $post->meta_titulo }}" />
                </div>
                <div class="col-md-4">
                    <x-form.textarea name="meta_descricao" label="Meta Descrição" rows="2" maxlength="160" value="{{ $post->meta_descricao }}" />
                </div>
                <div class="col-md-4">
                    <!-- <x-form.input name="meta_imagem" label="Meta Imagem (URL)" value="{{ $post->meta_imagem }}" /> -->
                </div>
            </div>

            <div class="mt-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-lg me-1"></i>Atualizar Postagem
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection