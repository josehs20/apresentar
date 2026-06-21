@extends('layouts.admin')

@section('title', 'Configurar Cores')

@section('content')
<div class="page-header">
    <div>
        <h3>Cores do Sistema</h3>
        <p>Personalize as cores da identidade visual do site</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-body p-4">
                <form action="{{ route('admin.configuracoes-cores.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Primary Color --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">Cor Primária</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="primary_color" value="{{ old('primary_color', $config->primary_color) }}" class="form-control form-control-color border-0 shadow-sm" style="width:60px;height:48px;padding:4px;cursor:pointer;">
                                <input type="text" class="form-control form-custom" value="{{ $config->primary_color }}" readonly style="max-width:110px;font-family:monospace;">
                            </div>
                            <small class="text-muted">Cor principal da marca</small>
                        </div>

                        {{-- Secondary Color --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">Cor Secundária</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="secondary_color" value="{{ old('secondary_color', $config->secondary_color) }}" class="form-control form-control-color border-0 shadow-sm" style="width:60px;height:48px;padding:4px;cursor:pointer;">
                                <input type="text" class="form-control form-custom" value="{{ $config->secondary_color }}" readonly style="max-width:110px;font-family:monospace;">
                            </div>
                            <small class="text-muted">Títulos / Institucional</small>
                        </div>

                        {{-- Accent Color --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">Cor de Destaque</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="accent_color" value="{{ old('accent_color', $config->accent_color) }}" class="form-control form-control-color border-0 shadow-sm" style="width:60px;height:48px;padding:4px;cursor:pointer;">
                                <input type="text" class="form-control form-custom" value="{{ $config->accent_color }}" readonly style="max-width:110px;font-family:monospace;">
                            </div>
                            <small class="text-muted">CTAs e destaques</small>
                        </div>

                        {{-- Border Color --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">Cor de Borda</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="border_color" value="{{ old('border_color', $config->border_color) }}" class="form-control form-control-color border-0 shadow-sm" style="width:60px;height:48px;padding:4px;cursor:pointer;">
                                <input type="text" class="form-control form-custom" value="{{ $config->border_color }}" readonly style="max-width:110px;font-family:monospace;">
                            </div>
                            <small class="text-muted">Bordas suaves</small>
                        </div>

                        {{-- Background Color --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">Cor de Fundo</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" name="background_color" value="{{ old('background_color', $config->background_color) }}" class="form-control form-control-color border-0 shadow-sm" style="width:60px;height:48px;padding:4px;cursor:pointer;">
                                <input type="text" class="form-control form-custom" value="{{ $config->background_color }}" readonly style="max-width:110px;font-family:monospace;">
                            </div>
                            <small class="text-muted">Fundo principal do site</small>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label class="form-label-custom mb-3">Preview Visual</label>
                        <div style="background:{{ $config->background_color }}; border:2px solid {{ $config->border_color }}; border-radius:12px; padding:24px;">
                            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                                <span style="background:{{ $config->primary_color }}; color:#fff; padding:6px 16px; border-radius:6px; font-weight:600; font-size:14px;">Primary</span>
                                <span style="background:{{ $config->secondary_color }}; color:#fff; padding:6px 16px; border-radius:6px; font-weight:600; font-size:14px;">Secondary</span>
                                <span style="background:{{ $config->accent_color }}; color:#fff; padding:6px 16px; border-radius:6px; font-weight:600; font-size:14px;">Accent</span>
                                <span style="border:2px solid {{ $config->border_color }}; color:#333; padding:6px 16px; border-radius:6px; font-weight:500; font-size:14px;">Border</span>
                            </div>
                            <p style="color:{{ $config->secondary_color }}; font-size:14px; margin:0;">
                                <strong style="color:{{ $config->primary_color }};">Exemplo:</strong> Texto com a cor primária e secundária aplicadas.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i> Salvar Cores
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-custom ms-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Sobre as Cores</h6>
                <p class="small text-muted mb-0">
                    As cores definidas aqui serão aplicadas automaticamente em todo o site público.
                </p>
                <hr>
                <h6 class="fw-bold mb-3">Cores Padrão</h6>
                <div class="d-flex flex-column gap-2 small">
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:#76877D;border:1px solid #ddd;"></span>
                        <span class="text-muted">#76877D — Primary</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:#96958A;border:1px solid #ddd;"></span>
                        <span class="text-muted">#96958A — Secondary</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:#88B8A9;border:1px solid #ddd;"></span>
                        <span class="text-muted">#88B8A9 — Accent</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:#B2CBAE;border:1px solid #ddd;"></span>
                        <span class="text-muted">#B2CBAE — Border</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="display:inline-block;width:20px;height:20px;border-radius:4px;background:#F8F6F0;border:1px solid #ddd;"></span>
                        <span class="text-muted">#F8F6F0 — Background</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', function() {
            const readOnly = this.closest('.d-flex').querySelector('input[readonly]');
            if (readOnly) {
                readOnly.value = this.value;
            }
        });
    });
</script>
@endpush