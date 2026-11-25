<x-layouts.guest>
    <main class="flex min-h-screen items-center justify-center bg-[#071b2b] px-4 py-8 text-slate-900">
        <section class="w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl">
            <h1 class="text-2xl font-bold">Buat kata sandi baru</h1>
            <form method="POST" action="{{ route('password.update') }}" class="mt-6 grid gap-3">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <x-ui.text-field label="Alamat email" name="email" type="email" autocomplete="email" value="{{ $email }}" required autofocus />
                @error('email')
                    <p class="text-sm text-red-700">{{ $message }}</p>
                @enderror
                <x-ui.text-field label="Kata sandi baru" name="password" type="password" autocomplete="new-password" required />
                @error('password')
                    <p class="text-sm text-red-700">{{ $message }}</p>
                @enderror
                <x-ui.text-field label="Konfirmasi kata sandi" name="password_confirmation" type="password" autocomplete="new-password" required />
                <p class="text-xs leading-5 text-slate-500">Gunakan minimal 12 karakter dengan huruf besar, huruf kecil, angka, dan simbol.</p>
                <x-ui.primary-button type="submit" class="mt-2 w-full">Simpan kata sandi</x-ui.primary-button>
            </form>
        </section>
    </main>
</x-layouts.guest>
