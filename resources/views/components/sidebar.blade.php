@props(['active' => 'dashboard'])

@php
    $menus = [
        [
            'key' => 'dashboard',
            'label' => 'Dashboard',
            'href' => route('dashboard'),
            'icon' => 'layout-dashboard',
        ],
        [
            'key' => 'pelanggan',
            'label' => 'Pelanggan',
            'href' => Route::has('pelanggan.index') ? route('pelanggan.index') : '#pelanggan',
            'icon' => 'users',
        ],
        [
            'key' => 'notifikasi',
            'label' => 'Notifikasi',
            'href' => Route::has('notifikasi.index') ? route('notifikasi.index') : '#notifikasi',
            'icon' => 'message-square',
        ],
        [
            'key' => 'pengaturan',
            'label' => 'Pengaturan',
            'href' => Route::has('pengaturan.index') ? route('pengaturan.index') : '#pengaturan',
            'icon' => 'settings',
        ],
    ];
@endphp

<aside
    data-mobile-sidebar
    data-sidebar
    class="fixed inset-y-3 left-3 z-50 flex w-[220px] -translate-x-[calc(100%+1.5rem)] flex-col rounded-[14px] border border-[#EAEAEA] bg-white transition-all duration-200 lg:inset-y-4 lg:left-4 lg:translate-x-0 print:hidden"
>
    {{-- Header: Nama Sistem & Tombol Ciutkan --}}
    <div class="flex h-16 items-center justify-between border-b border-[#EAEAEA] px-4">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-2.5">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-[10px] bg-[#1A1A1A] text-white">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>
                </svg>
            </span>
            <span data-sidebar-text class="truncate text-[15px] font-semibold tracking-tight text-[#111111]">SMPPPLN</span>
        </a>

        <button
            type="button"
            data-sidebar-collapse
            class="hidden size-7 shrink-0 items-center justify-center rounded-lg text-[#6B6B6B] transition hover:bg-[#F4F4F3] hover:text-[#111111] lg:inline-flex"
            aria-label="Ciutkan sidebar"
            title="Ciutkan sidebar"
        >
            <svg data-collapse-icon class="size-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="M9 3v18"/>
                <path d="m16 15-3-3 3-3"/>
            </svg>
        </button>

        <button
            type="button"
            data-sidebar-toggle
            class="inline-flex size-7 shrink-0 items-center justify-center rounded-lg text-[#6B6B6B] transition hover:bg-[#F4F4F3] hover:text-[#111111] lg:hidden"
            aria-label="Tutup menu"
        >
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigasi Utama (Hanya 4 Menu) --}}
    <nav class="flex-1 space-y-1 p-3" aria-label="Navigasi utama">
        @foreach ($menus as $menu)
            @php($isActive = $active === $menu['key'])
            <a
                href="{{ $menu['href'] }}"
                title="{{ $menu['label'] }}"
                class="group flex h-10 items-center gap-3 rounded-[10px] px-3 text-[13px] transition {{ $isActive ? 'bg-[#F4F4F3] font-medium text-[#111111]' : 'text-[#6B6B6B] hover:bg-[#F4F4F3]/60 hover:text-[#111111]' }}"
            >
                @if ($menu['icon'] === 'layout-dashboard')
                    <svg class="size-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                    </svg>
                @elseif ($menu['icon'] === 'users')
                    <svg class="size-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                @elseif ($menu['icon'] === 'message-square')
                    <svg class="size-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                @else
                    <svg class="size-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                @endif
                <span data-sidebar-text class="truncate">{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Logout di bagian bawah sidebar --}}
    <div class="border-t border-[#EAEAEA] p-3">
        <div data-sidebar-text class="mb-2 flex items-center gap-2.5 px-2 py-1">
            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-[#F4F4F3] text-[11px] font-semibold uppercase text-[#111111]">
                {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
            </span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-[13px] font-medium text-[#111111]">{{ ucfirst(auth()->user()->name ?? 'Admin') }}</p>
                <p class="truncate text-[11px] text-[#6B6B6B]">Administrator</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                title="Logout"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-[13px] font-medium text-[#6B6B6B] transition hover:bg-[#FBE3E1] hover:text-[#D9453D]"
            >
                <svg class="size-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
                <span data-sidebar-text class="truncate">Logout</span>
            </button>
        </form>
    </div>
</aside>
