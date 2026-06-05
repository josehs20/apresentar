@props(['type' => 'success', 'message' => ''])

<div x-data="{ show: @js($message ? true : false) }"
     x-show="show"
     x-init="
        if (show) {
            setTimeout(() => show = false, 5000);
        }
     "
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     role="alert"
     class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center">
    <span x-text="message">{{ $message }}</span>
    <button type="button" class="btn-close ms-auto" @click="show = false" aria-label="Close"></button>
</div>