@props([
    'label',
    'name',
    'icon' => null,
    'rows' => 4,
    'required' => false,

])

<div>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <div class="input-group">
        @if($icon)
            <span class="input-group-text">
                <i class="fas fa-{{ $icon }}"></i>
            </span>
        @endif
        
        @php
            $textValue = old($name, $attributes->get('value'));
        @endphp

        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        >{{ $textValue }}</textarea>
    </div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
