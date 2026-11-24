<x-pelanggan-layout title="Data Pelanggan">
    @if (session('status'))
        <div role="status" class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Pelanggan</h2>
                <p class="mt-1 text-xs text-slate-500">Cari, tambah, dan pilih pelanggan untuk melihat detail serta CRUD.</p>
            </div>
            <details @if ($errors->any()) open @endif>
                <summary class="cursor-pointer list-none rounded-lg bg-blue-700 px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-800">
                    + Tambah Pelanggan
                </summary>
                <div class="fixed inset-0 z-40 flex items-center justify-center bg-slate-950/50 p-4" onclick="if (event.target === this) this.closest('details').open = false">
                    <form action="{{ route('pelanggan.store') }}" method="post" class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-5 shadow-2xl sm:p-6">
                        @csrf
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Tambah Pelanggan</h3>
                                <p class="mt-1 text-xs text-slate-500">Isi data pelanggan baru.</p>
                            </div>
                            <button type="button" onclick="this.closest('details').open = false" class="rounded-lg px-2 py-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">✕</button>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
                                <ul class="mt-1 list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                ID Pelanggan *
                                <input name="id_pelanggan" value="{{ old('id_pelanggan') }}" required maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Nama Pelanggan *
                                <input name="nama" value="{{ old('nama') }}" required maxlength="160" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Petugas
                                <input name="petugas" value="{{ old('petugas') }}" maxlength="160" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Unit *
                                <input name="unit" value="{{ old('unit', '22140') }}" required maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Nomor Telepon
                                <input name="nomor_telepon" value="{{ old('nomor_telepon') }}" maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Status
                                <select name="status" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                                    <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                    <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                                </select>
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600 sm:col-span-2">
                                Alamat
                                <textarea name="alamat" rows="2" maxlength="2000" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">{{ old('alamat') }}</textarea>
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Latitude
                                <input name="latitude" type="number" step="any" min="-90" max="90" value="{{ old('latitude') }}" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                                Longitude
                                <input name="longitude" type="number" step="any" min="-180" max="180" value="{{ old('longitude') }}" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            </label>
                        </div>
                        <div class="mt-5 flex justify-end gap-2">
                            <button type="button" onclick="this.closest('details').open = false" class="rounded-lg border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">Batal</button>
                            <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-800">Simpan Pelanggan</button>
                        </div>
                    </form>
                </div>
            </details>
        </div>

        <form action="{{ route('pelanggan.index') }}" method="get" class="flex flex-wrap gap-2 border-b border-slate-100 px-5 py-3">
            <label class="sr-only" for="customer-search">Cari pelanggan</label>
            <input id="customer-search" type="search" name="search" value="{{ $search }}" placeholder="Cari ID, nama, petugas, atau nomor telepon..." class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-800 outline-none placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/15">
            <button type="submit" class="rounded-lg border border-slate-200 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">Cari</button>
            @if ($search)
                <a href="{{ route('pelanggan.index') }}" class="rounded-lg px-3 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-100">Reset</a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[840px] text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Unit</th>
                        <th class="px-3 py-3 font-semibold">ID Pelanggan</th>
                        <th class="px-3 py-3 font-semibold">Nama Pelanggan</th>
                        <th class="px-3 py-3 font-semibold">Petugas</th>
                        <th class="px-3 py-3 font-semibold">Telepon</th>
                        <th class="px-3 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelangganList as $customer)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-500">{{ $customer->unit }}</td>
                            <td class="px-3 py-3 font-bold text-slate-800">{{ $customer->id_pelanggan }}</td>
                            <td class="px-3 py-3 font-medium text-slate-700">{{ $customer->nama ?: 'Nama belum dilengkapi' }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $customer->petugas ?: '—' }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $customer->nomor_telepon ?: '—' }}</td>
                            <td class="px-3 py-3">
                                <span class="{{ $customer->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} rounded-full px-2 py-1 font-bold">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('pelanggan.show', $customer) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 font-bold text-blue-700 hover:bg-blue-50">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <p class="text-sm font-semibold text-slate-700">{{ $search ? 'Pelanggan tidak ditemukan.' : 'Belum ada data pelanggan.' }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $search ? 'Coba kata kunci yang berbeda.' : 'Tambahkan pelanggan untuk mulai mengelola datanya.' }}</p>
                            </td>
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
