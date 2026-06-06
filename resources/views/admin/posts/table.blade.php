<div>
    <table id="tabelaPosts" class="table table-admin mb-0" style="width:100%">
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Título</th>
                <th>Publicado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postagens as $postagem)
            <tr>
                <td>
                    @if($postagem->caminho_imagem)
                        <img src="{{ $postagem->imagem_url }}" alt="{{ $postagem->titulo }}" width="40" height="40" style="object-fit:cover;border-radius:6px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:6px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td><a href="{{ route('admin.posts.show', $postagem) }}" class="text-decoration-none fw-medium">{{ $postagem->titulo }}</a></td>
                <td class="text-nowrap">{{ $postagem->publicado_em ? $postagem->publicado_em->format('d/m/Y') : '-' }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.posts.edit', $postagem) }}" class="btn-icon" title="Editar"><i class="bi bi-pencil"></i></a>
                        <button onclick="deletarPost({{ $postagem->id }})" class="btn-icon danger" title="Excluir"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>