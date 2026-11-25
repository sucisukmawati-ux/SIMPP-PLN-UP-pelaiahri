<x-layouts.guest>
    <main class="flex min-h-screen items-center justify-center bg-[#071b2b] px-4 py-8 text-slate-900">
        <section class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl">
            <h1 class="text-2xl font-bold">Verifikasi email</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Verifikasi email Anda sebelum melanjutkan. Gunakan tombol di bawah untuk mengirim ulang tautan verifikasi.
            </p>
            @if (session('status'))
                <p role="status" class="mt-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">{{ session('status') }}</p>
            @endif
            <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
                @csrf
                <x-ui.primary-button type="submit" class="w-full">Kirim ulang tautan verifikasi</x-ui.primary-button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <x-ui.primary-button type="submit" class="w-full">Keluar</x-ui.primary-button>
            </form>
        </section>
    </main>
</x-layouts.guest>
