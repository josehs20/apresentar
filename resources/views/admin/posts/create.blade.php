@extends('layouts.admin')
@section('title', 'Nova Postagem')

@section('content')
<div class="page-header">
    <div>
        <h3>Nova Postagem</h3>
        <p>Adicione uma nova postagem ao blog.</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-8">
                    <x-form.input name="titulo" label="Título" required placeholder="Título da postagem..." />
                </div>
                <div class="col-md-4">
                    <x-form.input name="publicado_em" label="Data de Publicação" type="date" />
                </div>
            </div>

            <x-form.textarea name="resumo" label="Resumo" rows="2" placeholder="Breve resumo da postagem..." />

            <x-form.textarea name="conteudo" label="Conteúdo" rows="10" placeholder="Escreva o conteúdo aqui..." required />

            <hr class="my-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-image me-2"></i>Imagem</h6>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label form-label-custom">Upload de Imagem</label>
                    <input type="file" name="imagem" class="form-control form-custom" accept="image/*">
                    <div class="form-text" style="font-size:12px;color:#8a8a8a;">Máx. 2MB. Será processada assincronamente.</div>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-search-heart me-2"></i>SEO</h6>
            <div class="row g-4">
                <div class="col-md-4">
                    <x-form.input name="meta_titulo" label="Meta Título" maxlength="70" placeholder="Título para SEO" />
                </div>
                <div class="col-md-4">
                    <x-form.textarea name="meta_descricao" label="Meta Descrição" rows="2" maxlength="160" placeholder="Descrição para SEO" />
                </div>
                <div class="col-md-4">
                    <!-- <x-form.input name="meta_imagem" label="Meta Imagem (URL)" placeholder="https://..." /> -->
                </div>
            </div>

            <div class="mt-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-lg me-1"></i>Salvar Postagem
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection