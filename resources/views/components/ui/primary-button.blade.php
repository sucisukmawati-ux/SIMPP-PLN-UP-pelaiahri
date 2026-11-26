<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->
</div>
@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex min-h-12 items-center justify-center gap-2 rounded-md bg-blue-300 px-5 py-3 text-sm font-medium text-white shadow-lg shadow-blue-900/15 transition hover:bg-blue-700 active:translate-y-px']) }}
>
    <span>{{ $slot }}</span>
</button>
