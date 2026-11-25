@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => 'off',
])

<div class="flex flex-col gap-1.5">
    <label for="{{ $name }}" class="text-sm font-semibold text-slate-700">{{ $label }}</label>
    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
            @if ($type === 'name')
                <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                </svg>
            @elseif ($type === 'email')
                <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6.75h16v10.5H4z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                    <path d="m5 7.5 7 5.25 7-5.25" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            @elseif ($type === 'password')
                <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.7" />
                    <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                </svg>
            @endif
        </span>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $autocomplete }}"
            {{ $attributes->merge(['class' => 'block w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-11 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10']) }}
        >
        @if ($type === 'password')
            <button
                type="button"
                data-password-toggle
                aria-controls="{{ $name }}"
                aria-label="Tampilkan kata sandi"
                aria-pressed="false"
                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
            >
                <svg data-password-visible-icon class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                    <circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7" />
                </svg>
                <svg data-password-hidden-icon class="hidden size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="m3 3 18 18M10.6 6.2A10.7 10.7 0 0 1 12 6c6 0 9.5 6 9.5 6a17.6 17.6 0 0 1-3 3.5M6.2 6.2C3.9 7.7 2.5 12 2.5 12s3.5 6 9.5 6c1 0 1.9-.2 2.7-.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        @endif
    </div>
</div>
