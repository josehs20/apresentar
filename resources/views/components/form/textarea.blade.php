@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
    'required' => false,
    'maxlength' => null,
    'help' => '',
    'error' => null,
])

<div class="mb-3">
    @if($label)
    <label for="{{ $name }}" class="form-label form-label-custom">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control form-custom @if($error) is-invalid @endif"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
    >{{ old($name, $value) }}</textarea>

    @if($help)
    <div class="form-text" style="font-size:12px;color:#8a8a8a;">{{ $help }}</div>
    @endif

    @if($error)
    <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>