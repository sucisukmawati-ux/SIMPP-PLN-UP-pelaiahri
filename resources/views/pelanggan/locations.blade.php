<x-pelanggan-layout title="Lokasi Pelanggan">
    <div class="mb-4">
        <a href="{{ route('pelanggan.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900">← Kembali ke menu Data Pelanggan</a>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-sm font-bold text-slate-900">Lokasi Pelanggan</h2>
            <p class="mt-1 text-xs text-slate-500">Alamat dan koordinat berdasarkan data pelanggan yang tersimpan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">ID Pelanggan</th>
                        <th class="px-3 py-3 font-semibold">Nama</th>
                        <th class="px-3 py-3 font-semibold">Alamat</th>
                        <th class="px-3 py-3 font-semibold">Koordinat</th>
                        <th class="px-5 py-3 text-right font-semibold">Peta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelangganList as $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $customer->id_pelanggan }}</td>
                            <td class="px-3 py-3 text-slate-700">{{ $customer->nama ?: 'Nama belum dilengkapi' }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $customer->alamat ?: 'Alamat belum diisi' }}</td>
                            <td class="px-3 py-3 text-slate-500">
                                @if ($customer->latitude !== null && $customer->longitude !== null)
                                    {{ $customer->latitude }}, {{ $customer->longitude }}
                                @else
                                    Belum ditentukan
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                @if ($customer->latitude !== null && $customer->longitude !== null)
                                    <a href="https://www.google.com/maps?q={{ $customer->latitude }},{{ $customer->longitude }}" target="_blank" rel="noopener noreferrer" class="font-bold text-blue-700 hover:text-blue-900">Buka Peta</a>
                                @else
                                    <a href="{{ route('pelanggan.show', $customer) }}" class="font-bold text-blue-700 hover:text-blue-900">Atur lokasi</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-500">Belum ada data pelanggan. Tambahkan pelanggan terlebih dahulu.</td>
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
