@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div>
        <h3>Dashboard</h3>
        <p>Visão geral das métricas da loja.</p>
    </div>
</div>

{{-- Metric Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
<x-card
    icon="bi-arrow-up-circle"
    iconBg="bg-primary bg-opacity-10"
    iconColor="text-primary"
    label="Total de Interações"
    value="{{ $cards[0]['value'] ?? 0 }}"
/>
    </div>
    <div class="col-md-4">
        <x-card
            icon="bi-whatsapp"
            iconBg="bg-success bg-opacity-10"
            iconColor="text-success"
            label="Cliques WhatsApp"
            value="{{ $cards[1]['value'] ?? 0 }}"
        />
    </div>
    <div class="col-md-4">
        <x-card
            icon="bi-instagram"
            iconBg="bg-danger bg-opacity-10"
            iconColor="text-danger"
            label="Cliques Instagram"
            value="{{ $cards[2]['value'] ?? 0 }}"
        />
    </div>
</div>

<div class="row g-4">
    {{-- Gráfico (placeholder) --}}
    <div class="col-md-7">
        <div class="card card-custom h-100">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Interações por Dia (últimos 30 dias)
            </div>
            <div class="card-body">
                <div class="chart-placeholder">
                    <div class="text-center">
                        <i class="bi bi-bar-chart-line" style="font-size:36px;display:block;margin-bottom:12px;"></i>
                        Gráfico de Interações
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ranking --}}
    <div class="col-md-5">
        <div class="card card-custom h-100">
            <div class="card-header">
                <i class="bi bi-trophy me-2"></i>Produtos Mais Clicados
            </div>
            <div class="card-body p-0">
                <x-table
                    :headers="['Produto', 'Interações']"
                    :rows="$produtosMaisClicados ?? []"
                    empty="Nenhuma interação registrada."
                >
                    @forelse($produtosMaisClicados ?? [] as $item)
                    <tr>
                        <td class="fw-medium">{{ $item['nome'] }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $item['total'] }}</span>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>
</div>

{{-- Rankings por Tipo --}}
<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header" style="border-left: 4px solid #25D366;">
                <i class="bi bi-whatsapp me-2" style="color:#25D366;"></i>WhatsApp
            </div>
            <div class="card-body p-0">
                <x-table
                    :headers="['Produto', 'Cliques']"
                    :rows="$produtosWhatsApp ?? []"
                    empty="Nenhum clique WhatsApp."
                >
                    @forelse($produtosWhatsApp ?? [] as $item)
                    <tr>
                        <td class="fw-medium">{{ $item['nome'] }}</td>
                        <td><span class="badge bg-success rounded-pill">{{ $item['total'] }}</span></td>
                    </tr>
                    @empty
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header" style="border-left: 4px solid #E4405F;">
                <i class="bi bi-instagram me-2" style="color:#E4405F;"></i>Instagram
            </div>
            <div class="card-body p-0">
                <x-table
                    :headers="['Produto', 'Cliques']"
                    :rows="$produtosInstagram ?? []"
                    empty="Nenhum clique Instagram."
                >
                    @forelse($produtosInstagram ?? [] as $item)
                    <tr>
                        <td class="fw-medium">{{ $item['nome'] }}</td>
                        <td><span class="badge bg-danger rounded-pill">{{ $item['total'] }}</span></td>
                    </tr>
                    @empty
                    @endforelse
                </x-table>
            </div>
        </div>
    </div>
</div>
@endsection