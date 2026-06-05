@props(['type' => 'success', 'message' => '', 'dismissible' => true])

@if($message)
<div class="alert alert-custom alert-{{ $type }} d-flex align-items-center gap-2" role="alert">
    @switch($type)
        @case('success')
            <i class="bi bi-check-circle-fill"></i>
            @break
        @case('danger')
        @case('error')
            <i class="bi bi-exclamation-circle-fill"></i>
            @break
        @case('warning')
            <i class="bi bi-exclamation-triangle-fill"></i>
            @break
        @default
            <i class="bi bi-info-circle-fill"></i>
    @endswitch
    <div class="flex-grow-1">{{ $message }}</div>
    @if($dismissible)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
@endif

{{ $slot ?? '' }}