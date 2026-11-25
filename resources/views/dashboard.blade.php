<<<<<<< HEAD
<x-layouts.guest title="Dashboard | SIMPP PLN UP Pelaiahri">
    <div class="min-h-screen bg-slate-100 text-slate-900">
        <div
            data-sidebar-backdrop
            class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"
            aria-hidden="true"
        ></div>

        <x-sidebar active="dashboard" />

        <main class="lg:pl-64">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-5 lg:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" data-sidebar-toggle class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 lg:hidden" aria-label="Buka menu">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Ringkasan Operasional</h1>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" class="relative inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:text-blue-700" aria-label="Notifikasi">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="absolute right-2.5 top-2.5 size-2 rounded-full border-2 border-white bg-red-500"></span>
                    </button>
                    <button type="button" class="flex items-center gap-2 rounded-xl border border-slate-200 p-1.5 pr-2.5 text-left">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-800">AP</span>
                        <span class="hidden sm:block">
                            <span class="block text-xs font-bold text-slate-800">Administrator</span>
                            <span class="block text-[0.65rem] text-slate-500">UP Pelaiahri</span>
                        </span>
                    </button>
                </div>
            </header>

            <div class="mx-auto max-w-[1440px] p-4 sm:p-5">
                <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan data">
                    @foreach([
                        ['Total Pelanggan', '8.452', '+2,4%', 'blue', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87'],
                        ['Tagihan Bulan Ini', 'Rp 2,84 M', '+8,1%', 'emerald', 'M3 6h18v12H3zM3 10h18M7 15h3'],
                        ['Sudah Dibayar', 'Rp 2,21 M', '77,8%', 'amber', 'M20 12a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM12 7v5l3 2'],
                        ['Tunggakan', 'Rp 630 Jt', '-3,2%', 'red', 'M12 9v4M12 17h.01M10.3 3.8 2.5 18a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z'],
                    ] as [$title, $value, $change, $color, $path])
                        @php
                            $colorClasses = [
                                'blue' => 'bg-blue-50 text-blue-700',
                                'emerald' => 'bg-emerald-50 text-emerald-700',
                                'amber' => 'bg-amber-50 text-amber-700',
                                'red' => 'bg-red-50 text-red-700',
                            ];
                        @endphp
                        <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
                                    <p class="mt-1.5 text-[28px] font-bold tracking-tight text-slate-900">{{ $value }}</p>
                                </div>
                                <span class="flex size-9 shrink-0 items-center justify-center rounded-lg {{ $colorClasses[$color] }}">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="{{ $path }}" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">
                                <span class="mr-1 font-bold {{ str_starts_with($change, '-') ? 'text-red-600' : 'text-emerald-600' }}">{{ $change }}</span>
                                dari bulan lalu
                            </p>
                        </article>
                    @endforeach
                </section>

                <section class="mt-4 grid gap-4 xl:grid-cols-[minmax(0,1.6fr)_minmax(260px,.7fr)]">
                    <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h2 class="text-sm font-bold text-slate-900">Grafik Pencapaian Pembayaran</h2>
                                <p class="mt-0.5 text-xs text-slate-500">November 2026</p>
                            </div>
                            <button type="button" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600">6 Bulan terakhir</button>
                        </div>

                        <div class="mt-3 h-48">
                            <svg viewBox="0 0 700 250" role="img" aria-label="Grafik pencapaian pembayaran" class="h-full w-full overflow-visible">
                                <g stroke="#e2e8f0" stroke-width="1">
                                    <line x1="52" y1="20" x2="680" y2="20"/>
                                    <line x1="52" y1="75" x2="680" y2="75"/>
                                    <line x1="52" y1="130" x2="680" y2="130"/>
                                    <line x1="52" y1="185" x2="680" y2="185"/>
                                    <line x1="52" y1="235" x2="680" y2="235"/>
                                </g>
                                <g fill="#94a3b8" font-size="12">
                                    <text x="10" y="24">100%</text>
                                    <text x="18" y="79">75%</text>
                                    <text x="18" y="134">50%</text>
                                    <text x="18" y="189">25%</text>
                                    <text x="27" y="239">0%</text>
                                    <text x="80" y="249">Jun</text>
                                    <text x="195" y="249">Jul</text>
                                    <text x="310" y="249">Ags</text>
                                    <text x="425" y="249">Sep</text>
                                    <text x="540" y="249">Okt</text>
                                    <text x="648" y="249">Nov</text>
                                </g>
                                <defs>
                                    <linearGradient id="chartFill" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#2563eb" stop-opacity=".20"/>
                                        <stop offset="100%" stop-color="#2563eb" stop-opacity="0"/>
                                    </linearGradient>
                                </defs>
                                <path d="M85 142 C150 130 175 118 205 125 C270 140 315 108 330 101 C390 88 420 112 445 96 C510 65 535 88 560 75 C610 57 638 63 655 48 L655 235 L85 235 Z" fill="url(#chartFill)"/>
                                <path d="M85 142 C150 130 175 118 205 125 C270 140 315 108 330 101 C390 88 420 112 445 96 C510 65 535 88 560 75 C610 57 638 63 655 48" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round"/>
                                <g fill="#2563eb" stroke="white" stroke-width="3">
                                    <circle cx="85" cy="142" r="5"/><circle cx="205" cy="125" r="5"/><circle cx="330" cy="101" r="5"/><circle cx="445" cy="96" r="5"/><circle cx="560" cy="75" r="5"/><circle cx="655" cy="48" r="5"/>
                                </g>
                            </svg>
                        </div>
                    </article>

                    <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Status Tagihan</h2>
                            <p class="mt-0.5 text-xs text-slate-500">Persentase bulan ini</p>
                        </div>
                        <div class="mx-auto mt-3 flex size-36 items-center justify-center rounded-full" style="background: conic-gradient(#2563eb 0 78%, #f59e0b 78% 91%, #ef4444 91% 100%)">
                            <div class="flex size-28 flex-col items-center justify-center rounded-full bg-white">
                                <span class="text-2xl font-extrabold text-slate-900">77,8%</span>
                                <span class="mt-1 text-xs text-slate-500">Terbayar</span>
                            </div>
                        </div>
                        <div class="mt-3 grid gap-2">
                            @foreach([
                                ['Lunas', 'Rp 2,21 M', 'bg-blue-600'],
                                ['Sebagian', 'Rp 163 Jt', 'bg-amber-500'],
                                ['Belum bayar', 'Rp 467 Jt', 'bg-red-500'],
                            ] as [$label, $value, $color])
                                <div class="flex items-center justify-between text-xs">
                                    <span class="flex items-center gap-2 text-slate-500"><span class="size-2.5 rounded-full {{ $color }}"></span>{{ $label }}</span>
                                    <span class="font-bold text-slate-800">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>

                <section class="mt-4 rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-4 py-3">
                        <div>
                            <h2 class="text-sm font-bold text-slate-900">Tagihan Terbaru</h2>
                            <p class="mt-0.5 text-xs text-slate-500">Daftar transaksi tagihan terakhir</p>
                        </div>
                        <a href="#" class="text-sm font-semibold text-blue-700 hover:text-blue-900">Lihat semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[680px] text-left">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-400">
                                    <th class="px-4 py-2 font-semibold">ID Pelanggan</th>
                                    <th class="px-4 py-2 font-semibold">Nama</th>
                                    <th class="px-4 py-2 font-semibold">Periode</th>
                                    <th class="px-4 py-2 font-semibold">Jumlah</th>
                                    <th class="px-4 py-2 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-normal">
                                @foreach([
                                    ['5120342109', 'PT Sinar Makmur', 'Nov 2026', 'Rp 42.780.000', 'Lunas', 'bg-emerald-50 text-emerald-700'],
                                    ['5120342088', 'CV Pelita Jaya', 'Nov 2026', 'Rp 18.450.000', 'Belum bayar', 'bg-red-50 text-red-700'],
                                    ['5120342054', 'Hotel Samudra', 'Nov 2026', 'Rp 36.920.000', 'Lunas', 'bg-emerald-50 text-emerald-700'],
                                    ['5120342017', 'UD Mandiri Elektrik', 'Nov 2026', 'Rp 12.780.000', 'Sebagian', 'bg-amber-50 text-amber-700'],
                                ] as [$id, $name, $period, $amount, $status, $statusClass])
                                    <tr class="transition hover:bg-slate-50">
                                        <td class="px-4 py-2.5 text-slate-700">{{ $id }}</td>
                                        <td class="px-4 py-2.5 text-slate-700">{{ $name }}</td>
                                        <td class="px-4 py-2.5 text-slate-500">{{ $period }}</td>
                                        <td class="px-4 py-2.5 text-slate-800">{{ $amount }}</td>
                                        <td class="px-4 py-2.5"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-normal {{ $statusClass }}">{{ $status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
=======
<x-layouts.guest>
    <main class="flex min-h-screen items-center justify-center bg-[#071b2b] px-4 py-8 text-slate-900">
        <section class="w-full max-w-xl rounded-3xl bg-white p-6 shadow-2xl">
            <h1 class="text-2xl font-bold">Dashboard SIMPP</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Anda masuk sebagai {{ auth()->user()->name }} dengan email terverifikasi.
            </p>
            @if (session('status'))
                <p role="status" class="mt-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">{{ session('status') }}</p>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <x-ui.primary-button type="submit">Keluar</x-ui.primary-button>
            </form>
        </section>
    </main>
>>>>>>> f5633f662abd2d75e88ae1dec4d34ac2b76f8e41
</x-layouts.guest>
