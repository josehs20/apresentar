@extends('layouts.admin')
@section('title', 'Editar Categoria')

@section('content')
<div class="page-header">
    <div>
        <h3>Editar Categoria</h3>
        <p>Altere as informações da categoria.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body p-5">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            <x-form.input name="nome" label="Nome" required value="{{ $category->nome }}" />
            <x-form.textarea name="descricao" label="Descrição" rows="3" value="{{ $category->descricao }}" />

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">Atualizar</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-custom">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection