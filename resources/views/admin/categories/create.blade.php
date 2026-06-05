@extends('layouts.admin')
@section('title', 'Nova Categoria')

@section('content')
<div class="page-header">
    <div>
        <h3>Nova Categoria</h3>
        <p>Adicione uma nova categoria de produtos.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <x-form.input name="nome" label="Nome" required placeholder="Ex: Hidratantes" />
            <x-form.textarea name="descricao" label="Descrição" rows="3" placeholder="Descrição da categoria..." />

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">Salvar</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection