@extends('layouts.admin')
@section('title', 'Tipos de Interação')

@section('content')
<div class="page-header">
    <div>
        <h3>Tipos de Interação</h3>
        <p>Gerencie os tipos de interação disponíveis (WhatsApp, Instagram, etc).</p>
    </div>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTipo">
        <i class="bi bi-plus-lg me-1"></i>Novo Tipo
    </button>
</div>

<div class="card card-custom">
    <div class="card-body p-0">
        <div id="tableTiposContainer">
            @include('admin.tipos-interacao.table', ['tipos' => $tipos])
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade modal-custom" id="modalTipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formTipo" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="tipo_id" id="tipoId">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="modalTitle">Novo Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <x-form.input name="nome" label="Nome" required maxlength="50" placeholder="Ex: facebook" />
                    <x-form.textarea name="descricao" label="Descrição" rows="2" maxlength="255" placeholder="Descrição do tipo..." />
                    <div class="form-check mt-2">
                        <input type="checkbox" name="ativo" class="form-check-input" value="1" id="inputAtivo" checked>
                        <label class="form-check-label" for="inputAtivo" style="font-size:14px;">Ativo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modalTipo = new bootstrap.Modal(document.getElementById('modalTipo'));
    $(document).ready(function() { $('#tabelaTipos').DataTable({ order: [] }); });

    function editarTipo(id, nome, descricao, ativo) {
        document.getElementById('tipoId').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('inputAtivo').checked = ativo === true || ativo === 'true' || ativo === 1;
        document.querySelector('#formTipo input[name="_method"]').value = 'PUT';
        document.querySelector('#modalTipo .modal-title').textContent = 'Editar Tipo';
        document.getElementById('formTipo').action = `/admin/tipos-interacao/${id}`;
        modalTipo.show();
    }

    document.getElementById('formTipo').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const url = this.action;
        const method = this.querySelector('input[name="_method"]')?.value || 'POST';

        axios.post(url, formData, { headers: { 'X-HTTP-Method-Override': method } })
            .then(response => {
                toastr.success(response.data.message || 'Salvo com sucesso!');
                modalTipo.hide();
                reloadTable('tableTiposContainer', '{{ route("admin.tipos-interacao.table") }}', 'tabelaTipos');
            })
            .catch(error => {
                if (error.response?.data?.errors) {
                    Object.values(error.response.data.errors).flat().forEach(msg => toastr.error(msg));
                } else {
                    toastr.error(error.response?.data?.message || 'Erro ao salvar.');
                }
            });
    });

    function deletarTipo(id) {
        if (!confirm('Tem certeza que deseja excluir?')) return;
        axios.delete(`/admin/tipos-interacao/${id}`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tableTiposContainer', '{{ route("admin.tipos-interacao.table") }}', 'tabelaTipos');
            })
            .catch(error => toastr.error(error.response?.data?.message || 'Erro ao excluir.'));
    }

    function toggleAtivo(id) {
        axios.patch(`/admin/tipos-interacao/${id}/toggle-ativo`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tableTiposContainer', '{{ route("admin.tipos-interacao.table") }}', 'tabelaTipos');
            })
            .catch(error => toastr.error('Erro ao alterar status.'));
    }

    document.querySelector('[data-bs-target="#modalTipo"]').addEventListener('click', function() {
        document.getElementById('formTipo').reset();
        document.getElementById('tipoId').value = '';
        document.querySelector('#formTipo input[name="_method"]').value = 'POST';
        document.querySelector('#modalTipo .modal-title').textContent = 'Novo Tipo';
        document.getElementById('formTipo').action = '{{ route("admin.tipos-interacao.store") }}';
    });
</script>
@endpush