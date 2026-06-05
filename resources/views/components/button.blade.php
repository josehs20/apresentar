@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => '',
    'href' => null,
    'icon' => null,
    'class' => '',
])

@php
$base = match($variant) {
    'primary' => 'btn-primary-custom',
    'outline' => 'btn-outline-custom',
    'danger' => 'btn-danger-custom',
    'icon' => 'btn-icon',
    default => 'btn-primary-custom',
};
$sizeClass = match($size) {
    'sm' => 'btn-sm',
    'lg' => 'btn-lg',
    default => '',
};
$classes = trim("{$base} {$sizeClass} {$class}");
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" @if($type === 'button') role="button" @endif>
        @if($icon)<i class="bi {{ $icon }} me-1"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}">
        @if($icon)<i class="bi {{ $icon }} me-1"></i>@endif
        {{ $slot }}
    </button>
@endif