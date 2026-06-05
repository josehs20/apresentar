@props([
    'id' => 'modalDefault',
    'title' => 'Modal',
    'size' => '',
    'centered' => true,
])

<div class="modal fade modal-custom" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{ $size ? 'modal-' . $size : '' }} {{ $centered ? 'modal-dialog-centered' : '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>