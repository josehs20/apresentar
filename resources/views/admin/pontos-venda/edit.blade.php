@extends('layouts.admin')

@section('title', 'Editar Ponto de Venda')

@section('content')
<div class="page-header">
    <div>
        <h3>Editar: {{ $pontoVenda->nome }}</h3>
        <p>Atualize as informações do ponto de venda</p>
    </div>
    <a href="{{ route('admin.pontos-venda.index') }}" class="btn btn-outline-custom">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-body p-4">
                <form action="{{ route('admin.pontos-venda.update', $pontoVenda) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-custom">Nome *</label>
                            <input type="text" name="nome" value="{{ old('nome', $pontoVenda->nome) }}" class="form-control form-custom @error('nome') is-invalid @enderror" required>
                            @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-custom">Endereço</label>
                            <textarea name="endereco" rows="2" class="form-control form-custom @error('endereco') is-invalid @enderror">{{ old('endereco', $pontoVenda->endereco) }}</textarea>
                            @error('endereco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Cidade</label>
                            <input type="text" name="cidade" value="{{ old('cidade', $pontoVenda->cidade) }}" class="form-control form-custom">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Estado</label>
                            <input type="text" name="estado" value="{{ old('estado', $pontoVenda->estado) }}" class="form-control form-custom" maxlength="2" placeholder="SP">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Telefone</label>
                            <input type="text" name="telefone" value="{{ old('telefone', $pontoVenda->telefone) }}" class="form-control form-custom" placeholder="(11) 99999-9999">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $pontoVenda->whatsapp) }}" class="form-control form-custom" placeholder="(11) 99999-9999">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Latitude</label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $pontoVenda->latitude) }}" class="form-control form-custom" placeholder="-23.5505" step="any" oninput="atualizarMapa()">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Longitude</label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $pontoVenda->longitude) }}" class="form-control form-custom" placeholder="-46.6333" step="any" oninput="atualizarMapa()">
                        </div>

                        <div class="col-12">
                            <label class="form-label-custom">Link do Google Maps</label>
                            <input type="text" name="google_maps_link" value="{{ old('google_maps_link', $pontoVenda->google_maps_link) }}" class="form-control form-custom" placeholder="https://maps.app.goo.gl/...">
                            <small class="text-muted">Cole o link de compartilhamento do Google Maps (opcional)</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label-custom">Horário de Funcionamento</label>
                            <textarea name="horario_funcionamento" rows="2" class="form-control form-custom" placeholder="Seg-Sex: 8h-18h, Sáb: 9h-13h">{{ old('horario_funcionamento', $pontoVenda->horario_funcionamento) }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="ativo" value="1" class="form-check-input" id="ativo" {{ old('ativo', $pontoVenda->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">Ativo</label>
                            </div>
                        </div>

                        {{-- Preview Mapa --}}
                        <div class="col-12" id="previewMapaWrapper" style="{{ $pontoVenda->latitude && $pontoVenda->longitude ? 'display:block;' : 'display:none;' }}">
                            <label class="form-label-custom">Preview do Mapa</label>
                            <div style="height:300px;border-radius:8px;overflow:hidden;">
                                <iframe id="previewMapa" width="100%" height="100%" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    src="{{ $pontoVenda->latitude && $pontoVenda->longitude ? 'https://www.google.com/maps?q=' . $pontoVenda->latitude . ',' . $pontoVenda->longitude . '&z=15&output=embed' : '' }}">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i> Atualizar Ponto
                        </button>
                        <a href="{{ route('admin.pontos-venda.index') }}" class="btn btn-outline-custom ms-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-body p-4">
                @if($pontoVenda->latitude && $pontoVenda->longitude)
                <h6 class="fw-bold mb-3"><i class="bi bi-map me-2"></i>Localização Atual</h6>
                <div style="height:200px;border-radius:8px;overflow:hidden;">
                    <iframe
                        width="100%"
                        height="100%"
                        style="border:0;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ $pontoVenda->latitude }},{{ $pontoVenda->longitude }}&z=15&output=embed">
                    </iframe>
                </div>
                <p class="small text-muted mt-2 mb-0">
                    {{ number_format($pontoVenda->latitude, 4) }}, {{ number_format($pontoVenda->longitude, 4) }}
                </p>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-geo-alt" style="font-size:40px;color:#ccc;"></i>
                    <p class="small text-muted mt-2 mb-0">Adicione coordenadas para ver o mapa.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function atualizarMapa() {
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;
    const wrapper = document.getElementById('previewMapaWrapper');
    const iframe = document.getElementById('previewMapa');

    if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
        iframe.src = `https://www.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
        wrapper.style.display = 'block';
    } else {
        wrapper.style.display = 'none';
    }
}
</script>
@endpush
