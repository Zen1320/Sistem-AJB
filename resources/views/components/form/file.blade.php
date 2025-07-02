@props([
    'label',
    'name',
    'icon' => null,
    'required' => false,
    'filePath' => null,
])

<div class="mb-3 col-md-6">
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="input-group">
        @if($icon)
            <span class="input-group-text">
                <i class="fas fa-{{ $icon }}"></i>
            </span>
        @endif

        <input
            type="file"
            class="form-control @error($name) is-invalid @enderror"
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
        >
    </div>

    {{-- Tampilkan file lama jika ada --}}
    @if($filePath)
        <small class="text-muted d-block mt-1">
            <i class="fas fa-link"></i>
            File saat ini: {{$filePath}}
        </small>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
