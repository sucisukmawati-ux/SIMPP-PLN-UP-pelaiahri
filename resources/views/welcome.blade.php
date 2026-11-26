<x-layouts.guest>
    <div class="relative isolate min-h-screen overflow-hidden bg-[#071b2b] text-white">
        <div class="pointer-events-none absolute -left-40 -top-40 size-[30rem] rounded-full bg-blue-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-52 left-1/4 size-[34rem] rounded-full bg-sky-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-36 top-1/4 size-[28rem] rounded-full bg-blue-500/10 blur-3xl"></div>

        <main class="relative mx-auto grid justify-items-center min-h-screen w-full max-w-6xl flex-col-1 items-center gap-6 px-3 py-8 sm:px-6 lg:px-8">
            <section class="w-full max-w-sm rounded-xl bg-[#0a2b4c]/50 p-6 shadow-lg backdrop-blur-md">

                <div class="mt-6 grid gap-2">
                    <x-ui.text-field
                        label="Username"
                        name="username"
                        type="name"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                    />
                    <x-ui.text-field
                        label="Kata sandi"
                        name="password"
                        type="password"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password"
                        required
                    />

                    <x-ui.primary-button class="mt-1 w-full">
                        Masuk ke sistem
                    </x-ui.primary-button>
                </div>

                <div class="mt-5 flex items-start gap-3 border-t border-slate-100 pt-4">
                    <span class="mt-0.5 text-slate-400">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                            <path d="M12 11v5m0-8h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </span>
                </div>
            </section>
        </main>
    </div>
</x-layouts.guest>
