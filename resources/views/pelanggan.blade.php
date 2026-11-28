<x-app-layout title="Pelanggan" active="pelanggan">
    @php
        $pelangganList = [
            ['idpel' => '221400012345', 'nama' => 'Ahmad Fauzi', 'alamat' => 'Jl. A. Yani No. 12, Pelaihari', 'tarif' => 'R1', 'daya' => '1.300 VA', 'hp' => '0812-3456-7890', 'promo' => true, 'wilayah' => 'Pelaihari', 'gardu' => 'GD A. Yani', 'lat' => -3.78612, 'lng' => 114.77421],
            ['idpel' => '221400023456', 'nama' => 'Siti Aminah', 'alamat' => 'Jl. Pasar Baru No. 45, Pelaihari', 'tarif' => 'R1M', 'daya' => '900 VA', 'hp' => '0813-2211-4455', 'promo' => true, 'wilayah' => 'Pelaihari', 'gardu' => 'GD Pasar Baru', 'lat' => -3.78534, 'lng' => 114.77602],
            ['idpel' => '221400034567', 'nama' => 'Muhammad Rizky', 'alamat' => 'Jl. Raya Takisung Km. 3', 'tarif' => 'R2', 'daya' => '3.500 VA', 'hp' => '0852-7788-9900', 'promo' => false, 'wilayah' => 'Takisung', 'gardu' => 'GD Takisung', 'lat' => -3.85974, 'lng' => 114.68135],
            ['idpel' => '221400045678', 'nama' => 'Norhayati', 'alamat' => 'Jl. Desa Batu Ampar No. 8', 'tarif' => 'R1', 'daya' => '450 VA', 'hp' => '0817-1122-3344', 'promo' => true, 'wilayah' => 'Batu Ampar', 'gardu' => 'GD Batu Ampar', 'lat' => -3.91826, 'lng' => 114.82954],
            ['idpel' => '221400056789', 'nama' => 'Bambang Setiawan', 'alamat' => 'Jl. A. Yani No. 88, Pelaihari', 'tarif' => 'B1', 'daya' => '2.200 VA', 'hp' => '0811-5566-7788', 'promo' => false, 'wilayah' => 'Pelaihari', 'gardu' => 'GD A. Yani', 'lat' => -3.78751, 'lng' => 114.77188],
            ['idpel' => '221400067890', 'nama' => 'Dewi Kartika', 'alamat' => 'Jl. Kintap Raya No. 21', 'tarif' => 'R1', 'daya' => '1.300 VA', 'hp' => '0821-3344-5566', 'promo' => true, 'wilayah' => 'Takisung', 'gardu' => 'GD Kintap', 'lat' => -3.88890, 'lng' => 114.75012],
            ['idpel' => '221400078901', 'nama' => 'Hendra Wijaya', 'alamat' => 'Jl. Jorong No. 5, Batu Ampar', 'tarif' => 'R1', 'daya' => '2.200 VA', 'hp' => '0813-9988-7766', 'promo' => true, 'wilayah' => 'Batu Ampar', 'gardu' => 'GD Jorong', 'lat' => -3.98012, 'lng' => 114.90033],
            ['idpel' => '221400089012', 'nama' => 'Rahmawati', 'alamat' => 'Jl. Pasar Baru No. 3, Pelaihari', 'tarif' => 'R1M', 'daya' => '900 VA', 'hp' => '0857-1234-5678', 'promo' => false, 'wilayah' => 'Pelaihari', 'gardu' => 'GD Pasar Baru', 'lat' => -3.78492, 'lng' => 114.77765],
            ['idpel' => '221400090123', 'nama' => 'Fajar Pratama', 'alamat' => 'Jl. Raya Takisung Km. 7', 'tarif' => 'R1', 'daya' => '1.300 VA', 'hp' => '0819-2468-1357', 'promo' => true, 'wilayah' => 'Takisung', 'gardu' => 'GD Takisung', 'lat' => -3.86110, 'lng' => 114.67942],
            ['idpel' => '221400101234', 'nama' => 'Nurul Hidayah', 'alamat' => 'Jl. Desa Batu Ampar No. 30', 'tarif' => 'B1', 'daya' => '4.400 VA', 'hp' => '0812-8642-9753', 'promo' => true, 'wilayah' => 'Batu Ampar', 'gardu' => 'GD Batu Ampar', 'lat' => -3.91955, 'lng' => 114.83102],
        ];

        $tagihanList = [
            ['idpel' => '221400012345', 'nama' => 'Ahmad Fauzi', 'periode' => 'November 2026', 'total' => 412350, 'status' => 'belum'],
            ['idpel' => '221400023456', 'nama' => 'Siti Aminah', 'periode' => 'November 2026', 'total' => 268900, 'status' => 'lunas'],
            ['idpel' => '221400034567', 'nama' => 'Muhammad Rizky', 'periode' => 'November 2026', 'total' => 745200, 'status' => 'belum'],
            ['idpel' => '221400045678', 'nama' => 'Norhayati', 'periode' => 'November 2026', 'total' => 156450, 'status' => 'lunas'],
            ['idpel' => '221400056789', 'nama' => 'Bambang Setiawan', 'periode' => 'November 2026', 'total' => 1024800, 'status' => 'belum'],
            ['idpel' => '221400067890', 'nama' => 'Dewi Kartika', 'periode' => 'November 2026', 'total' => 389100, 'status' => 'lunas'],
            ['idpel' => '221400078901', 'nama' => 'Hendra Wijaya', 'periode' => 'November 2026', 'total' => 534600, 'status' => 'lunas'],
            ['idpel' => '221400089012', 'nama' => 'Rahmawati', 'periode' => 'November 2026', 'total' => 218750, 'status' => 'belum'],
            ['idpel' => '221400090123', 'nama' => 'Fajar Pratama', 'periode' => 'November 2026', 'total' => 342000, 'status' => 'lunas'],
            ['idpel' => '221400101234', 'nama' => 'Nurul Hidayah', 'periode' => 'November 2026', 'total' => 1250000, 'status' => 'lunas'],
        ];

        $totalPromo = count(array_filter($pelangganList, fn ($p) => $p['promo']));
        $totalLunas = count(array_filter($tagihanList, fn ($t) => $t['status'] === 'lunas'));
        $totalBelum = count($tagihanList) - $totalLunas;

        $pelangganById = collect($pelangganList)->keyBy('idpel');
        $tagihanById = collect($tagihanList)->keyBy('idpel');
    @endphp

    <div class="space-y-6">
        {{-- Header: Judul + Deskripsi & Filter Periode --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
            <div>
                <h1 class="text-[24px] font-semibold leading-tight tracking-[-0.02em] text-[#111111]">
                    Pelanggan
                </h1>
                <p class="mt-1 text-[13px] text-[#6B6B6B]">
                    Kelola data pelanggan, tagihan bulanan, serta preferensi penerimaan promo.
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
                    </select>
                    <svg class="pointer-events-none absolute right-3.5 size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </label>
            </div>
        </div>

        {{-- Baris Tab Pil --}}
        <div class="flex flex-wrap items-center justify-between gap-3 print:hidden">
            <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Tampilan Pelanggan">
                <button
                    type="button"
                    role="tab"
                    aria-selected="true"
                    data-tab-target="data-pelanggan"
                    class="rounded-full border border-[#1A1A1A] bg-[#1A1A1A] px-4 py-1.5 text-[13px] font-medium text-white transition"
                >
                    Data Pelanggan
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    data-tab-target="tagihan"
                    class="rounded-full border border-[#EAEAEA] bg-white px-4 py-1.5 text-[13px] font-medium text-[#6B6B6B] transition hover:text-[#111111]"
                >
                    Tagihan
                </button>
            </div>

            <div class="flex items-center gap-2 text-[12px]">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F4F4F3] px-3 py-1 font-medium text-[#6B6B6B]">
                    <span class="size-1.5 rounded-full bg-[#111111]"></span>
                    {{ count($pelangganList) }} Pelanggan
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#DDF5E6] px-3 py-1 font-medium text-[#22A95B]">
                    {{ $totalPromo }} Terima Promo
                </span>
            </div>
        </div>

        {{-- TAB 1: DATA PELANGGAN --}}
        <div data-tab-panel="data-pelanggan" class="space-y-4">
            {{-- Toolbar: Pencarian, Filter Wilayah/Gardu, Impor Excel --}}
            <section class="rounded-[14px] border border-[#EAEAEA] bg-white p-4">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-center">
                        <label class="relative flex-1 sm:max-w-xs">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" x2="16.65" y1="21" y2="16.65"/>
                            </svg>
                            <input
                                type="search"
                                data-pelanggan-search
                                placeholder="Cari IDPEL, nama, atau no HP..."
                                class="w-full rounded-full border border-[#EAEAEA] bg-[#F4F4F3] py-2 pl-10 pr-4 text-[13px] text-[#111111] outline-none transition placeholder:text-[#6B6B6B] focus:border-[#1A1A1A] focus:bg-white"
                            >
                        </label>

                        <label class="relative inline-flex items-center">
                            <select
                                data-pelanggan-wilayah
                                aria-label="Filter wilayah"
                                class="appearance-none rounded-full border border-[#EAEAEA] bg-white py-2 pl-4 pr-9 text-[13px] font-medium text-[#111111] outline-none transition hover:border-[#D4D4D2] focus:border-[#1A1A1A]"
                            >
                                <option value="semua" selected>Semua Wilayah</option>
                                <option value="Pelaihari">Pelaihari</option>
                                <option value="Takisung">Takisung</option>
                                <option value="Batu Ampar">Batu Ampar</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3.5 size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </label>

                        <label class="relative inline-flex items-center">
                            <select
                                data-pelanggan-gardu
                                aria-label="Filter gardu"
                                class="appearance-none rounded-full border border-[#EAEAEA] bg-white py-2 pl-4 pr-9 text-[13px] font-medium text-[#111111] outline-none transition hover:border-[#D4D4D2] focus:border-[#1A1A1A]"
                            >
                                <option value="semua" selected>Semua Gardu</option>
                                <option value="GD A. Yani">GD A. Yani</option>
                                <option value="GD Pasar Baru">GD Pasar Baru</option>
                                <option value="GD Takisung">GD Takisung</option>
                                <option value="GD Kintap">GD Kintap</option>
                                <option value="GD Batu Ampar">GD Batu Ampar</option>
                                <option value="GD Jorong">GD Jorong</option>
                            </select>
                            <svg class="pointer-events-none absolute right-3.5 size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </label>
                    </div>

                    <button
                        type="button"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#1A1A1A] px-4 py-2 text-[13px] font-medium text-white transition hover:bg-[#111111]"
                    >
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" x2="12" y1="3" y2="15"/>
                        </svg>
                        Impor Excel
                    </button>
                </div>
            </section>

            {{-- Tabel Data Pelanggan --}}
            <section class="overflow-hidden rounded-[14px] border border-[#EAEAEA] bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left text-[13px]">
                        <thead class="border-b border-[#EAEAEA] bg-[#F4F4F3]/60 text-[12px] font-medium text-[#6B6B6B]">
                            <tr>
                                <th class="px-6 py-3.5">IDPEL</th>
                                <th class="px-4 py-3.5">Nama</th>
                                <th class="px-4 py-3.5">Alamat</th>
                                <th class="px-4 py-3.5">Tarif</th>
                                <th class="px-4 py-3.5">Daya</th>
                                <th class="px-4 py-3.5">No HP</th>
                                <th class="px-6 py-3.5 text-right">Terima Promo</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAEAEA]">
                            @foreach ($pelangganList as $row)
                                @php($t = $tagihanById[$row['idpel']] ?? null)
                                <tr
                                    data-pelanggan-row
                                    data-idpel="{{ $row['idpel'] }}"
                                    data-nama="{{ $row['nama'] }}"
                                    data-alamat="{{ $row['alamat'] }}"
                                    data-tarif="{{ $row['tarif'] }}"
                                    data-daya="{{ $row['daya'] }}"
                                    data-hp="{{ $row['hp'] }}"
                                    data-promo="{{ $row['promo'] ? 'Ya' : 'Tidak' }}"
                                    data-periode="{{ $t['periode'] ?? 'November 2026' }}"
                                    data-total="{{ $t['total'] ?? 0 }}"
                                    data-status="{{ $t['status'] ?? 'belum' }}"
                                    data-wilayah="{{ $row['wilayah'] }}"
                                    data-gardu="{{ $row['gardu'] }}"
                                    data-lat="{{ $row['lat'] }}"
                                    data-lng="{{ $row['lng'] }}"
                                    class="transition hover:bg-[#F4F4F3]/40"
                                >
                                    <td class="px-6 py-3.5 font-mono tabular-nums text-[#111111]">{{ $row['idpel'] }}</td>
                                    <td class="px-4 py-3.5 font-medium text-[#111111]">
                                        <button type="button" data-detail-open class="text-left transition hover:text-[#22A95B] hover:underline">
                                            {{ $row['nama'] }}
                                        </button>
                                    </td>
                                    <td class="max-w-[240px] truncate px-4 py-3.5 text-[#6B6B6B]">{{ $row['alamat'] }}</td>
                                    <td class="px-4 py-3.5 text-[#111111]">{{ $row['tarif'] }}</td>
                                    <td class="px-4 py-3.5 font-mono tabular-nums text-[#111111]">{{ $row['daya'] }}</td>
                                    <td class="px-4 py-3.5 font-mono tabular-nums text-[#111111]">{{ $row['hp'] }}</td>
                                    <td class="px-6 py-3.5 text-right">
                                        @if ($row['promo'])
                                            <span class="inline-flex rounded-full bg-[#DDF5E6] px-2.5 py-0.5 text-[11px] font-medium text-[#22A95B]">Ya</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-[#F4F4F3] px-2.5 py-0.5 text-[11px] font-medium text-[#6B6B6B]">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <button
                                            type="button"
                                            data-detail-open
                                            class="inline-flex items-center gap-1.5 rounded-full border border-[#EAEAEA] bg-white px-3 py-1.5 text-[12px] font-medium text-[#111111] transition hover:border-[#1A1A1A] hover:bg-[#F4F4F3]"
                                        >
                                            <svg class="size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p data-pelanggan-empty class="hidden px-6 py-8 text-center text-[13px] text-[#6B6B6B]">
                    Tidak ada pelanggan yang sesuai dengan pencarian atau filter.
                </p>
            </section>
        </div>

        {{-- TAB 2: TAGIHAN --}}
        <div data-tab-panel="tagihan" class="hidden space-y-4">
            <section class="flex flex-col gap-3 rounded-[14px] border border-[#EAEAEA] bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-2 text-[12px]">
                    <span class="inline-flex items-center rounded-full bg-[#DDF5E6] px-3 py-1 font-medium text-[#22A95B]">{{ $totalLunas }} Lunas</span>
                    <span class="inline-flex items-center rounded-full bg-[#FBE3E1] px-3 py-1 font-medium text-[#D9453D]">{{ $totalBelum }} Belum Lunas</span>
                </div>

                <label class="relative inline-flex items-center self-start sm:self-auto">
                    <select
                        data-tagihan-status
                        aria-label="Filter status bayar"
                        class="appearance-none rounded-full border border-[#EAEAEA] bg-white py-2 pl-4 pr-9 text-[13px] font-medium text-[#111111] outline-none transition hover:border-[#D4D4D2] focus:border-[#1A1A1A]"
                    >
                        <option value="semua" selected>Semua Status</option>
                        <option value="lunas">Sudah Lunas</option>
                        <option value="belum">Belum Lunas</option>
                    </select>
                    <svg class="pointer-events-none absolute right-3.5 size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </label>
            </section>

            <section class="overflow-hidden rounded-[14px] border border-[#EAEAEA] bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px] text-left text-[13px]">
                        <thead class="border-b border-[#EAEAEA] bg-[#F4F4F3]/60 text-[12px] font-medium text-[#6B6B6B]">
                            <tr>
                                <th class="px-6 py-3.5">IDPEL</th>
                                <th class="px-4 py-3.5">Nama</th>
                                <th class="px-4 py-3.5">Periode</th>
                                <th class="px-4 py-3.5 text-right">Total</th>
                                <th class="px-4 py-3.5 text-center">Status Bayar</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EAEAEA]">
                            @foreach ($tagihanList as $row)
                                @php($p = $pelangganById[$row['idpel']] ?? null)
                                <tr
                                    data-tagihan-row
                                    data-idpel="{{ $row['idpel'] }}"
                                    data-nama="{{ $row['nama'] }}"
                                    data-alamat="{{ $p['alamat'] ?? '-' }}"
                                    data-tarif="{{ $p['tarif'] ?? '-' }}"
                                    data-daya="{{ $p['daya'] ?? '-' }}"
                                    data-hp="{{ $p['hp'] ?? '-' }}"
                                    data-promo="{{ ($p['promo'] ?? false) ? 'Ya' : 'Tidak' }}"
                                    data-periode="{{ $row['periode'] }}"
                                    data-total="{{ $row['total'] }}"
                                    data-status="{{ $row['status'] }}"
                                    data-lat="{{ $p['lat'] ?? '' }}"
                                    data-lng="{{ $p['lng'] ?? '' }}"
                                    class="transition hover:bg-[#F4F4F3]/40"
                                >
                                    <td class="px-6 py-3.5 font-mono tabular-nums text-[#111111]">{{ $row['idpel'] }}</td>
                                    <td class="px-4 py-3.5 font-medium text-[#111111]">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3.5 text-[#6B6B6B]">{{ $row['periode'] }}</td>
                                    <td class="px-4 py-3.5 text-right font-mono tabular-nums text-[#111111]">Rp{{ number_format($row['total'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3.5 text-center">
                                        @if ($row['status'] === 'lunas')
                                            <span data-status-badge class="inline-flex rounded-full bg-[#DDF5E6] px-2.5 py-0.5 text-[11px] font-medium text-[#22A95B]">Lunas</span>
                                        @else
                                            <span data-status-badge class="inline-flex rounded-full bg-[#FBE3E1] px-2.5 py-0.5 text-[11px] font-medium text-[#D9453D]">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5 text-right">
                                        <button
                                            type="button"
                                            data-detail-open
                                            class="inline-flex items-center gap-1.5 rounded-full border border-[#EAEAEA] bg-white px-3 py-1.5 text-[12px] font-medium text-[#111111] transition hover:border-[#1A1A1A] hover:bg-[#F4F4F3]"
                                        >
                                            <svg class="size-3.5 text-[#6B6B6B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        {{-- Modal Detail Pelanggan --}}
        <div data-detail-modal class="fixed inset-0 z-[60] hidden" role="dialog" aria-modal="true" aria-labelledby="detail-pelanggan-title">
            <div class="absolute inset-0 bg-[#111111]/25 backdrop-blur-[2px]" data-detail-close aria-hidden="true"></div>

            <div class="relative flex min-h-full items-center justify-center p-4">
                <div class="w-full max-w-2xl overflow-hidden rounded-[14px] border border-[#EAEAEA] bg-white">
                    <div class="flex items-start justify-between gap-3 border-b border-[#EAEAEA] px-6 py-4">
                        <div>
                            <h2 id="detail-pelanggan-title" class="text-[15px] font-semibold text-[#111111]">Detail Pelanggan</h2>
                            <p class="mt-0.5 text-[12px] text-[#6B6B6B]">Informasi pelanggan dan status tagihan periode ini.</p>
                        </div>
                        <button
                            type="button"
                            data-detail-close
                            class="inline-flex size-7 shrink-0 items-center justify-center rounded-full text-[#6B6B6B] transition hover:bg-[#F4F4F3] hover:text-[#111111]"
                            aria-label="Tutup detail"
                        >
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <span data-detail-initial class="flex size-11 shrink-0 items-center justify-center rounded-full bg-[#F4F4F3] text-[15px] font-semibold text-[#111111]">A</span>
                            <div class="min-w-0">
                                <p data-detail-nama class="truncate text-[15px] font-semibold text-[#111111]">-</p>
                                <p data-detail-idpel class="truncate font-mono text-[12px] tabular-nums text-[#6B6B6B]">-</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <dl class="grid content-start gap-y-3 text-[13px]">
                                <div>
                                    <dt class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Alamat</dt>
                                    <dd data-detail-alamat class="mt-0.5 text-[#111111]">-</dd>
                                </div>
                                <div>
                                    <dt class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Tarif / Daya</dt>
                                    <dd data-detail-tarifdaya class="mt-0.5 text-[#111111]">-</dd>
                                </div>
                                <div>
                                    <dt class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">No HP</dt>
                                    <dd data-detail-hp class="mt-0.5 font-mono tabular-nums text-[#111111]">-</dd>
                                </div>
                                <div class="grid grid-cols-2 gap-x-4">
                                    <div>
                                        <dt class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Terima Promo</dt>
                                        <dd data-detail-promo class="mt-0.5 text-[#111111]">-</dd>
                                    </div>
                                    <div>
                                        <dt class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Periode</dt>
                                        <dd data-detail-periode class="mt-0.5 text-[#111111]">-</dd>
                                    </div>
                                </div>
                            </dl>

                            <div>
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Lokasi Pelanggan</p>
                                    <p data-detail-coords class="font-mono text-[11px] tabular-nums text-[#6B6B6B]">-</p>
                                </div>
                                <div class="mt-2 overflow-hidden rounded-[10px] border border-[#EAEAEA] bg-[#F4F4F3]">
                                    <iframe
                                        data-detail-map
                                        title="Peta lokasi pelanggan"
                                        class="h-40 w-full border-0"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                    ></iframe>
                                </div>
                                <a
                                    data-detail-map-link
                                    href="#"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-2 inline-flex items-center gap-1.5 text-[12px] font-medium text-[#111111] transition hover:text-[#22A95B]"
                                >
                                    Buka di peta
                                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M15 3h6v6"/>
                                        <path d="M10 14 21 3"/>
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="mt-5 rounded-[10px] border border-[#EAEAEA] bg-[#F4F4F3]/50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[11px] uppercase tracking-wide text-[#6B6B6B]">Total Tagihan</p>
                                    <p data-detail-total class="mt-1 font-mono text-[20px] font-semibold tabular-nums text-[#111111]">Rp0</p>
                                </div>
                                <span data-detail-badge class="inline-flex rounded-full bg-[#FBE3E1] px-3 py-1 text-[11px] font-medium text-[#D9453D]">Belum Lunas</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 border-t border-[#EAEAEA] px-6 py-4">
                        <button
                            type="button"
                            data-detail-close
                            class="rounded-full border border-[#EAEAEA] bg-white px-4 py-2 text-[13px] font-medium text-[#111111] transition hover:bg-[#F4F4F3]"
                        >
                            Tutup
                        </button>
                        <button
                            type="button"
                            data-detail-toggle
                            class="rounded-full bg-[#1A1A1A] px-4 py-2 text-[13px] font-medium text-white transition hover:bg-[#111111]"
                        >
                            Tandai Lunas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
