@props([
    'icon' => null,
    'iconBg' => 'bg-primary bg-opacity-10',
    'iconColor' => 'text-primary',
    'label' => '',
    'value' => '0',
    'class' => '',
])

<div class="card card-stat h-100 {{ $class }}">
    <div class="card-body d-flex align-items-center gap-3">
        @if($icon)
        <div class="card-stat-icon {{ $iconBg }} {{ $iconColor }}">
            <i class="bi {{ $icon }}"></i>
        </div>
        @endif
        <div>
            <p class="text-muted mb-0" style="font-size:13px;">{{ $label }}</p>
            <h3 class="fw-bold mb-0" style="font-size:26px;">{{ $value }}</h3>
        </div>
    </div>
</div>