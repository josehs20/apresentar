@extends('layouts.admin')
@section('title', 'Lojas Vinculadas')

@section('content')
<div class="page-header">
    <div>
        <h3>Lojas Vinculadas</h3>
        <p>Gerencie as lojas parceiras que revendem seus produtos.</p>
    </div>
    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalLoja">
        <i class="bi bi-plus-lg me-1"></i>Nova Loja
    </button>
</div>

<div class="card card-custom">
    <div class="card-body p-0">
        <div id="tableLojasContainer">
            @include('admin.lojas-vinculadas.table', ['lojas' => $lojas])
        </div>
    </div>
</div>

{{-- Modal --}}
<x-modal id="modalLoja" title="Nova Loja Vinculada" size="lg">
    <form id="formLoja" method="POST">
        @csrf
        <input type="hidden" name="loja_id" id="lojaId">
        <input type="hidden" name="_method" value="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <x-form.input name="nome" label="Nome da Loja" required placeholder="Ex: Espaço Boho Cosméticos" />
            </div>
            <div class="col-md-6">
                <x-form.input name="telefone" label="Telefone" placeholder="(11) 99999-0000" />
            </div>
            <div class="col-12">
                <x-form.input name="endereco" label="Endereço" required placeholder="Rua, número, bairro..." />
            </div>
            <div class="col-md-6">
                <x-form.input name="cidade" label="Cidade" required placeholder="Ex: São Paulo" />
            </div>
            <div class="col-md-3">
                <x-form.input name="estado" label="Estado (UF)" required maxlength="2" placeholder="SP" />
            </div>
            <div class="col-md-3">
                <x-form.input name="instagram" label="Instagram" placeholder="@loja" />
            </div>
            <div class="col-12">
                <x-form.input name="link_google_maps" label="Link do Google Maps" placeholder="https://maps.google.com/?q=..." />
            </div>
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" value="1" checked>
                    <label class="form-check-label" for="ativo">Loja ativa</label>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary-custom">Salvar</button>
        </div>
    </form>
</x-modal>
@endsection

@push('scripts')
<script>
    const modalLoja = new bootstrap.Modal(document.getElementById('modalLoja'));

    // Init DataTable
    $(document).ready(function() { $('#tabelaLojas').DataTable({ order: [] }); });

    const lojaStoreUrl = '{{ route("admin.lojas-vinculadas.store") }}';
    const lojaTableUrl = '{{ route("admin.lojas-vinculadas.table") }}';

    // Carregar dados da loja para edição
    function editarLoja(id) {
        axios.get(`/admin/lojas-vinculadas/${id}`)
            .then(response => {
                const loja = response.data.data;
                document.getElementById('lojaId').value = loja.id;
                document.getElementById('nome').value = loja.nome;
                document.getElementById('endereco').value = loja.endereco;
                document.getElementById('cidade').value = loja.cidade;
                document.getElementById('estado').value = loja.estado;
                document.getElementById('telefone').value = loja.telefone || '';
                document.getElementById('instagram').value = loja.instagram || '';
                document.getElementById('link_google_maps').value = loja.link_google_maps || '';
                document.getElementById('ativo').checked = loja.ativo;
                document.querySelector('#formLoja input[name="_method"]').value = 'PUT';
                document.querySelector('#modalLoja .modal-title').textContent = 'Editar Loja Vinculada';
                document.getElementById('formLoja').action = `/admin/lojas-vinculadas/${id}`;
                modalLoja.show();
            })
            .catch(error => toastr.error('Erro ao carregar dados da loja.'));
    }

    document.getElementById('formLoja').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        // Garantir que o checkbox envie valor correto
        if (!document.getElementById('ativo').checked) {
            formData.set('ativo', '0');
        }
        const url = this.action;
        const method = this.querySelector('input[name="_method"]')?.value || 'POST';

        axios.post(url, formData, { headers: { 'X-HTTP-Method-Override': method } })
            .then(response => {
                toastr.success(response.data.message || 'Loja salva com sucesso!');
                modalLoja.hide();
                reloadTable('tableLojasContainer', lojaTableUrl, 'tabelaLojas');
            })
            .catch(error => {
                if (error.response?.data?.errors) {
                    Object.values(error.response.data.errors).flat().forEach(msg => toastr.error(msg));
                } else {
                    toastr.error(error.response?.data?.message || 'Erro ao salvar.');
                }
            });
    });

    function deletarLoja(id) {
        if (!confirm('Tem certeza que deseja excluir esta loja vinculada?')) return;
        axios.delete(`/admin/lojas-vinculadas/${id}`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tableLojasContainer', lojaTableUrl, 'tabelaLojas');
            })
            .catch(error => toastr.error(error.response?.data?.message || 'Erro ao excluir.'));
    }

    // Reset do modal ao abrir para nova loja
    document.querySelector('[data-bs-target="#modalLoja"]').addEventListener('click', function() {
        document.getElementById('formLoja').reset();
        document.getElementById('lojaId').value = '';
        document.querySelector('#formLoja input[name="_method"]').value = 'POST';
        document.querySelector('#modalLoja .modal-title').textContent = 'Nova Loja Vinculada';
        document.getElementById('formLoja').action = lojaStoreUrl;
        document.getElementById('ativo').checked = true;
    });
</script>
@endpush