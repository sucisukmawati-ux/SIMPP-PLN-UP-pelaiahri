@props(['title'])

<x-layouts.guest :title="$title . ' | SIMPP PLN UP Pelaiahri'">
    <div class="min-h-screen bg-slate-100 text-slate-900">
        <div data-sidebar-backdrop class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>
        <x-sidebar active="pelanggan" />

        <main class="lg:pl-64">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-5 lg:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" data-sidebar-toggle class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 lg:hidden" aria-label="Buka menu">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Data Pelanggan</p>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $title }}</h1>
                    </div>
                </div>
                <button type="button" class="relative inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500" aria-label="Notifikasi">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </header>

            <div class="mx-auto max-w-[1440px] p-4 sm:p-5">
                {{ $slot }}
            </div>
        </main>
    </div>
</x-layouts.guest>
