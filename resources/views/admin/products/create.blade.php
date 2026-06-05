@extends('layouts.admin')
@section('title', 'Novo Produto')

@section('content')
<div class="page-header">
    <div>
        <h3>Novo Produto</h3>
        <p>Adicione um novo produto ao catálogo.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <x-form.input name="nome" label="Nome do Produto" required placeholder="Ex: Sabonete Natural" />
                </div>
                <div class="col-md-3">
                    <label class="form-label form-label-custom">
                        Categoria <span class="text-danger">*</span>
                    </label>
                    <select name="categoria_id" class="form-select form-custom" required>
                        <option value="">Selecione...</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <x-form.input name="preco" id="preco" label="Preço" type="text" placeholder="0,00" />
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <x-form.textarea name="descricao" label="Descrição" rows="4" placeholder="Descrição do produto..." />
                </div>
                <div class="col-md-3">
                    <x-form.textarea name="composicao" label="Composição" rows="4" placeholder="Ingredientes..." />
                </div>
                <div class="col-md-3">
                    <x-form.input name="tipo_pele" label="Tipo de Pele" placeholder="Ex: Oleosa, Seca..." />
                    <div class="form-check mt-3">
                        <input type="checkbox" name="ativo" class="form-check-input" value="1" id="ativoProduto" checked>
                        <label class="form-check-label" for="ativoProduto" style="font-size:14px;">Produto Ativo</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-semibold mb-3"><i class="bi bi-image me-2"></i>Imagem do Produto</h6>
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
                    <x-form.input name="meta_imagem" label="Meta Imagem (URL)" placeholder="https://..." />
                </div>
            </div>

            <div class="mt-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-check-lg me-1"></i>Salvar Produto
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('preco');

    input.addEventListener('input', function (e) {
        let value = e.target.value;

        // remove tudo que não é número
        value = value.replace(/\D/g, '');

        // transforma em centavos
        value = (value / 100).toFixed(2);

        // formata para padrão BR
        value = value
            .replace('.', ',')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        e.target.value = value;
    });
});
</script>
@endsection