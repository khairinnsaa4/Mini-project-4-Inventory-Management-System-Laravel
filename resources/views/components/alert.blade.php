@props(['type' => 'info'])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type . ' alert-dismissible fade show small d-flex align-items-center']) }} role="alert">
    <div>
        {{ $slot }}
    </div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
