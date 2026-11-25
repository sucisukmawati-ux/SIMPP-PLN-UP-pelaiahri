<x-layouts.guest>
    <main class="flex min-h-screen items-center justify-center bg-[#071b2b] px-4 py-8 text-slate-900">
        <section class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl">
            <h1 class="text-2xl font-bold">Reset kata sandi</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Masukkan email akun Anda. Jika cocok, kami akan mengirimkan tautan untuk membuat kata sandi baru.
            </p>
            @if (session('status'))
                <p role="status" class="mt-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">{{ session('status') }}</p>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="mt-6 grid gap-3">
                @csrf
                <x-ui.text-field label="Alamat email" name="email" type="email" autocomplete="email" required autofocus />
                @error('email')
                    <p class="text-sm text-red-700">{{ $message }}</p>
                @enderror
                <x-ui.primary-button type="submit" class="mt-2 w-full">Kirim tautan reset</x-ui.primary-button>
            </form>
            <a href="{{ route('login') }}" class="mt-5 inline-block text-sm font-semibold text-blue-700 underline">Kembali ke halaman masuk</a>
        </section>
    </main>
</x-layouts.guest>
