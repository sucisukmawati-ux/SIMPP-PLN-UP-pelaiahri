<x-pelanggan-layout title="Detail Pelanggan">
    <div class="mb-4 flex items-center justify-between gap-3">
        <a href="{{ route('pelanggan.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-700 hover:text-blue-900">
            <span aria-hidden="true">←</span> Kembali ke Data Pelanggan
        </a>
        <span class="{{ $pelanggan->status === 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-200 text-slate-700' }} rounded-full px-3 py-1 text-xs font-bold">{{ ucfirst($pelanggan->status) }}</span>
    </div>

    @if (session('status'))
        <div role="status" class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

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

    <div class="grid gap-4 xl:grid-cols-[minmax(0,1.3fr)_minmax(280px,.7fr)]">
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5">
                <p class="text-xs font-medium text-slate-500">ID Pelanggan {{ $pelanggan->id_pelanggan }}</p>
                <h2 class="mt-1 text-lg font-bold text-slate-900">{{ $pelanggan->nama ?: 'Nama belum dilengkapi' }}</h2>
            </div>
            <form id="customer-update-form" action="{{ route('pelanggan.update', $pelanggan) }}" method="post">
                @csrf
                @method('PUT')
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        ID Pelanggan *
                        <input name="id_pelanggan" value="{{ old('id_pelanggan', $pelanggan->id_pelanggan) }}" required maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Nama Pelanggan *
                        <input name="nama" value="{{ old('nama', $pelanggan->nama) }}" required maxlength="160" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Petugas
                        <input name="petugas" value="{{ old('petugas', $pelanggan->petugas) }}" maxlength="160" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Unit *
                        <input name="unit" value="{{ old('unit', $pelanggan->unit) }}" required maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Nomor Telepon
                        <input name="nomor_telepon" value="{{ old('nomor_telepon', $pelanggan->nomor_telepon) }}" maxlength="32" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Status
                        <select name="status" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                            <option value="aktif" @selected(old('status', $pelanggan->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $pelanggan->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600 sm:col-span-2">
                        Alamat
                        <textarea name="alamat" rows="3" maxlength="2000" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Latitude
                        <input name="latitude" type="number" step="any" min="-90" max="90" value="{{ old('latitude', $pelanggan->latitude) }}" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                    <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                        Longitude
                        <input name="longitude" type="number" step="any" min="-180" max="180" value="{{ old('longitude', $pelanggan->longitude) }}" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/15">
                    </label>
                </div>
            </form>
            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                <form action="{{ route('pelanggan.destroy', $pelanggan) }}" method="post" onsubmit="return confirm('Hapus data pelanggan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg border border-red-200 px-4 py-2.5 text-xs font-bold text-red-700 transition hover:bg-red-50">Hapus Pelanggan</button>
                </form>
                <button type="submit" form="customer-update-form" class="rounded-lg bg-blue-700 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-blue-800">Simpan Perubahan</button>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-bold text-slate-900">Lokasi Pelanggan</h2>
            <p class="mt-1 text-xs text-slate-500">Informasi alamat dan koordinat pelanggan.</p>
            <div class="mt-4 rounded-lg bg-slate-50 p-4">
                <p class="text-xs font-semibold text-slate-500">Alamat</p>
                <p class="mt-1 text-sm text-slate-800">{{ $pelanggan->alamat ?: 'Alamat belum diisi.' }}</p>
                <p class="mt-4 text-xs font-semibold text-slate-500">Koordinat</p>
                <p class="mt-1 text-sm text-slate-800">
                    @if ($pelanggan->latitude !== null && $pelanggan->longitude !== null)
                        {{ $pelanggan->latitude }}, {{ $pelanggan->longitude }}
                    @else
                        Lokasi belum ditentukan.
                    @endif
                </p>
            </div>
        </section>
    </div>
</x-pelanggan-layout>
