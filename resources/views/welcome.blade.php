
<x-layouts.guest>
    <div class="relative isolate min-h-screen overflow-hidden bg-gradient-to-r from-blue-800 to-white text-white">

        <div class="pointer-events-none absolute -left-40 -top-40 size-[30rem] rounded-full bg-blue-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-52 left-1/4 size-[34rem] rounded-full bg-sky-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-36 top-1/4 size-[28rem] rounded-full bg-blue-500/10 blur-3xl"></div>

        <main class="relative mx-auto grid min-h-screen w-full max-w-6xl grid-cols-1 items-center gap-6 px-3 py-4 sm:px-6 lg:gap-8 lg:px-8 lg:py-6">

            <img
                src="../images/logo_login.png"
                alt="Logo Login"
                class="mx-auto w-32 sm:w-36 lg:w-50"
            >

            <section
                aria-labelledby="login-heading"
                class="mx-auto w-full max-w-sm rounded-xl bg-white p-4 text-slate-900  sm:px-6 sm:py-4"
            >

                @if (session('status'))
                    <p role="status" class="mt-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">
                        {{ session('status') }}
                    </p>
                @endif

                @auth
                    <div class="mt-4 grid gap-2">

                        @if (! auth()->user()->hasVerifiedEmail())
                            <p class="text-sm leading-6 text-slate-600">
                                Verifikasi alamat email Anda sebelum menggunakan sistem.
                            </p>

                            <a
                                href="{{ route('verification.notice') }}"
                                class="text-sm font-semibold text-blue-700 underline"
                            >
                                Buka halaman verifikasi
                            </a>
                        @else
                            <p class="text-sm leading-6 text-slate-600">
                                Anda masuk sebagai {{ auth()->user()->name }}.
                            </p>

                            <a
                                href="{{ route('dashboard') }}"
                                class="text-sm font-semibold text-blue-700 underline"
                            >
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

                    {{-- Login Form --}}
                    <form
                        method="POST"
                        action="{{ route('login.store') }}"
                        class="mt-4 grid gap-2"
                    >
                        @csrf

                        {{-- Nama Pengguna --}}
                        <x-ui.text-field
                            label="Nama Pengguna"
                            name="name"
                            type="name"
                            placeholder="Masukkan nama pengguna"
                            autocomplete="username"
                            required
                            autofocus
                        />

                        @error('name')
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        @enderror

                        {{-- Kata Sandi --}}
                        <div class="relative" data-password-field>

                            <x-ui.text-field
                                label="Kata sandi"
                                name="password"
                                type="password"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required
                            />

                            <button
                                type="button"
                                onclick="togglePasswordVisibility(this)"
                                class="absolute right-4 top-[calc(50%+16px)] z-10 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-md text-slate-400 transition-colors duration-200"
                                aria-label="Lihat kata sandi"
                                aria-pressed="false"
                                title="Lihat kata sandi"
                            >

                                <svg
                                    data-eye
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                <svg
                                    data-eye-off
                                    class="hidden"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3 3l18 18"/>
                                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                                    <path d="M9.9 5.2A11 11 0 0 1 12 5c6.4 0 10 7 10 7a13 13 0 0 1-3 3.7"/>
                                    <path d="M6.6 6.6C3.6 8.5 2 12 2 12s3.6 7 10 7c1 0 2-.2 2.9-.5"/>
                                </svg>

                            </button>
                        </div>

                        @error('password')
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        @enderror

                        {{-- Remember Me --}}
                        <label class="mt-2 flex items-center gap-2 text-xs text-slate-600">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="rounded border-slate-300 text-blue-400"
                            >
                            Ingat saya di perangkat ini
                        </label>

                        {{-- Login Button --}}
                        <x-ui.primary-button type="submit" class="mt-1 w-full">
                            Masuk ke sistem
                        </x-ui.primary-button>

                    </form>

                    {{-- Forgot Password --}}
                    <a
                        href="{{ route('password.request') }}"
                        class="mt-2 flex justify-end text-end text-sm font-normal text-gray-500"
                    >
                        Lupa kata sandi?
                    </a>

                @endauth

            </section>
        </main>
    </div>

    {{-- JavaScript Toggle Password --}}
    <script>
        function togglePasswordVisibility(button) {

            const wrapper = button.closest('[data-password-field]');

            if (!wrapper) return;

            const passwordInput = wrapper.querySelector('input[name="password"]');

            const eyeIcon = button.querySelector('[data-eye]');
            const eyeOffIcon = button.querySelector('[data-eye-off]');

            if (!passwordInput) return;

            const isPasswordHidden = passwordInput.type === 'password';

            // Mengubah tipe input password
            passwordInput.type = isPasswordHidden ? 'text' : 'password';

            // Mengatur tampilan icon
            eyeIcon.classList.toggle('hidden', isPasswordHidden);
            eyeOffIcon.classList.toggle('hidden', !isPasswordHidden);

            // Mengubah keterangan tombol
            button.setAttribute(
                'aria-label',
                isPasswordHidden ? 'Sembunyikan kata sandi' : 'Lihat kata sandi'
            );

            button.setAttribute(
                'title',
                isPasswordHidden ? 'Sembunyikan kata sandi' : 'Lihat kata sandi'
            );

            button.setAttribute(
                'aria-pressed',
                isPasswordHidden ? 'true' : 'false'
            );
        }
    </script>

</x-layouts.guest>
