<div>
    <table id="tabelaProdutos" class="table table-admin mb-0" style="width:100%">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>
                   
                    @if($produto->caminho_imagem)
                        <img src="{{ Storage::disk('public')->url($produto->caminho_imagem) }}" alt="{{ $produto->nome }}" width="40" height="40" style="object-fit:cover;border-radius:6px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:6px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td><a href="{{ route('admin.products.show', $produto) }}" class="text-decoration-none fw-medium">{{ $produto->nome }}</a></td>
                <td>{{ $produto->categoria?->nome ?? '-' }}</td>
                <td class="text-nowrap">{{ $produto->preco ? 'R$ ' . number_format($produto->preco, 2, ',', '.') : '-' }}</td>
                <td><span class="badge-status {{ $produto->ativo ? 'active' : 'inactive' }}">{{ $produto->ativo ? 'Ativo' : 'Inativo' }}</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.products.edit', $produto) }}" class="btn-icon" title="Editar"><i class="bi bi-pencil"></i></a>
                        <button onclick="deletarProduto({{ $produto->id }})" class="btn-icon danger" title="Excluir"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>