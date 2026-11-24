<x-pelanggan-layout title="Kirim Notifikasi Penagihan">
    <div class="mb-4">
        <a href="{{ route('pelanggan.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900">← Kembali ke menu Data Pelanggan</a>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-sm font-bold text-slate-900">Pengingat Tagihan melalui WhatsApp</h2>
            <p class="mt-1 text-xs text-slate-500">Pelanggan aktif dengan nomor telepon terdaftar.</p>
        </div>

        <div class="border-b border-blue-100 bg-blue-50 px-5 py-3 text-xs leading-5 text-blue-800">
            Tombol kirim akan membuka WhatsApp dengan pesan yang sudah disiapkan. Pesan hanya terkirim setelah Anda menekan tombol kirim di WhatsApp.
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">ID Pelanggan</th>
                        <th class="px-3 py-3 font-semibold">Nama</th>
                        <th class="px-3 py-3 font-semibold">Nomor WhatsApp</th>
                        <th class="px-3 py-3 font-semibold">Periode</th>
                        <th class="px-5 py-3 text-right font-semibold">Kirim melalui WhatsApp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelangganList as $customer)
                        @php
                            $phone = preg_replace('/\D+/', '', (string) $customer->nomor_telepon);
                            $phone = str_starts_with($phone, '0') ? '62'.substr($phone, 1) : $phone;
                            $message = 'Yth. '.($customer->nama ?: 'Pelanggan').', tagihan listrik periode '.now()->format('m/Y').' untuk ID pelanggan '.$customer->id_pelanggan.' telah tersedia. Mohon melakukan pembayaran. Jika sudah membayar, abaikan pesan ini. Terima kasih.';
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $customer->id_pelanggan }}</td>
                            <td class="px-3 py-3 text-slate-700">{{ $customer->nama ?: 'Nama belum dilengkapi' }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $customer->nomor_telepon }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ now()->format('m/Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="https://wa.me/{{ $phone }}?text={{ rawurlencode($message) }}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-emerald-600 px-3 py-1.5 font-bold text-white hover:bg-emerald-700">Buka WhatsApp</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-500">Belum ada pelanggan aktif dengan nomor telepon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pelangganList->hasPages())
            <div class="border-t border-slate-100 px-5 py-3">
                {{ $pelangganList->links() }}
            </div>
        @endif
    </section>
</x-pelanggan-layout>
