<x-layouts.guest>
    <div class="relative isolate min-h-screen overflow-hidden bg-[#071b2b] text-white">
        <div class="pointer-events-none absolute -left-40 -top-40 size-[30rem] rounded-full bg-blue-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-52 left-1/4 size-[34rem] rounded-full bg-sky-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-36 top-1/4 size-[28rem] rounded-full bg-blue-500/10 blur-3xl"></div>

        <main class="relative mx-auto grid min-h-screen w-full max-w-6xl grid-cols-1 items-center gap-8 px-3 py-4 sm:px-6 lg:gap-10 lg:px-8 lg:py-6">

            <section aria-labelledby="login-heading" class="mx-auto w-full max-w-sm rounded-3xl bg-white p-4 text-slate-900 shadow-2xl shadow-black/25 sm:p-6">
                <div class="flex size-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                    </svg>
                </div>

                <p class="mt-5 text-sm font-semibold text-blue-700">Selamat datang</p>
                <h2 id="login-heading" class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Masuk ke SIMPP</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Masukkan email dan kata sandi akun petugas Anda.
                </p>

                @if (session('status'))
                    <p role="status" class="mt-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">{{ session('status') }}</p>
                @endif

                @auth
                    <div class="mt-6 grid gap-4">
                        @if (! auth()->user()->hasVerifiedEmail())
                            <p class="text-sm leading-6 text-slate-600">
                                Verifikasi alamat email Anda sebelum menggunakan sistem.
                            </p>
                            <a href="{{ route('verification.notice') }}" class="text-sm font-semibold text-blue-700 underline">
                                Buka halaman verifikasi
                            </a>
                        @else
                            <p class="text-sm leading-6 text-slate-600">
                                Anda masuk sebagai {{ auth()->user()->name }}.
                            </p>
                            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-700 underline">
                                Buka dashboard
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.primary-button type="submit" class="w-full">
                                Keluar
                            </x-ui.primary-button>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('login.store') }}" class="mt-6 grid gap-2">
                        @csrf
                        <x-ui.text-field
                            label="Alamat email"
                            name="email"
                            type="email"
                            placeholder="nama@contoh.com"
                            autocomplete="username"
                            required
                            autofocus
                        />
                        @error('email')
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        @enderror
                        <x-ui.text-field
                            label="Kata sandi"
                            name="password"
                            type="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        />
                        @error('password')
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        @enderror
                        <label class="mt-2 flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            Ingat saya di perangkat ini
                        </label>
                        <x-ui.primary-button type="submit" class="mt-1 w-full">
                            Masuk ke sistem
                        </x-ui.primary-button>
                    </form>
                    <a href="{{ route('password.request') }}" class="mt-4 inline-block text-sm font-semibold text-blue-700 underline">
                        Lupa kata sandi?
                    </a>
                @endauth
            </section>
        </main>
    </div>
</x-layouts.guest>
