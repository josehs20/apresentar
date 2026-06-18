<table class="table table-admin" id="tabelaLojas">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Cidade/Estado</th>
            <th>Telefone</th>
            <th>Instagram</th>
            <th>Status</th>
            <th style="width:120px;">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($lojas as $loja)
        <tr>
            <td class="fw-semibold">{{ $loja->nome }}</td>
            <td>{{ $loja->cidade }}/{{ $loja->estado }}</td>
            <td>{{ $loja->telefone ?? '-' }}</td>
            <td>
                @if($loja->instagram)
                    <span class="text-primary-custom">{{ $loja->instagram }}</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                <span class="badge-status {{ $loja->ativo ? 'active' : 'inactive' }}">
                    {{ $loja->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </td>
            <td>
                <button class="btn-icon" title="Editar" onclick="editarLoja({{ $loja->id }})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-icon danger" title="Excluir" onclick="deletarLoja({{ $loja->id }})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">Nenhuma loja vinculada encontrada.</td>
        </tr>
        @endforelse
    </tbody>
</table>