@extends('layouts.admin')

@section('title', 'Pontos de Venda')

@section('content')
<div class="page-header">
    <div>
        <h3>Pontos de Venda</h3>
        <p>Gerencie os locais onde seus produtos são vendidos</p>
    </div>
    <a href="{{ route('admin.pontos-venda.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i> Novo Ponto
    </a>
</div>

<div class="card-custom">
    <div class="card-body p-0">
        @if($pontos->count() > 0)
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cidade/Estado</th>
                        <th>Telefone</th>
                        <th>WhatsApp</th>
                        <th>Google Maps</th>
                        <th>Coordenadas</th>
                        <th>Ativo</th>
                        <th style="width:120px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pontos as $ponto)
                    <tr>
                        <td class="fw-medium">{{ $ponto->nome }}</td>
                        <td class="text-muted">
                            @if($ponto->cidade || $ponto->estado)
                                {{ $ponto->cidade }}{{ $ponto->cidade && $ponto->estado ? '/' : '' }}{{ $ponto->estado }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $ponto->telefone ?: '—' }}</td>
                        <td>
                            @if($ponto->whatsapp)
                                <a href="{{ $ponto->whatsapp_link }}" target="_blank" class="text-success">
                                    <i class="bi bi-whatsapp"></i> {{ $ponto->whatsapp }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($ponto->latitude && $ponto->longitude)
                                <a href="https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}" target="_blank" class="text-danger small">
                                    <i class="bi bi-google"></i> Ver
                                </a>
                            @elseif($ponto->google_maps_link)
                                <a href="{{ $ponto->google_maps_link }}" target="_blank" class="text-danger small">
                                    <i class="bi bi-google"></i> Ver
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            @if($ponto->latitude && $ponto->longitude)
                                {{ number_format($ponto->latitude, 4) }}, {{ number_format($ponto->longitude, 4) }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($ponto->ativo)
                                <span class="badge badge-status active">Sim</span>
                            @else
                                <span class="badge badge-status inactive">Não</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pontos-venda.edit', $ponto) }}" class="btn-icon" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.pontos-venda.destroy', $ponto) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover {{ $ponto->nome }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-shop" style="font-size:48px;color:#ccc;"></i>
            <p class="mt-3 text-muted">Nenhum ponto de venda cadastrado.</p>
            <a href="{{ route('admin.pontos-venda.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-lg me-1"></i> Cadastrar Primeiro Ponto
            </a>
        </div>
        @endif
    </div>
</div>

@if($pontos->hasPages())
<div class="mt-3">
    {{ $pontos->links() }}
</div>
@endif
@endsection