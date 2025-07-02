@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
        <div id="errorMessage" class="error-message show bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span id="errorText">Email atau password salah. Silakan coba lagi.</span>
                </div>
        </div>
        @endforeach
    </ul>
@endif
