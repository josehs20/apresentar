@extends('layouts.admin')
@section('title', 'Interações')

@section('content')
<div class="page-header">
    <div>
        <h3>Interações</h3>
        <p>Visualize os registros de interações dos usuários.</p>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body p-0">

        <div id="tableInteracoesContainer">
            <table id="tabelaInteracoes" class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Produto</th>
                        <th>IP</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @if($interacoes->count())
                        @foreach($interacoes as $interacao)
                            <tr>
                                <td>#{{ $interacao->id }}</td>

                                <td>
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ $interacao->tipoInteracao?->nome ?? '-' }}
                                    </span>
                                </td>

                                <td>{{ $interacao->produto?->nome ?? '-' }}</td>

                                <td class="text-muted small">
                                    {{ $interacao->ip ?? '-' }}
                                </td>

                                <td>
                                    {{ $interacao->criado_em?->format('d/m/Y H:i:s') ?? '-' }}
                                </td>

                                <td class="text-end">
                                    <button onclick="deletarInteracao({{ $interacao->id }})"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- ⚠️ IMPORTANTE: 6 TDs (SEM colspan) --}}
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>Nenhuma interação</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    {{-- Paginação Laravel --}}
    @if($interacoes->hasPages())
        <div class="card-footer bg-white d-flex justify-content-center">
            {{ $interacoes->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initDataTable();
});

function initDataTable() {
    if ($('#tabelaInteracoes tbody tr').length === 0) return;

    $('#tabelaInteracoes').DataTable({
        order: [],
        destroy: true,
        pageLength: 10,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
        }
    });
}

function deletarInteracao(id) {
    if (!confirm('Tem certeza que deseja excluir esta interação?')) return;

    axios.delete(`/admin/interactions/${id}`)
        .then(response => {
            toastr.success(response.data.message);
            reloadTabela();
        })
        .catch(error => {
            toastr.error(error.response?.data?.message || 'Erro ao excluir.');
        });
}

function reloadTabela() {
    const container = document.getElementById('tableInteracoesContainer');

    const oldTable = container.querySelector('table');
    if (oldTable && $.fn.DataTable.isDataTable(oldTable)) {
        $(oldTable).DataTable().destroy();
    }

    axios.get('{{ route("admin.interactions.index") }}')
        .then(response => {

            const parser = new DOMParser();
            const doc = parser.parseFromString(response.data, 'text/html');

            const newTableWrapper = doc.querySelector('#tableInteracoesContainer');

            if (newTableWrapper) {
                container.innerHTML = newTableWrapper.innerHTML;
                initDataTable();
            }
        });
}
</script>
@endpush