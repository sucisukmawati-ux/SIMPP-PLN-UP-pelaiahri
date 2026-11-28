@props(['title'])

<x-app-layout :title="$title" section="Data Pelanggan" active="pelanggan">
    {{ $slot }}
</x-app-layout>
