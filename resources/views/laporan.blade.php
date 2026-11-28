<x-app-layout title="Laporan & Statistik" section="Laporan" active="laporan">
    @php
        $rekapWilayah = [
            ['kecamatan' => 'Pelaihari', 'pelanggan' => 3_842, 'tagihan' => 3_096, 'lunas' => 2_468, 'tunggakan' => 251_300_000],
            ['kecamatan' => 'Takisung', 'pelanggan' => 1_486, 'tagihan' => 1_204, 'lunas' => 968, 'tunggakan' => 98_450_000],
            ['kecamatan' => 'Batu Ampar', 'pelanggan' => 1_724, 'tagihan' => 1_385, 'lunas' => 1_073, 'tunggakan' => 142_800_000],
            ['kecamatan' => 'Tambang Ulang', 'pelanggan' => 1_268, 'tagihan' => 1_012, 'lunas' => 806, 'tunggakan' => 87_250_000],
            ['kecamatan' => 'Kurau', 'pelanggan' => 1_105, 'tagihan' => 889, 'lunas' => 701, 'tunggakan' => 76_400_000],
            ['kecamatan' => 'Bati-Bati', 'pelanggan' => 1_452, 'tagihan' => 1_188, 'lunas' => 924, 'tunggakan' => 118_700_000],
            ['kecamatan' => 'Panyipatan', 'pelanggan' => 873, 'tagihan' => 664, 'lunas' => 511, 'tunggakan' => 61_350_000],
            ['kecamatan' => 'Jorong', 'pelanggan' => 730, 'tagihan' => 422, 'lunas' => 310, 'tunggakan' => 44_150_000],
        ];
        $totalPelanggan = array_sum(array_column($rekapWilayah, 'pelanggan'));
        $totalTagihan = array_sum(array_column($rekapWilayah, 'tagihan'));
        $totalLunas = array_sum(array_column($rekapWilayah, 'lunas'));
        $totalBelum = $totalTagihan - $totalLunas;
        $totalTunggakan = array_sum(array_column($rekapWilayah, 'tunggakan'));
        $nominalTagihan = 3_842_500_000;
        $nominalTerbayar = $nominalTagihan - $totalTunggakan;
        $rasioLunas = $totalTagihan > 0 ? round($totalLunas / $totalTagihan * 100, 1) : 0;

        $rekapKampanye = [
            ['nama' => 'Pengingat Tagihan November', 'periode' => 'Nov 2026', 'total' => 4_215, 'terkirim' => 4_120, 'gagal' => 95],
            ['nama' => 'Sosialisasi Penyesuaian Tarif', 'periode' => 'Nov 2026', 'total' => 2_980, 'terkirim' => 2_913, 'gagal' => 67],
            ['nama' => 'Konfirmasi Baca Meter', 'periode' => 'Nov 2026', 'total' => 1_137, 'terkirim' => 1_000, 'gagal' => 137],
            ['nama' => 'Info Pemeliharaan Gardu', 'periode' => 'Nov 2026', 'total' => 320, 'terkirim' => 302, 'gagal' => 18],
            ['nama' => 'Gangguan Jaringan Kintap', 'periode' => 'Nov 2026', 'total' => 642, 'terkirim' => 601, 'gagal' => 41],
        ];
        $totalPesan = array_sum(array_column($rekapKampanye, 'total'));
        $totalTerkirim = array_sum(array_column($rekapKampanye, 'terkirim'));
        $totalGagal = array_sum(array_column($rekapKampanye, 'gagal'));
        $rasioTerkirim = $totalPesan > 0 ? round($totalTerkirim / $totalPesan * 100, 1) : 0;
    @endphp

    <div class="space-y-4">
        <div class="hidden print:block">
            <div class="border-b-2 border-slate-900 pb-3">
                <h1 class="text-lg font-bold text-slate-900">Laporan Operasional SIMPP</h1>
                <p class="mt-1 text-xs text-slate-700">PLN UP Pelaihari — Unit 22140</p>
                <p class="text-xs text-slate-700">Periode November 2026 · Dicetak {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 print:hidden">
            <p class="text-xs font-medium text-slate-500">Data per November 2026 · Unit 22140 — ULP Pelaihari</p>
            <div class="flex flex-wrap gap-2">
                <button type="button" data-print class="inline-flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-xs font-bold text-slate-700 transition hover:bg-slate-50">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v11.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Cetak Laporan
                </button>
                <button type="button" data-export="tabel-rekap-wilayah" data-filename="laporan-rekap-tagihan" class="inline-flex h-10 items-center gap-2 rounded-lg bg-blue-700 px-4 text-xs font-bold text-white transition hover:bg-blue-800">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Ekspor CSV
                </button>
            </div>
        </div>

        <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm print:hidden">
            <form action="{{ route('laporan') }}" method="get" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                    Periode
                    <select name="periode" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                        <option value="202611" selected>November 2026</option>
                        <option value="202610">Oktober 2026</option>
                        <option value="202609">September 2026</option>
                        <option value="202608">Agustus 2026</option>
                    </select>
                </label>
                <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                    Unit
                    <select name="unit" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                        <option value="22140" selected>22140 — ULP Pelaihari</option>
                        <option value="22141">22141 — ULP Kintap</option>
                        <option value="22142">22142 — ULP Batu Ampar</option>
                    </select>
                </label>
                <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                    Kecamatan
                    <select name="kecamatan" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                        <option value="" selected>Semua Kecamatan</option>
                        @foreach ($rekapWilayah as $wilayah)
                            <option value="{{ $wilayah['kecamatan'] }}">{{ $wilayah['kecamatan'] }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="flex items-end">
                    <button type="submit" class="h-[42px] w-full rounded-lg bg-[#071b2b] px-4 text-xs font-bold text-white transition hover:bg-slate-800">Terapkan Filter</button>
                </div>
            </form>
        </section>

        <section class="grid gap-4 md:grid-cols-3" aria-label="Statistik ringkas">
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm print:break-inside-avoid">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Pelanggan</h2>
                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[0.6rem] font-bold text-blue-700">Total</span>
                </div>
                <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ number_format($totalPelanggan, 0, ',', '.') }}</p>
                <dl class="mt-4 space-y-2 border-t border-slate-100 pt-3 text-xs">
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Aktif</dt><dd class="font-bold text-slate-800">11.932</dd></div>
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Nonaktif</dt><dd class="font-bold text-slate-800">548</dd></div>
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Baru bulan ini</dt><dd class="font-bold text-emerald-700">+284</dd></div>
                </dl>
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm print:break-inside-avoid">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Tagihan</h2>
                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[0.6rem] font-bold text-amber-700">November</span>
                </div>
                <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Rp {{ number_format($nominalTagihan, 0, ',', '.') }}</p>
                <dl class="mt-4 space-y-2 border-t border-slate-100 pt-3 text-xs">
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Terbayar · {{ number_format($totalLunas, 0, ',', '.') }} tagihan</dt><dd class="font-bold text-emerald-700">Rp {{ number_format($nominalTerbayar, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Tunggakan · {{ number_format($totalBelum, 0, ',', '.') }} tagihan</dt><dd class="font-bold text-rose-700">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</dd></div>
                </dl>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-[0.65rem] font-semibold text-slate-500">
                        <span>Rasio pelunasan</span><span>{{ number_format($rasioLunas, 1, ',', '.') }}%</span>
                    </div>
                    <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $rasioLunas }}%"></div>
                    </div>
                </div>
            </article>

            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm print:break-inside-avoid">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Pesan WhatsApp</h2>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[0.6rem] font-bold text-emerald-700">{{ count($rekapKampanye) }} kampanye</span>
                </div>
                <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ number_format($totalTerkirim, 0, ',', '.') }}</p>
                <dl class="mt-4 space-y-2 border-t border-slate-100 pt-3 text-xs">
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Total pesan</dt><dd class="font-bold text-slate-800">{{ number_format($totalPesan, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Gagal</dt><dd class="font-bold text-rose-700">{{ number_format($totalGagal, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between gap-2"><dt class="text-slate-500">Keberhasilan</dt><dd class="font-bold text-emerald-700">{{ number_format($rasioTerkirim, 1, ',', '.') }}%</dd></div>
                </dl>
                <div class="mt-4">
                    <div class="h-1.5 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $rasioTerkirim }}%"></div>
                    </div>
                </div>
            </article>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white shadow-sm print:break-inside-avoid">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-sm font-bold text-slate-900">Rekap Pelanggan & Tagihan per Kecamatan</h2>
                <p class="mt-1 text-xs text-slate-500">Jumlah pelanggan, tagihan terbit, pelunasan, dan nominal tunggakan.</p>
            </div>
            <div class="overflow-x-auto">
                <table id="tabel-rekap-wilayah" class="w-full min-w-[760px] text-left text-xs">
                    <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Kecamatan</th>
                            <th class="px-3 py-3 text-right font-semibold">Pelanggan</th>
                            <th class="px-3 py-3 text-right font-semibold">Tagihan</th>
                            <th class="px-3 py-3 text-right font-semibold">Lunas</th>
                            <th class="px-3 py-3 text-right font-semibold">Belum</th>
                            <th class="px-3 py-3 text-right font-semibold">Tunggakan</th>
                            <th class="px-5 py-3 font-semibold">% Lunas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($rekapWilayah as $wilayah)
                            @php($pct = $wilayah['tagihan'] > 0 ? round($wilayah['lunas'] / $wilayah['tagihan'] * 100, 1) : 0)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-5 py-3 font-bold text-slate-800">{{ $wilayah['kecamatan'] }}</td>
                                <td class="px-3 py-3 text-right text-slate-600">{{ number_format($wilayah['pelanggan'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right text-slate-600">{{ number_format($wilayah['tagihan'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right font-semibold text-emerald-700">{{ number_format($wilayah['lunas'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right font-semibold text-rose-700">{{ number_format($wilayah['tagihan'] - $wilayah['lunas'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right text-slate-600">Rp {{ number_format($wilayah['tunggakan'], 0, ',', '.') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="whitespace-nowrap font-semibold text-slate-600">{{ number_format($pct, 1, ',', '.') }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-slate-900 bg-slate-50 text-slate-900">
                        <tr>
                            <td class="px-5 py-3 font-bold">Total</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalPelanggan, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalTagihan, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalLunas, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalBelum, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 font-bold">{{ number_format($rasioLunas, 1, ',', '.') }}%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white shadow-sm print:break-inside-avoid">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Rekap Pengiriman Pesan per Kampanye</h2>
                    <p class="mt-1 text-xs text-slate-500">Status pengiriman WhatsApp untuk kampanye periode November 2026.</p>
                </div>
                <button type="button" data-export="tabel-rekap-kampanye" data-filename="laporan-rekap-pesan" class="inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-xs font-bold text-slate-700 transition hover:bg-slate-50 print:hidden">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Ekspor CSV
                </button>
            </div>
            <div class="overflow-x-auto">
                <table id="tabel-rekap-kampanye" class="w-full min-w-[700px] text-left text-xs">
                    <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Kampanye</th>
                            <th class="px-3 py-3 font-semibold">Periode</th>
                            <th class="px-3 py-3 text-right font-semibold">Total Pesan</th>
                            <th class="px-3 py-3 text-right font-semibold">Terkirim</th>
                            <th class="px-3 py-3 text-right font-semibold">Gagal</th>
                            <th class="px-5 py-3 font-semibold">Keberhasilan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($rekapKampanye as $kampanye)
                            @php($pct = $kampanye['total'] > 0 ? round($kampanye['terkirim'] / $kampanye['total'] * 100, 1) : 0)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium text-slate-700">{{ $kampanye['nama'] }}</td>
                                <td class="px-3 py-3 text-slate-500">{{ $kampanye['periode'] }}</td>
                                <td class="px-3 py-3 text-right text-slate-600">{{ number_format($kampanye['total'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right font-semibold text-emerald-700">{{ number_format($kampanye['terkirim'], 0, ',', '.') }}</td>
                                <td class="px-3 py-3 text-right font-semibold text-rose-700">{{ number_format($kampanye['gagal'], 0, ',', '.') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="whitespace-nowrap font-semibold text-slate-600">{{ number_format($pct, 1, ',', '.') }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-slate-900 bg-slate-50 text-slate-900">
                        <tr>
                            <td class="px-5 py-3 font-bold" colspan="2">Total</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalPesan, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalTerkirim, 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-right font-bold">{{ number_format($totalGagal, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 font-bold">{{ number_format($rasioTerkirim, 1, ',', '.') }}%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <p class="text-[0.68rem] text-slate-500 print:hidden">Data pada halaman ini masih berupa contoh tampilan; query database akan disambungkan pada tahap berikutnya.</p>
    </div>
</x-app-layout>
