@extends('layouts.admin')
@section('title', $product->nome)

@section('content')
<div class="page-header">
    <div>
        <h3>{{ $product->nome }}</h3>
        <p>Detalhes do produto.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary-custom">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-custom">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-body text-center p-4">
                @if($product->caminho_imagem)
                    <img src="{{ asset('storage/' . $product->caminho_imagem) }}" alt="{{ $product->nome }}" class="img-fluid rounded-3">
                @else
                    <div class="py-5">
                        <i class="bi bi-image display-3 text-muted"></i>
                        <p class="text-muted mt-2">Sem imagem</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-body p-4">
                <dl class="row mb-0" style="font-size:14px;">
                    <dt class="col-sm-4 text-muted">Categoria</dt>
                    <dd class="col-sm-8">{{ $product->categoria?->nome ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Preço</dt>
                    <dd class="col-sm-8">{{ $product->preco ? 'R$ ' . number_format($product->preco, 2, ',', '.') : '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Descrição</dt>
                    <dd class="col-sm-8">{{ $product->descricao ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Composição</dt>
                    <dd class="col-sm-8">{{ $product->composicao ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Tipo de Pele</dt>
                    <dd class="col-sm-8">{{ $product->tipo_pele ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge-status {{ $product->ativo ? 'active' : 'inactive' }}">
                            {{ $product->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 text-muted">Meta Título</dt>
                    <dd class="col-sm-8 text-truncate">{{ $product->meta_titulo ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Meta Descrição</dt>
                    <dd class="col-sm-8">{{ $product->meta_descricao ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection