<div>
    <table id="tabelaCategorias" class="table table-admin mb-0" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Produtos</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr>
                <td class="fw-medium">{{ $categoria->nome }}</td>
                <td>{{ $categoria->descricao ?? '-' }}</td>
                <td><span class="badge bg-secondary rounded-pill">{{ $categoria->produtos_count }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <button onclick='editarCategoria({{ $categoria->id }}, {{ json_encode($categoria->nome) }}, {{ json_encode($categoria->descricao ?? '') }})' class="btn-icon" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button onclick="deletarCategoria({{ $categoria->id }})" class="btn-icon danger" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>