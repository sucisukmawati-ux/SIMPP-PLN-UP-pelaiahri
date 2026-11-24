@props(['active' => 'dashboard'])

<aside
    data-mobile-sidebar
    class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col bg-[#071b2b] text-white transition-transform duration-300 lg:translate-x-0"
>
    <div class="flex h-20 flex-col justify-center px-5">
        <x-ui.brand />
        <span class="ml-[52px] -mt-1 text-[0.58rem] font-bold tracking-[0.12em] text-slate-400">v1.2.0</span>
    </div>

    <nav class="flex-1 px-3 py-3" aria-label="Navigasi utama">
        <p class="px-3 pb-2 text-[0.58rem] font-bold uppercase tracking-[0.16em] text-slate-400">Menu Utama</p>
        <div class="grid gap-1">
            <a href="{{ route('dashboard') }}" class="flex h-11 items-center rounded-lg px-3 text-sm font-medium {{ $active === 'dashboard' ? 'border border-blue-300/70 bg-blue-600 text-white shadow-lg shadow-blue-950/20' : 'text-slate-300 transition hover:bg-white/5 hover:text-white' }}">
                Dashboard
            </a>

            <a href="{{ route('pelanggan.index') }}" class="flex h-11 items-center rounded-lg px-3 text-sm font-medium {{ $active === 'pelanggan' ? 'border border-blue-300/70 bg-blue-600 text-white shadow-lg shadow-blue-950/20' : 'text-slate-300 transition hover:bg-white/5 hover:text-white' }}">
                Data Pelanggan
            </a>

            <a href="#" class="flex h-11 items-center rounded-lg px-3 text-sm font-medium {{ $active === 'pengaturan' ? 'bg-white/10 text-white' : 'text-slate-300 transition hover:bg-white/5 hover:text-white' }}">
                Pengaturan
            </a>
        </div>
    </nav>

    <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-2">
            <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-slate-700 text-xs font-bold text-blue-200">UP</span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-bold text-slate-200">UP PELAIHARI</p>
                <p class="truncate text-[0.58rem] text-slate-400">ULP · 22140-22140</p>
            </div>
            <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-400 transition hover:text-white" title="Keluar">Keluar</a>
        </div>
    </div>
</aside>
