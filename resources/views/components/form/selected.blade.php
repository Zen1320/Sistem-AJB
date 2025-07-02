@props([
    'name',
    'label',
    'icon' => null,
    'required' => false,
    'value' => null,
])

@php
    $selectedValue = old($name, $value);
@endphp

<div class="mb-3">
    <label class="form-label">
        @if($icon)
            <i class="fas fa-{{ $icon }} me-1"></i>
        @endif
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select
        name="{{ $name }}"
        class="form-select @error($name) is-invalid @enderror"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.querySelector('select[name="{{ $name }}"]');
        if (select && "{{ $selectedValue }}" !== "") {
            [...select.options].forEach(option => {
                if (option.value == "{{ $selectedValue }}") {
                    option.selected = true;
                }
            });
        }
    });
</script>
@endpush
