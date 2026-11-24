<x-pelanggan-layout title="Import Pelanggan">
    <div class="mb-4">
        <a href="{{ route('pelanggan.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900">← Kembali ke menu Data Pelanggan</a>
    </div>

    @if (session('status'))
        <div role="status" class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="text-center">
            <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-blue-50 text-blue-700">
                <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 16V4M7 9l5-5 5 5M5 20h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <h2 class="mt-4 text-sm font-bold text-slate-900">Import Data dari Excel atau CSV</h2>
            <p class="mt-1 text-xs text-slate-500">Maksimal 5.000 baris dan ukuran file 10 MB.</p>
        </div>

        <div class="mt-5 rounded-lg bg-slate-50 p-4 text-xs text-slate-600">
            <p class="font-bold text-slate-800">Workbook pelanggan (.xlsx):</p>
            <code class="mt-1 block break-all text-[0.7rem]">PETUGAS, IDPEL, NOMOR HP, X, Y</code>
            <p class="mt-2">Nama pelanggan dibiarkan kosong untuk dilengkapi nanti. PETUGAS disimpan terpisah; X menjadi latitude dan Y longitude.</p>
            <p class="mt-2">Kolom tanggal antar dan status penagihan tidak diimpor. Status pelanggan baru mengikuti nilai default Aktif.</p>
            <p class="mt-3 font-bold text-slate-800">CSV (.csv) tetap memakai header:</p>
            <code class="mt-1 block break-all text-[0.7rem]">id_pelanggan,nama,petugas,unit,nomor_telepon,alamat,latitude,longitude,status</code>
            <p class="mt-2 text-[0.68rem] text-slate-500">ID pelanggan yang sudah ada atau duplikat dalam file akan menolak seluruh proses import.</p>
        </div>

        <form action="{{ route('pelanggan.import') }}" method="post" enctype="multipart/form-data" class="mt-5 grid gap-4">
            @csrf
            <label class="grid gap-1.5 text-xs font-semibold text-slate-600">
                File Excel atau CSV
                <input type="file" name="file" accept=".xlsx,.csv,text/csv" required class="block w-full rounded-lg border border-slate-200 text-xs text-slate-600 file:mr-3 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-slate-700">
            </label>
            <button type="submit" class="w-full rounded-lg bg-blue-700 px-4 py-3 text-xs font-bold text-white transition hover:bg-blue-800">Mulai Import</button>
        </form>
    </section>
</x-pelanggan-layout>
