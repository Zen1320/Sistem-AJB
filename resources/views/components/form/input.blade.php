@props([
    'label',
    'name',
    'type' => 'text',
    'icon' => null,
    'required' => false,
    'value' => old($name),
])

<div>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <div class="input-group">
        @isset($prepend)
            <span class="input-group-text">{{ $prepend }}</span>
        @endisset
        
        @if($icon && !isset($prepend))
            <span class="input-group-text">
                <i class="fas fa-{{ $icon }}"></i>
            </span>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        >

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
