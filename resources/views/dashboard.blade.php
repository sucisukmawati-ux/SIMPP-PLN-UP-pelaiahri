<x-app-layout title="Dashboard" active="dashboard">
    @php
        $statCards = [
            [
                'label' => 'Total Pelanggan',
                'value' => '12.480',
                'delta' => '+2,4%',
                'positive' => true,
                'note' => 'dari bulan lalu',
                'icon' => 'users',
            ],
            [
                'label' => 'Belum Bayar',
                'value' => '2.099',
                'delta' => '+1,8%',
                'positive' => false,
                'note' => '16,8% dari tagihan',
                'icon' => 'clock',
            ],
            [
                'label' => 'Sudah Lunas',
                'value' => '7.761',
                'delta' => '+5,2%',
                'positive' => true,
                'note' => '78,7% rasio lunas',
                'icon' => 'check-circle',
            ],
            [
                'label' => 'Total Tagihan',
                'value' => 'Rp1.284.500.000',
                'delta' => '+3,1%',
                'positive' => true,
                'note' => '9.860 tagihan terbit',
                'icon' => 'receipt',
            ],
        ];

        $lunasBulanan = [
            ['bulan' => 'Jun', 'tahun_ini' => 6820, 'tahun_lalu' => 6140],
            ['bulan' => 'Jul', 'tahun_ini' => 7050, 'tahun_lalu' => 6380],
            ['bulan' => 'Agu', 'tahun_ini' => 6940, 'tahun_lalu' => 6290],
            ['bulan' => 'Sep', 'tahun_ini' => 7310, 'tahun_lalu' => 6620],
            ['bulan' => 'Okt', 'tahun_ini' => 7540, 'tahun_lalu' => 6890],
            ['bulan' => 'Nov', 'tahun_ini' => 7761, 'tahun_lalu' => 7120],
        ];
        $maxLunas = 10000;

        // Koordinat SVG Grafik Garis (viewBox 760 x 230, area plot x: 54..736, y: 20..186)
        $plotLeft = 54;
        $plotRight = 736;
        $plotTop = 20;
        $plotBottom = 186;
        $plotHeight = $plotBottom - $plotTop;
        $pointCount = count($lunasBulanan);
        $stepX = $pointCount > 1 ? ($plotRight - $plotLeft) / ($pointCount - 1) : 0;

        $tahunIniPoints = [];
        $tahunLaluPoints = [];
        foreach ($lunasBulanan as $idx => $item) {
            $x = round($plotLeft + ($idx * $stepX), 1);
            $yIni = round($plotBottom - (($item['tahun_ini'] / $maxLunas) * $plotHeight), 1);
            $yLalu = round($plotBottom - (($item['tahun_lalu'] / $maxLunas) * $plotHeight), 1);
            $tahunIniPoints[] = ['x' => $x, 'y' => $yIni, 'val' => $item['tahun_ini'], 'bulan' => $item['bulan']];
            $tahunLaluPoints[] = ['x' => $x, 'y' => $yLalu, 'val' => $item['tahun_lalu'], 'bulan' => $item['bulan']];
        }
        $tahunIniPolyline = implode(' ', array_map(fn ($p) => "{$p['x']},{$p['y']}", $tahunIniPoints));
        $tahunLaluPolyline = implode(' ', array_map(fn ($p) => "{$p['x']},{$p['y']}", $tahunLaluPoints));

        $laporanPelanggan = [
            ['idpel' => '221400012345', 'nama' => 'Ahmad Fauzi', 'tarif' => 'R1 / 1.300 VA', 'periode' => 'November 2026', 'tagihan' => 412350, 'status' => 'belum'],
            ['idpel' => '221400023456', 'nama' => 'Siti Aminah', 'tarif' => 'R1M / 900 VA', 'periode' => 'November 2026', 'tagihan' => 268900, 'status' => 'lunas'],
            ['idpel' => '221400034567', 'nama' => 'Muhammad Rizky', 'tarif' => 'R2 / 3.500 VA', 'periode' => 'November 2026', 'tagihan' => 745200, 'status' => 'belum'],
            ['idpel' => '221400045678', 'nama' => 'Norhayati', 'tarif' => 'R1 / 450 VA', 'periode' => 'November 2026', 'tagihan' => 156450, 'status' => 'lunas'],
            ['idpel' => '221400056789', 'nama' => 'Bambang Setiawan', 'tarif' => 'B1 / 2.200 VA', 'periode' => 'November 2026', 'tagihan' => 1024800, 'status' => 'belum'],
            ['idpel' => '221400067890', 'nama' => 'Dewi Kartika', 'tarif' => 'R1 / 1.300 VA', 'periode' => 'November 2026', 'tagihan' => 389100, 'status' => 'lunas'],
            ['idpel' => '221400078901', 'nama' => 'Hendra Wijaya', 'tarif' => 'R1 / 2.200 VA', 'periode' => 'November 2026', 'tagihan' => 534600, 'status' => 'lunas'],
            ['idpel' => '221400089012', 'nama' => 'Rahmawati', 'tarif' => 'R1M / 900 VA', 'periode' => 'November 2026', 'tagihan' => 218750, 'status' => 'belum'],
            ['idpel' => '221400090123', 'nama' => 'Fajar Pratama', 'tarif' => 'R1 / 1.300 VA', 'periode' => 'November 2026', 'tagihan' => 342000, 'status' => 'lunas'],
            ['idpel' => '221400101234', 'nama' => 'Nurul Hidayah', 'tarif' => 'B1 / 4.400 VA', 'periode' => 'November 2026', 'tagihan' => 1250000, 'status' => 'lunas'],
        ];
        $sumTagihanLaporan = array_sum(array_column($laporanPelanggan, 'tagihan'));
        $countLunasLaporan = count(array_filter($laporanPelanggan, fn ($r) => $r['status'] === 'lunas'));
        $countBelumLaporan = count($laporanPelanggan) - $countLunasLaporan;
    @endphp

    <div class="space-y-6">
        {{-- Header Konten: Judul + Deskripsi Singkat & Filter Periode di Kanan Atas --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
            <div>
                <h1 class="text-[24px] font-semibold leading-tight tracking-[-0.02em] text-[#111111]">
                    Dashboard
                </h1>
                <p class="mt-1 text-[13px] text-[#6B6B6B]">
                    Ringkasan tagihan listrik dan pengiriman notifikasi pelanggan via WhatsApp.
                </p>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <label class="relative inline-flex items-center">
                    <svg class="pointer-events-none absolute left-3.5 size-4 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                    <select
                        aria-label="Filter periode"
                        class="appearance-none rounded-full border border-[#EAEAEA] bg-white py-2 pl-10 pr-9 text-[13px] font-medium text-[#111111] outline-none transition hover:border-[#D4D4D2] focus:border-[#1A1A1A]"
                    >
                        <option value="2026-11" selected>November 2026</option>
                        <option value="2026-10">Oktober 2026</option>
                        <option value="2026-09">September 2026</option>
                        <option value="30d">30 Hari Terakhir</option>
                    </select>
                    <svg class="pointer-events-none absolute right-3.5 size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </label>
            </div>
        </div>

        {{-- Baris Filter Pil (Tab Ringkasan / Laporan + Filter Layanan) --}}
        <div class="flex flex-wrap items-center justify-between gap-3 print:hidden">
            <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Tampilan Dashboard">
                <button
                    type="button"
                    role="tab"
                    aria-selected="true"
                    data-tab-target="ringkasan"
                    class="rounded-full border border-[#1A1A1A] bg-[#1A1A1A] px-4 py-1.5 text-[13px] font-medium text-white transition"
                >
                    Ringkasan
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="laporan"
                    class="rounded-full border border-[#EAEAEA] bg-white px-4 py-1.5 text-[13px] font-medium text-[#6B6B6B] transition hover:text-[#111111]"
                >
                    Laporan
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-1.5" data-filter-group>
                <button
                    type="button"
                    data-filter-pill
                    class="rounded-full border border-[#1A1A1A] bg-[#1A1A1A] px-3.5 py-1.5 text-[12px] font-medium text-white transition"
                >
                    Semua
                </button>
                <button
                    type="button"
                    data-filter-pill
                    class="rounded-full border border-[#EAEAEA] bg-white px-3.5 py-1.5 text-[12px] font-medium text-[#6B6B6B] transition hover:text-[#111111]"
                >
                    Tagihan
                </button>
                <button
                    type="button"
                    data-filter-pill
                    class="rounded-full border border-[#EAEAEA] bg-white px-3.5 py-1.5 text-[12px] font-medium text-[#6B6B6B] transition hover:text-[#111111]"
                >
                    Promo
                </button>
                <button
                    type="button"
                    data-filter-pill
                    class="rounded-full border border-[#EAEAEA] bg-white px-3.5 py-1.5 text-[12px] font-medium text-[#6B6B6B] transition hover:text-[#111111]"
                >
                    Pemberitahuan
                </button>
            </div>
        </div>

        {{-- TAB 1: RINGKASAN --}}
        <div data-tab-panel="ringkasan" class="space-y-6">
            {{-- Kartu Statistik 4 Kolom (8 Kartu) --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Statistik utama">
                @foreach ($statCards as $card)
                    <article class="rounded-[14px] border border-[#EAEAEA] bg-white p-5">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-[13px] font-medium text-[#6B6B6B]">{{ $card['label'] }}</p>
                            <span class="text-[#6B6B6B]">
                                @if ($card['icon'] === 'users')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                @elseif ($card['icon'] === 'clock')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                @elseif ($card['icon'] === 'check-circle')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>
                                    </svg>
                                @elseif ($card['icon'] === 'receipt')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/>
                                    </svg>
                                @elseif ($card['icon'] === 'send')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                                    </svg>
                                @elseif ($card['icon'] === 'alert-circle')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>
                                    </svg>
                                @elseif ($card['icon'] === 'tag')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>
                                    </svg>
                                @else
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                                    </svg>
                                @endif
                            </span>
                        </div>

                        <p class="mt-3 font-mono text-[22px] font-semibold tracking-tight text-[#111111] tabular-nums xl:text-[24px]">
                            {{ $card['value'] }}
                        </p>

                        <div class="mt-3 flex items-center gap-2">
                            @if ($card['positive'])
                                <span class="inline-flex items-center rounded-full bg-[#DDF5E6] px-2 py-0.5 font-mono text-[11px] font-medium text-[#22A95B]">
                                    {{ $card['delta'] }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-[#FBE3E1] px-2 py-0.5 font-mono text-[11px] font-medium text-[#D9453D]">
                                    {{ $card['delta'] }}
                                </span>
                            @endif
                            <span class="truncate text-[12px] text-[#6B6B6B]">{{ $card['note'] }}</span>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Grafik Garis: Perbandingan Sudah Lunas dari Bulan ke Bulan --}}
            <section aria-label="Grafik perbandingan sudah lunas per bulan">
                <article class="rounded-[14px] border border-[#EAEAEA] bg-white p-6">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="text-[15px] font-semibold text-[#111111]">Perbandingan Sudah Lunas per Bulan</h2>
                            <p class="mt-0.5 text-[12px] text-[#6B6B6B]">Tren tagihan lunas bulanan tahun 2026 dibandingkan tahun 2025</p>
                        </div>

                        <div class="flex items-center gap-2 text-[12px]">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#DDF5E6] px-2.5 py-0.5 font-medium text-[#22A95B]">
                                <span class="size-1.5 rounded-full bg-[#22A95B]"></span>
                                2026
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F4F4F3] px-2.5 py-0.5 font-medium text-[#6B6B6B]">
                                <span class="size-1.5 rounded-full bg-[#6B6B6B]"></span>
                                2025
                            </span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <svg viewBox="0 0 760 220" class="h-64 w-full overflow-visible" role="img" aria-label="Grafik garis perbandingan sudah lunas dari bulan ke bulan">
                            {{-- Grid horizontal & label sumbu Y --}}
                            @foreach ([10000, 7500, 5000, 2500, 0] as $tick)
                                @php($yTick = round($plotBottom - (($tick / $maxLunas) * $plotHeight), 1))
                                <line
                                    x1="{{ $plotLeft }}"
                                    y1="{{ $yTick }}"
                                    x2="{{ $plotRight }}"
                                    y2="{{ $yTick }}"
                                    stroke="#EAEAEA"
                                    stroke-width="1"
                                    stroke-dasharray="{{ $tick === 0 ? '0' : '3 3' }}"
                                />
                                <text
                                    x="{{ $plotLeft - 10 }}"
                                    y="{{ $yTick + 3.5 }}"
                                    text-anchor="end"
                                    fill="#6B6B6B"
                                    font-size="11"
                                    font-family="var(--font-mono)"
                                >{{ number_format($tick, 0, ',', '.') }}</text>
                            @endforeach

                            {{-- Garis Tahun Lalu (2025) --}}
                            <polyline
                                fill="none"
                                stroke="#6B6B6B"
                                stroke-width="1.8"
                                stroke-dasharray="4 4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                points="{{ $tahunLaluPolyline }}"
                            />

                            {{-- Garis Tahun Ini (2026) --}}
                            <polyline
                                fill="none"
                                stroke="#22A95B"
                                stroke-width="2.4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                points="{{ $tahunIniPolyline }}"
                            />

                            {{-- Titik Data Tahun Lalu --}}
                            @foreach ($tahunLaluPoints as $pt)
                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="3.5" fill="#FFFFFF" stroke="#6B6B6B" stroke-width="1.8">
                                    <title>{{ $pt['bulan'] }} 2025: {{ number_format($pt['val'], 0, ',', '.') }} lunas</title>
                                </circle>
                            @endforeach

                            {{-- Titik Data Tahun Ini --}}
                            @foreach ($tahunIniPoints as $pt)
                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4.5" fill="#FFFFFF" stroke="#22A95B" stroke-width="2.2">
                                    <title>{{ $pt['bulan'] }} 2026: {{ number_format($pt['val'], 0, ',', '.') }} lunas</title>
                                </circle>
                            @endforeach

                            {{-- Label Sumbu X --}}
                            @foreach ($tahunIniPoints as $pt)
                                <text
                                    x="{{ $pt['x'] }}"
                                    y="{{ $plotBottom + 20 }}"
                                    text-anchor="middle"
                                    fill="#6B6B6B"
                                    font-size="11.5"
                                >{{ $pt['bulan'] }}</text>
                            @endforeach
                        </svg>
                    </div>
                </article>
            </section>
        </div>

        {{-- TAB 2: LAPORAN --}}
        <div data-tab-panel="laporan" class="hidden space-y-5">
            {{-- Filter Periode & Tombol Cetak / Ekspor --}}
            <section class="flex flex-col gap-3 rounded-[14px] border border-[#EAEAEA] bg-white p-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
                <div class="flex flex-wrap items-center gap-2">
                    <label class="inline-flex items-center gap-2 rounded-full border border-[#EAEAEA] bg-[#F4F4F3] px-3.5 py-1.5 text-[12px] text-[#6B6B6B]">
                        <span>Periode:</span>
                        <select class="bg-transparent font-medium text-[#111111] outline-none">
                            <option value="2026-11" selected>November 2026</option>
                            <option value="2026-10">Oktober 2026</option>
                            <option value="2026-09">September 2026</option>
                        </select>
                    </label>

                    <label class="inline-flex items-center gap-2 rounded-full border border-[#EAEAEA] bg-[#F4F4F3] px-3.5 py-1.5 text-[12px] text-[#6B6B6B]">
                        <span>Status:</span>
                        <select data-laporan-status-filter class="bg-transparent font-medium text-[#111111] outline-none">
                            <option value="semua" selected>Semua Status</option>
                            <option value="lunas">Sudah Lunas</option>
                            <option value="belum">Belum Lunas</option>
                        </select>
                    </label>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        data-print
                        class="inline-flex items-center gap-2 rounded-full border border-[#EAEAEA] bg-white px-4 py-2 text-[13px] font-medium text-[#111111] transition hover:bg-[#F4F4F3]"
                    >
                        <svg class="size-4 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/>
                            <rect x="6" y="14" width="12" height="8" rx="1"/>
                        </svg>
                        Cetak
                    </button>

                    <button
                        type="button"
                        data-export="tabel-laporan-rekap"
                        data-filename="laporan-pelanggan-smpppln"
                        class="inline-flex items-center gap-2 rounded-full bg-[#1A1A1A] px-4 py-2 text-[13px] font-medium text-white transition hover:bg-[#111111]"
                    >
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" x2="12" y1="15" y2="3"/>
                        </svg>
                        Ekspor
                    </button>
                </div>
            </section>

            {{-- Tabel Rekap Pelanggan Lunas & Belum Lunas --}}
            <section class="overflow-hidden rounded-[14px] border border-[#EAEAEA] bg-white">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#EAEAEA] px-6 py-4">
                    <div>
                        <h2 class="text-[15px] font-semibold text-[#111111]">Laporan Pembayaran Pelanggan</h2>
                        <p class="mt-0.5 text-[12px] text-[#6B6B6B]">Daftar pelanggan lunas dan belum lunas pada periode November 2026</p>
                    </div>
                    <div class="flex items-center gap-2 text-[12px]">
                        <span class="inline-flex items-center rounded-full bg-[#DDF5E6] px-2.5 py-0.5 font-medium text-[#22A95B]">
                            {{ $countLunasLaporan }} Lunas
                        </span>
                        <span class="inline-flex items-center rounded-full bg-[#FBE3E1] px-2.5 py-0.5 font-medium text-[#D9453D]">
                            {{ $countBelumLaporan }} Belum Lunas
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="tabel-laporan-rekap" class="w-full min-w-[700px] text-left text-[13px]">
                        <thead class="border-b border-[#EAEAEA] bg-[#F4F4F3]/60 text-[12px] font-medium text-[#6B6B6B]">
                            <tr>
                                <th class="px-6 py-3.5">IDPEL</th>
                                <th class="px-4 py-3.5">Nama Pelanggan</th>
                                <th class="px-4 py-3.5">Tarif / Daya</th>
                                <th class="px-4 py-3.5">Periode</th>
                                <th class="px-4 py-3.5 text-right">Total Tagihan</th>
                                <th class="px-6 py-3.5 text-right">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAEAEA]">
                            @foreach ($laporanPelanggan as $row)
                                <tr data-laporan-row data-status="{{ $row['status'] }}" class="transition hover:bg-[#F4F4F3]/40">
                                    <td class="px-6 py-3.5 font-mono tabular-nums text-[#111111]">{{ $row['idpel'] }}</td>
                                    <td class="px-4 py-3.5 font-medium text-[#111111]">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3.5 text-[#6B6B6B]">{{ $row['tarif'] }}</td>
                                    <td class="px-4 py-3.5 text-[#6B6B6B]">{{ $row['periode'] }}</td>
                                    <td class="px-4 py-3.5 text-right font-mono tabular-nums text-[#111111]">Rp{{ number_format($row['tagihan'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-3.5 text-right">
                                        @if ($row['status'] === 'lunas')
                                            <span class="inline-flex rounded-full bg-[#DDF5E6] px-2.5 py-0.5 text-[11px] font-medium text-[#22A95B]">
                                                Sudah Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-[#FBE3E1] px-2.5 py-0.5 text-[11px] font-medium text-[#D9453D]">
                                                Belum Lunas
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-[#EAEAEA] bg-[#F4F4F3]/60 font-semibold text-[#111111]">
                            <tr>
                                <td class="px-6 py-3.5" colspan="4">Total ({{ count($laporanPelanggan) }} pelanggan)</td>
                                <td class="px-4 py-3.5 text-right font-mono tabular-nums">Rp{{ number_format($sumTagihanLaporan, 0, ',', '.') }}</td>
                                <td class="px-6 py-3.5 text-right text-[12px] font-medium text-[#6B6B6B]">{{ $countLunasLaporan }} Lunas · {{ $countBelumLaporan }} Belum</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
