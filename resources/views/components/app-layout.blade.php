@props(['title' => 'Dashboard', 'active' => 'dashboard'])

<x-layouts.guest :title="$title . ' | SMPPPLN'">
    <div data-app-shell class="min-h-screen bg-[#F4F4F3] text-[#111111] print:bg-white">
        {{-- Backdrop mobile --}}
        <div
            data-sidebar-backdrop
            class="fixed inset-0 z-40 hidden bg-[#111111]/20 backdrop-blur-[1px] lg:hidden"
            aria-hidden="true"
        ></div>

        <x-sidebar :active="$active" />

        {{-- Topbar khusus mobile --}}
        <header class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-[#EAEAEA] bg-white px-4 lg:hidden print:hidden">
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    data-sidebar-toggle
                    class="inline-flex size-9 items-center justify-center rounded-full border border-[#EAEAEA] bg-white text-[#111111]"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="4" x2="20" y1="12" y2="12"/>
                        <line x1="4" x2="20" y1="6" y2="6"/>
                        <line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                </button>
                <span class="text-[15px] font-semibold tracking-tight text-[#111111]">SMPPPLN</span>
            </div>

            <span class="rounded-full bg-[#F4F4F3] px-3 py-1 text-[12px] font-medium text-[#6B6B6B]">
                {{ ucfirst(auth()->user()->name ?? 'Admin') }}
            </span>
        </header>

        {{-- Konten Utama --}}
        <main data-main-content class="min-h-screen transition-[padding] duration-200 lg:pl-[248px] print:min-h-0 print:pl-0">
            <div class="mx-auto max-w-[1360px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8 print:max-w-none print:p-0">
                {{ $slot }}
            </div>
        </main>
    </div>
</x-layouts.guest>
