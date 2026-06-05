@extends('layouts.admin')
@section('title', 'Categorias')

@section('content')
<div class="page-header">
    <div>
        <h3>Categorias</h3>
        <p>Organize os produtos por categorias.</p>
    </div>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalCategoria">
        <i class="bi bi-plus-lg me-1"></i>Nova Categoria
    </button>
</div>

<div class="card card-custom">
    <div class="card-body p-0">
        <div id="tableCategoriasContainer">
            @include('admin.categories.table', ['categorias' => $categorias])
        </div>
    </div>
</div>

{{-- Modal --}}
<x-modal id="modalCategoria" title="Nova Categoria" size="md">
    <form id="formCategoria" method="POST">
        @csrf
        <input type="hidden" name="categoria_id" id="categoriaId">
        <input type="hidden" name="_method" value="POST">
        <x-form.input name="nome" label="Nome" required placeholder="Ex: Hidratantes" />
        <x-form.textarea name="descricao" label="Descrição" rows="3" placeholder="Descrição da categoria..." />
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary-custom">Salvar</button>
        </div>
    </form>
</x-modal>
@endsection

@push('scripts')
<script>
    const modalCategoria = new bootstrap.Modal(document.getElementById('modalCategoria'));

    // Init DataTable
    $(document).ready(function() { $('#tabelaCategorias').DataTable({ order: [] }); });

    function editarCategoria(id, nome, descricao) {
        document.getElementById('categoriaId').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.querySelector('#formCategoria input[name="_method"]').value = 'PUT';
        document.querySelector('#modalCategoria .modal-title').textContent = 'Editar Categoria';
        document.getElementById('formCategoria').action = `/admin/categories/${id}`;
        modalCategoria.show();
    }

    document.getElementById('formCategoria').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const url = this.action;
        const method = this.querySelector('input[name="_method"]')?.value || 'POST';

        axios.post(url, formData, { headers: { 'X-HTTP-Method-Override': method } })
            .then(response => {
                toastr.success(response.data.message || 'Categoria salva com sucesso!');
                modalCategoria.hide();
                reloadTable('tableCategoriasContainer', '{{ route("admin.categories.table") }}', 'tabelaCategorias');
            })
            .catch(error => {
                if (error.response?.data?.errors) {
                    Object.values(error.response.data.errors).flat().forEach(msg => toastr.error(msg));
                } else {
                    toastr.error(error.response?.data?.message || 'Erro ao salvar.');
                }
            });
    });

    function deletarCategoria(id) {
        if (!confirm('Tem certeza que deseja excluir esta categoria?')) return;
        axios.delete(`/admin/categories/${id}`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tableCategoriasContainer', '{{ route("admin.categories.table") }}', 'tabelaCategorias');
            })
            .catch(error => toastr.error(error.response?.data?.message || 'Erro ao excluir.'));
    }

    document.querySelector('[data-bs-target="#modalCategoria"]').addEventListener('click', function() {
        document.getElementById('formCategoria').reset();
        document.getElementById('categoriaId').value = '';
        document.querySelector('#formCategoria input[name="_method"]').value = 'POST';
        document.querySelector('#modalCategoria .modal-title').textContent = 'Nova Categoria';
        document.getElementById('formCategoria').action = '{{ route("admin.categories.store") }}';
    });
</script>
@endpush