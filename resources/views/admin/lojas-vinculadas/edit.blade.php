@extends('layouts.admin')
@section('title', 'Editar Loja Vinculada')

@section('content')
<div class="page-header">
    <div>
        <h3>Editar Loja Vinculada</h3>
        <p>Atualize as informações da loja parceira.</p>
    </div>
    <a href="{{ route('admin.lojas-vinculadas.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="card card-custom">
    <div class="card-body">
        <form id="formLojaEdit" method="POST" action="{{ route('admin.lojas-vinculadas.update', $lojaVinculada) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <x-form.input name="nome" label="Nome da Loja" required :value="old('nome', $lojaVinculada->nome)" placeholder="Ex: Espaço Boho Cosméticos" />
                </div>
                <div class="col-md-6">
                    <x-form.input name="telefone" label="Telefone" :value="old('telefone', $lojaVinculada->telefone)" placeholder="(11) 99999-0000" />
                </div>
                <div class="col-12">
                    <x-form.input name="endereco" label="Endereço" required :value="old('endereco', $lojaVinculada->endereco)" placeholder="Rua, número, bairro..." />
                </div>
                <div class="col-md-6">
                    <x-form.input name="cidade" label="Cidade" required :value="old('cidade', $lojaVinculada->cidade)" placeholder="Ex: São Paulo" />
                </div>
                <div class="col-md-3">
                    <x-form.input name="estado" label="Estado (UF)" required maxlength="2" :value="old('estado', $lojaVinculada->estado)" placeholder="SP" />
                </div>
                <div class="col-md-3">
                    <x-form.input name="instagram" label="Instagram" :value="old('instagram', $lojaVinculada->instagram)" placeholder="@loja" />
                </div>
                <div class="col-12">
                    <x-form.input name="link_google_maps" label="Link do Google Maps" :value="old('link_google_maps', $lojaVinculada->link_google_maps)" placeholder="https://maps.google.com/?q=..." />
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" {{ $lojaVinculada->ativo ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo">Loja ativa</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.lojas-vinculadas.index') }}" class="btn btn-outline-custom">Cancelar</a>
                <button type="submit" class="btn btn-primary-custom">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection