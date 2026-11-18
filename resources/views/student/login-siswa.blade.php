<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EskaHub - Login Siswa</title>

    <!-- Google Fonts: Hanken Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="flex min-h-screen items-center justify-center bg-[#f8fafc] font-['Hanken_Grotesk',sans-serif] p-4 sm:p-6 lg:p-10">

    <!-- WRAPPER UTAMA -->
    <div class="relative w-full max-w-5xl">

        @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="relative grid w-full overflow-hidden rounded-2xl bg-[#0a111a] shadow-2xl lg:grid-cols-12">

            <!-- ================================================= -->
            <!-- PANEL KIRI (FORM LOGIN DARK THEME) -->
            <!-- ================================================= -->
            <div class="relative flex flex-col justify-between overflow-hidden bg-[#0a111a] p-8 text-white sm:p-10 lg:col-span-7">

                <!-- EFEK LIGHTING KUNING DI BELAKANG LOGO -->
                <div class="pointer-events-none absolute -left-10 -top-9 h-48 w-48 rounded-full bg-gradient-to-br from-[#f6bd24] via-[#f6bd24]/30 to-transparent opacity-80 blur-2xl"></div>

                <!-- 1. BRANDING HEADER (LOGO & NAMA) -->
                <div class="relative z-10 mb-6 flex items-center gap-3">
                    <img src="{{ asset('assets/logo sekolah.webp') }}" alt="Logo Sekolah" class="h-10 w-auto object-contain drop-shadow-md"
                        onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';"> 
                    
                    <h2 class="text-xl font-bold tracking-tight text-white">
                        EskaHub
                    </h2>
                </div>

                <!-- 2. BADGE KUNING KAPSUL -->
                <div class="relative z-10 mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-[#f6bd24] px-3.5 py-1 text-xs font-bold text-black shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-[#e0951b]"></span>
                    Autentikasi Terpadu Siswa
                </div>

                <!-- 3. JUDUL & SUBJUDUL -->
                <div class="relative z-10 mb-6">
                    <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                        Login Akun
                    </h1>
                    <p class="mt-1.5 text-xs text-gray-400">
                        Masukkan data kredensial Anda untuk masuk ke sistem kegiatan siswa.
                    </p>
                </div>

                <!-- 4. FORM LOGIN -->
                <form action="{{ route('student.login.process') }}" method="POST" class="relative z-10 space-y-4">
                    @csrf

                    <!-- FIELD NISN / EMAIL -->
                    <div>
                        <label for="login_input" class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-gray-300">
                            Nomor Induk Siswa Nasional (NISN)
                        </label>

                        <div class="flex overflow-hidden rounded-xl border border-gray-700/80 bg-[#f1f5f9] text-gray-900 transition focus-within:border-[#f6bd24] focus-within:ring-1 focus-within:ring-[#f6bd24]">
                            <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                                placeholder="0058492018" required
                                class="w-full bg-transparent px-4 py-2.5 text-xs font-medium text-gray-900 outline-none placeholder:text-gray-400">
                        </div>

                        <small class="mt-1.5 flex items-center gap-1.5 text-[10px] text-gray-400">
                            <i class="fa-regular fa-clock text-[#f6bd24]"></i>
                            <span>Gunakan 10 digit NISN terverifikasi Dapodik atau email resmi sekolah.</span>
                        </small>

                        @error('login')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- FIELD PASSWORD (FULL WIDTH TANPA KODE KEAMANAN) -->
                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <label for="password" class="block text-[10px] font-bold uppercase tracking-wider text-gray-300">
                                Password
                            </label>
                            <a href="#" class="text-[10px] text-gray-400 transition hover:text-white hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                        <div class="relative flex items-center">
                            <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required
                                class="w-full rounded-xl border border-gray-700/80 bg-white py-2.5 pl-3.5 pr-10 text-xs text-gray-900 outline-none transition focus:border-[#f6bd24] focus:ring-1 focus:ring-[#f6bd24] placeholder:text-gray-400">
                            <button type="button" id="togglePassword" class="absolute right-3.5 flex items-center justify-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="passwordIcon" class="fa-regular fa-eye text-xs"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TOMBOL MASUK KUNING -->
                    <button type="submit"
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#f6bd24] py-3 text-xs font-bold text-black shadow-lg shadow-[#f6bd24]/10 transition hover:bg-[#e0ab1d] active:scale-[0.99]">
                        Masuk ke Dasbor
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>

                <!-- 5. FOOTER PANEL KIRI -->
                <div class="relative z-10 mt-6 flex items-center justify-between border-t border-gray-800/80 pt-4 text-[11px] text-gray-400">
                    <span>Kendala verifikasi akun?</span>
                    <button type="button" id="togglePasswordLink" class="font-semibold underline  text-gray-300 transition hover:text-[#f6bd24] focus:outline-none">
                        Hubungi Operator Sekolah
                    </button>
                </div>

            </div>


            <!-- ================================================= -->
            <!-- PANEL KANAN (REGISTER - LIGHT THEME) -->
            <!-- ================================================= -->
            <div class="relative hidden flex-col justify-between bg-white p-8 text-gray-800 lg:flex lg:col-span-5 lg:p-12">

                <!-- CONTENT TENGAH -->
                <div class="relative z-10 flex flex-1 flex-col items-center justify-center text-center">
                    
                    <!-- IKON USER PLUS KOTAK HITAM ROUNDED -->
                    <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#0a111a] text-white shadow-md">
                        <i class="fa-solid fa-user-plus text-2xl"></i>
                    </div>

                    <!-- JUDUL -->
                    <h3 class="text-2xl font-bold tracking-tight text-black sm:text-3xl">
                        Belum punya akun?
                    </h3>

                    <!-- DESKRIPSI -->
                    <p class="mt-3 max-w-xs text-xs leading-relaxed text-gray-400">
                        Jika Anda merupakan siswa baru atau belum memiliki akses, daftarkan diri untuk memilih ekstrakurikuler sekolah.
                    </p>

                    <!-- TOMBOL DAFTAR AKUN BARU (HITAM) -->
                    <a href="{{ route('student.register') }}"
                        class="mt-8 inline-flex h-11 w-full max-w-[220px] items-center justify-center rounded-xl bg-[#0a111a] text-xs font-bold uppercase tracking-wider text-white shadow-md transition hover:bg-[#182635] active:scale-95">
                        DAFTAR AKUN BARU
                    </a>
                </div>

                <!-- FOOTER PANEL KANAN -->
                <div class="relative z-10 text-center text-[10px] font-medium tracking-wide text-gray-400">
                    Sistem Informasi Registrasi Resmi © SMKN1 PURWOSARI
                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPT TOGGLE SHOW/HIDE PASSWORD -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const passwordIcon = document.getElementById('passwordIcon');

            if (togglePassword && passwordInput && passwordIcon) {
                togglePassword.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    passwordIcon.classList.toggle('fa-eye', !isPassword);
                    passwordIcon.classList.toggle('fa-eye-slash', isPassword);
                });
            }
        });
    </script>

</body>

</html>