@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex min-h-10 items-center justify-center rounded-xl bg-blue-900 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-950/20 transition hover:bg-blue-950 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-800 active:translate-y-px']) }}
>
    <span>{{ $slot }}</span>
</button>
