<div>
    <table id="tabelaTipos" class="table table-admin mb-0" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Interações</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipos as $tipo)
            <tr>
                <td class="fw-medium">{{ $tipo->nome }}</td>
                <td>{{ $tipo->descricao ?? '-' }}</td>
                <td><span class="badge bg-secondary rounded-pill">{{ $tipo->interacoes_count }}</span></td>
                <td>
                    <span class="badge-status {{ $tipo->ativo ? 'active' : 'inactive' }}">
                        {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button onclick="toggleAtivo({{ $tipo->id }})" class="btn-icon" style="color:#856404;border-color:#856404;" title="Ativar/Desativar">
                            <i class="bi bi-power"></i>
                        </button>
                        <button onclick='editarTipo({{ $tipo->id }}, {{ json_encode($tipo->nome) }}, {{ json_encode($tipo->descricao ?? '') }}, {{ $tipo->ativo ? 'true' : 'false' }})' class="btn-icon" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button onclick="deletarTipo({{ $tipo->id }})" class="btn-icon danger" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>