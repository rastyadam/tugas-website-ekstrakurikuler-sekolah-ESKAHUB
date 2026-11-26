<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - EskaHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">

        {{-- Identitas Singkat di Atas Card --}}
        <div class="mb-6 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100/80 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-amber-800">
                <i class="fa-solid fa-shield-halved"></i> Keamanan Akun EskaHub
            </span>
        </div>

        {{-- Card Form Ganti Password --}}
        <div class="w-full max-w-md rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Ganti Password</h1>
                <p class="mt-1.5 text-sm text-slate-500">
                    Demi keamanan akun, silakan perbarui password Anda sebelum melanjutkan ke dashboard.
                </p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Input Password Lama --}}
                <div>
                    <label for="kata_sandi_lama" class="mb-1.5 block text-xs font-bold text-slate-800">
                        Password Lama
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="kata_sandi_lama"
                            name="kata_sandi_lama"
                            required
                            placeholder="Masukkan password saat ini"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-800 outline-none transition-all focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        >
                        <button
                            type="button"
                            class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-600 focus:outline-none"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi_lama')
                        <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input Password Baru --}}
                <div>
                    <label for="kata_sandi" class="mb-1.5 block text-xs font-bold text-slate-800">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="kata_sandi"
                            name="kata_sandi"
                            required
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-800 outline-none transition-all focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        >
                        <button
                            type="button"
                            class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-600 focus:outline-none"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @error('kata_sandi')
                        <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input Konfirmasi Password Baru --}}
                <div class="pb-2">
                    <label for="kata_sandi_confirmation" class="mb-1.5 block text-xs font-bold text-slate-800">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="kata_sandi_confirmation"
                            name="kata_sandi_confirmation"
                            required
                            minlength="8"
                            placeholder="Ulangi password baru"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm text-slate-800 outline-none transition-all focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"
                        >
                        <button
                            type="button"
                            class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-600 focus:outline-none"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-amber-500 py-3.5 text-sm font-bold text-white shadow-xs transition hover:bg-amber-600 active:scale-[0.99]"
                >
                    Simpan Password Baru
                </button>
            </form>
        </div>

    </div>

    {{-- Script Toggle Password --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>