@extends('layouts.admin')

@section('title', 'Configurações')

@section('content')

<div class="page-header">
    <div>
        <h3>Configurações do Site</h3>
        <p>Gerencie conteúdos dinâmicos.</p>
    </div>
    <button class="btn btn-primary-custom"
        data-bs-toggle="modal"
        data-bs-target="#modalCreateConfig">
    <i class="bi bi-plus-lg me-1"></i>Nova Configuração
</button>
</div>

@foreach($configs as $grupo => $itens)

<div class="card card-custom mb-4">
    <div class="card-header fw-semibold text-capitalize">
        <i class="bi bi-folder2-open me-2"></i>{{ $grupo }}
    </div>


<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Chave</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th class="text-end">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($itens as $config)
            <tr>
                <td class="fw-semibold">{{ $config->chave }}</td>

                <td class="text-muted">
                    {{ \Illuminate\Support\Str::limit($config->valor, 50) }}
                </td>

                <td>
                    <span class="badge bg-light text-dark">
                        {{ $config->tipo }}
                    </span>
                </td>

                <td class="text-end">
                    <button class="btn btn-sm btn-outline-custom"
                            data-bs-toggle="modal"
                            data-bs-target="#modalConfig{{ $config->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form method="POST"
                          action="{{ route('admin.configuracoes.destroy', $config) }}"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</div>

@endforeach

{{-- MODAIS FORA DA TABLE (IMPORTANTE) --}}
@foreach($configs as $grupo => $itens)
@foreach($itens as $config)


<div class="modal fade" id="modalConfig{{ $config->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
        <div class="modal-content border-0" style="border-radius:16px;overflow:hidden;">

            <form method="POST" action="{{ route('admin.configuracoes.update', $config) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- HEADER -->
                <div class="p-4" style="border-bottom:1px solid rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary-custom mb-1"
                               style="font-size:12px;letter-spacing:0.05em;text-transform:uppercase;">
                                Configuração
                            </p>

                            <h5 class="fw-semibold mb-0" style="color:var(--dark);">
                                {{ $config->chave }}
                            </h5>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>

                <!-- BODY -->
                <div class="p-4">

                    <div class="mb-4">
                        <label class="mb-2 fw-medium" style="font-size:13px;color:var(--dark);">
                            Valor
                        </label>

                        @if($config->tipo === 'imagem')
                            <input type="file" name="imagem" class="form-control"
                                   style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;padding:10px;">
                            <small class="text-muted">Deixe vazio para manter a imagem atual.</small>
                            <input type="hidden" name="valor" value="{{ $config->valor }}">
                        @elseif($config->tipo === 'cor')
                            <div class="d-flex align-items-center gap-3" id="colorPicker{{ $config->id }}">
                                <input type="color" name="valor" value="{{ $config->valor ?? '#76877D' }}"
                                       style="width:60px;height:48px;border-radius:10px;border:1px solid rgba(43,43,43,0.1);padding:2px;cursor:pointer;">
                                <input type="text" value="{{ $config->valor ?? '#76877D' }}"
                                       class="form-control color-hex-text" style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;font-family:monospace;"
                                       placeholder="#76877D" maxlength="7">
                                <script>
                                    (function() {
                                        const container = document.getElementById('colorPicker{{ $config->id }}');
                                        const colorInput = container.querySelector('input[type=color]');
                                        const textInput = container.querySelector('.color-hex-text');
                                        colorInput.addEventListener('input', function() { textInput.value = this.value; });
                                        textInput.addEventListener('input', function() { colorInput.value = this.value; });
                                    })();
                                </script>
                            </div>
                            <small class="text-muted">Selecione uma cor ou digite o código hexadecimal (ex: #76877D).</small>
                        @else
                            <textarea name="valor" class="form-control" rows="4"
                                      style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">{{ $config->valor }}</textarea>
                        @endif
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="mb-2 fw-medium" style="font-size:13px;">
                                Tipo
                            </label>

                            <select name="tipo" class="form-select"
                                    style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                                <option value="texto" @selected($config->tipo=='texto')>Texto</option>
                                <option value="html" @selected($config->tipo=='html')>HTML</option>
                                <option value="imagem" @selected($config->tipo=='imagem')>Imagem</option>
                                <option value="json" @selected($config->tipo=='json')>JSON</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="mb-2 fw-medium" style="font-size:13px;">
                                Grupo
                            </label>

                            <input type="text"
                                   name="grupo"
                                   value="{{ $config->grupo }}"
                                   class="form-control"
                                   style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                        </div>

                    </div>

                    @if($config->tipo === 'imagem' && $config->valor)
                        <div class="mt-4">
                            <p class="mb-2 text-muted" style="font-size:12px;">Preview</p>

                            <img src="{{ $config->imagem_url }}"
                                 style="width:100%;border-radius:12px;object-fit:cover;">
                        </div>
                    @endif

                </div>

                <!-- FOOTER -->
                <div class="p-4 d-flex justify-content-end gap-2"
                     style="border-top:1px solid rgba(0,0,0,0.05);">

                    <button type="button"
                            class="px-4 py-2"
                            data-bs-dismiss="modal"
                            style="border-radius:999px;border:1px solid rgba(0,0,0,0.1);background:#fff;font-size:13px;">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="px-4 py-2 text-white"
                            style="border-radius:999px;background:var(--primary);font-size:13px;border:none;">
                        Salvar
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="modalCreateConfig" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
        <div class="modal-content border-0" style="border-radius:16px;overflow:hidden;">


        <form method="POST" action="{{ route('admin.configuracoes.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- HEADER -->
            <div class="p-4" style="border-bottom:1px solid rgba(0,0,0,0.05);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary-custom mb-1"
                           style="font-size:12px;letter-spacing:0.05em;text-transform:uppercase;">
                            Nova Configuração
                        </p>

                        <h5 class="fw-semibold mb-0" style="color:var(--dark);">
                            Criar Configuração
                        </h5>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-4">

                {{-- CHAVE --}}
                <div class="mb-4">
                    <label class="mb-2 fw-medium" style="font-size:13px;">Chave</label>

                    <input type="text"
                           name="chave"
                           class="form-control"
                           placeholder="Ex: hero.titulo"
                           required
                           style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                </div>

                {{-- VALOR --}}
                <div class="mb-4">
                    <label class="mb-2 fw-medium" style="font-size:13px;">Valor</label>

                    <textarea name="valor"
                              class="form-control"
                              rows="4"
                              style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;"></textarea>
                </div>

                <div class="row g-3">

                    {{-- TIPO --}}
                    <div class="col-md-6">
                        <label class="mb-2 fw-medium" style="font-size:13px;">Tipo</label>

                        <select name="tipo" class="form-select"
                                style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                            <option value="texto">Texto</option>
                            <option value="html">HTML</option>
                            <option value="imagem">Imagem</option>
                            <option value="cor">Cor</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>

                    {{-- GRUPO --}}
                    <div class="col-md-6">
                        <label class="mb-2 fw-medium" style="font-size:13px;">Grupo</label>

                        <input type="text"
                               name="grupo"
                               value="geral"
                               class="form-control"
                               style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                    </div>

                </div>

                {{-- DESCRIÇÃO --}}
                <div class="mt-4">
                    <label class="mb-2 fw-medium" style="font-size:13px;">Descrição</label>

                    <input type="text"
                           name="descricao"
                           class="form-control"
                           placeholder="Ex: Texto principal do hero"
                           style="border-radius:10px;border:1px solid rgba(43,43,43,0.1);font-size:14px;">
                </div>

            </div>

            <!-- FOOTER -->
            <div class="p-4 d-flex justify-content-end gap-2"
                 style="border-top:1px solid rgba(0,0,0,0.05);">

                <button type="button"
                        data-bs-dismiss="modal"
                        class="px-4 py-2"
                        style="border-radius:999px;border:1px solid rgba(0,0,0,0.1);background:#fff;font-size:13px;">
                    Cancelar
                </button>

                <button type="submit"
                        class="px-4 py-2 text-white"
                        style="border-radius:999px;background:var(--primary);font-size:13px;border:none;">
                    Criar
                </button>

            </div>

        </form>

    </div>
</div>


</div>

@endforeach


@endforeach

@endsection
