<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
</div>
@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => 'off',
])

<div class="flex flex-col gap-2">
    <label for="{{ $name }}" class="text-sm font-semibold text-slate-700">{{ $label }}</label>
    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
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
            {{ $attributes->merge(['class' => 'block w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 ']) }}
        >
    </div>
</div>
