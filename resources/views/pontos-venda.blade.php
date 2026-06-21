@extends('layouts.app')

@section('meta_title', 'Onde Encontrar - ' . config('app.name'))
@section('meta_description', 'Encontre nossos produtos nos pontos de venda mais próximos de você.')

@section('content')
<section style="padding:80px 0;">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-secondary-custom fw-semibold mb-2" style="font-size:13px;letter-spacing:0.05em;text-transform:uppercase;">Onde Encontrar</p>
            <h1 class="fw-bold" style="font-size:2.5rem;color:var(--dark);">Nossos Pontos de Venda</h1>
            <p class="text-muted" style="max-width:500px;margin:0 auto;">Confira os locais onde você encontra nossos produtos</p>
        </div>

        @if($pontos->count() > 0)
        <div class="row g-4">
            {{-- Mapa --}}
            <div class="col-lg-7">
                <div class="rounded-4 overflow-hidden shadow-sm" style="height:500px;">
                    <div id="map" style="width:100%;height:100%;"></div>
                </div>
            </div>

            {{-- Lista --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3" style="max-height:500px;overflow-y:auto;">
                    @foreach($pontos as $ponto)
                    <div class="card border-0 shadow-sm rounded-3 p-4 ponto-card" data-lat="{{ $ponto->latitude }}" data-lng="{{ $ponto->longitude }}" data-nome="{{ $ponto->nome }}" data-endereco="{{ $ponto->endereco }}" data-whatsapp="{{ $ponto->whatsapp_link }}" data-telefone="{{ $ponto->telefone }}" data-horario="{{ $ponto->horario_funcionamento }}" style="cursor:pointer;transition:all 0.2s;">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-shop text-white" style="font-size:20px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1" style="color:var(--dark);">{{ $ponto->nome }}</h6>
                                @if($ponto->endereco)
                                    <p class="small text-muted mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $ponto->endereco }}</p>
                                @endif
                                @if($ponto->cidade || $ponto->estado)
                                    <p class="small text-muted mb-1">{{ $ponto->cidade }}{{ $ponto->cidade && $ponto->estado ? '/' : '' }}{{ $ponto->estado }}</p>
                                @endif
                                @if($ponto->horario_funcionamento)
                                    <p class="small text-muted mb-1"><i class="bi bi-clock me-1"></i>{{ $ponto->horario_funcionamento }}</p>
                                @endif
                                <div class="d-flex gap-2 mt-2 flex-wrap">
                                    @if($ponto->latitude && $ponto->longitude)
                                        <a href="https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#ea4335;color:#fff;font-size:12px;padding:4px 12px;">
                                            <i class="bi bi-google"></i> Google Maps
                                        </a>
                                    @elseif($ponto->google_maps_link)
                                        <a href="{{ $ponto->google_maps_link }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#ea4335;color:#fff;font-size:12px;padding:4px 12px;">
                                            <i class="bi bi-google"></i> Google Maps
                                        </a>
                                    @endif
                                    @if($ponto->whatsapp)
                                        <a href="{{ $ponto->whatsapp_link }}" target="_blank" class="btn btn-sm rounded-pill" style="background:#25D366;color:#fff;font-size:12px;padding:4px 12px;">
                                            <i class="bi bi-whatsapp"></i> WhatsApp
                                        </a>
                                    @endif
                                    @if($ponto->telefone)
                                        <span class="btn btn-sm rounded-pill" style="background:var(--light);color:var(--dark);font-size:12px;padding:4px 12px;">
                                            <i class="bi bi-telephone"></i> {{ $ponto->telefone }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-shop" style="font-size:64px;color:#ccc;"></i>
            <h4 class="mt-4 text-muted">Nenhum ponto de venda cadastrado ainda</h4>
            <p class="text-muted">Em breve estaremos disponíveis em mais locais!</p>
        </div>
        @endif
    </div>
</section>
@endsection

@if($pontos->count() > 0)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-popup-content h6 { margin-bottom:4px; font-weight:700; }
    .leaflet-popup-content p { margin-bottom:4px; font-size:13px; }
    .ponto-card:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(43,43,43,0.1)!important; }
    .ponto-card.active { border-left:4px solid var(--accent); }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pontos = @json($pontos);

        if (document.getElementById('map') && pontos.length > 0) {
            // Center map on first point or Brazil
            const center = [pontos[0].latitude || -14.235, pontos[0].longitude || -51.9253];
            const map = L.map('map').setView(center, 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18,
            }).addTo(map);

            const markers = [];
            const bounds = [];

            pontos.forEach(function(ponto, index) {
                if (!ponto.latitude || !ponto.longitude) return;

                const latlng = [ponto.latitude, ponto.longitude];
                bounds.push(latlng);

                const marker = L.marker(latlng).addTo(map);

                const popupContent = `
                    <div style="min-width:200px;">
                        <h6 style="color:var(--primary);">${ponto.nome}</h6>
                        ${ponto.endereco ? `<p><i class="bi bi-geo-alt"></i> ${ponto.endereco}</p>` : ''}
                        ${ponto.horario_funcionamento ? `<p><i class="bi bi-clock"></i> ${ponto.horario_funcionamento}</p>` : ''}
                        ${ponto.whatsapp_link ? `<p><a href="${ponto.whatsapp_link}" target="_blank" style="color:#25D366;font-weight:600;"><i class="bi bi-whatsapp"></i> WhatsApp</a></p>` : ''}
                        ${ponto.telefone ? `<p><i class="bi bi-telephone"></i> ${ponto.telefone}</p>` : ''}
                    </div>
                `;

                marker.bindPopup(popupContent);
                markers.push(marker);

                // Click on card -> open popup and center map
                const card = document.querySelectorAll('.ponto-card')[index];
                if (card) {
                    card.addEventListener('click', function() {
                        document.querySelectorAll('.ponto-card').forEach(c => c.classList.remove('active'));
                        this.classList.add('active');
                        map.setView(latlng, 15);
                        marker.openPopup();
                    });
                }
            });

            // Fit bounds if we have coordinates
            if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [40, 40] });
            } else if (bounds.length === 1) {
                map.setView(bounds[0], 13);
            }
        }
    });
</script>
@endpush
@endif