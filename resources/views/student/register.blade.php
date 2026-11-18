<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EskaHub - Pendaftaran Akun</title>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex min-h-screen items-center justify-center bg-[#f8fafc] font-['Hanken_Grotesk',sans-serif] p-4 sm:p-6 lg:p-10">

    <div class="relative w-full max-w-5xl">
        <div class="relative grid w-full overflow-hidden rounded-2xl bg-white shadow-2xl lg:grid-cols-12">

            {{-- PANEL KIRI (DARK SIDEBAR) --}}
            <div class="relative flex flex-col justify-between overflow-hidden bg-[#0a111a] p-8 text-white sm:p-10 lg:col-span-5">
                <div class="pointer-events-none absolute -left-10 -top-9 h-50 w-50 rounded-full bg-gradient-to-br from-[#f6bd24] via-[#f6bd24]/40 to-transparent opacity-80 blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-3">
                    <img src="{{ asset('assets/logo sekolah.webp') }}" alt="Logo Sekolah" class="h-10 w-auto object-contain drop-shadow-md"
                        onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';"> 
                    <h2 class="text-xl font-bold tracking-tight text-white">EskaHub</h2>
                </div>
                <div class="relative z-10 my-10 flex flex-col items-center text-center">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-full bg-[#e2e8f0] text-[#1e293b] shadow-inner">
                        <i class="fa-regular fa-user text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white sm:text-2xl">Sudah pernah Daftar?</h3>
                    <p class="mt-2.5 max-w-xs text-xs leading-relaxed text-gray-300">
                        Jika akun Anda sudah aktif, langsung masuk ke dasbor siswa di sini.
                    </p>
                    <a href="{{ url('/login') }}"
                        class="mt-6 inline-flex h-10 w-28 items-center justify-center rounded-lg bg-[#f5a623] text-sm font-bold text-black shadow-md transition-all hover:bg-[#e0951b] hover:shadow-lg active:scale-95">
                        Masuk
                    </a>
                </div>
                <div class="relative z-10 border-t border-white/50 pt-5 text-center text-[11px] text-gray-400">
                    Butuh bantuan pendaftaran? 
                    <a href="#" class="font-bold text-white transition hover:text-[#f5a623]">Hubungi Operator</a>
                </div>
            </div>

            {{-- PANEL KANAN (FORMULIR REGISTRASI) --}}
            <div class="flex flex-col justify-center bg-white p-8 sm:p-10 lg:col-span-7 lg:p-12">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-md bg-[#f6bd24] px-3 py-1.5 text-xs font-semibold text-black shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-[#80ef80]"></span>
                        Registrasi Akun Baru
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-gray-900 sm:text-3xl">Pendaftaran Akun</h1>
                    <p class="mt-1.5 text-sm text-gray-500">Lakukan validasi NISN dan lengkapi data pendaftaran akun siswa.</p>
                </div>

                {{-- PESAN ERROR --}}
                @if(session('error'))
                    <div class="mt-4 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 p-3 text-xs text-red-700">
                        <i class="fa-solid fa-circle-xmark mt-0.5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-xs text-red-700">
                        <ul class="list-disc space-y-1 pl-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- STEP 1: FORM CARI NISN --}}
                @if(!isset($student))
                    <form action="{{ route('student.register.validate') }}" method="POST" class="mt-6">
                        @csrf
                        <div>
                            <label for="nisn" class="mb-2 block text-[10px] font-bold uppercase tracking-wider text-gray-700">
                                Nomor Induk Siswa Nasional (NISN)
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                                    placeholder="Masukkan NISN" maxlength="10" inputmode="numeric" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900 placeholder:text-gray-400">
                                <button type="submit"
                                    class="flex items-center justify-center rounded-lg bg-[#111827] px-5 text-white transition hover:bg-gray-800 active:scale-95">
                                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    {{-- STEP 2: DATA NISN TERVERIFIKASI --}}
                    <div class="mt-6">
                        <label class="mb-2 block text-[10px] font-bold uppercase tracking-wider text-gray-700">
                            Nomor Induk Siswa Nasional (NISN)
                        </label>
                        <div class="flex gap-2">
                            <input type="text" value="{{ $student->nisn }}" readonly
                                class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-700 outline-none">
                            <div class="flex items-center justify-center rounded-lg bg-[#111827] px-5 text-white">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </div>
                        </div>
                    </div>

                    {{-- ALERT VERIFIKASI --}}
                    @if(isset($sudahTerdaftar) && $sudahTerdaftar)
                        <div class="mt-3 flex items-center gap-2.5 rounded-lg border border-amber-200 bg-amber-50 px-3.5 py-2.5 text-xs font-medium text-amber-800">
                            <i class="fa-solid fa-triangle-exclamation text-sm text-amber-600"></i>
                            <span>NISN ini sudah terdaftar. Silakan login menggunakan akun Anda.</span>
                        </div>
                    @else
                        <div class="mt-3 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-3.5 py-2.5 text-xs font-medium text-emerald-800">
                            <i class="fa-solid fa-circle-check text-sm text-emerald-600"></i>
                            <span>NISN Ditemukan. Data siswa terverifikasi dengan pangkalan data sekolah.</span>
                        </div>
                    @endif

                    {{-- KARTU RINCIAN DATA SISWA --}}
                    <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50/50 p-4 text-xs">
                        <div class="space-y-2.5">
                            <div class="grid grid-cols-[110px_15px_1fr]">
                                <span class="font-semibold text-gray-500">NISN</span>
                                <span class="text-gray-400">:</span>
                                <span class="font-bold text-gray-800">{{ $student->nisn }}</span>
                            </div>
                            <div class="grid grid-cols-[110px_15px_1fr]">
                                <span class="font-semibold text-gray-500">NAMA</span>
                                <span class="text-gray-400">:</span>
                                <span class="font-bold uppercase text-gray-800">{{ $student->nama }}</span>
                            </div>
                            <div class="grid grid-cols-[110px_15px_1fr]">
                                <span class="font-semibold text-gray-500">KELAS</span>
                                <span class="text-gray-400">:</span>
                                <span class="font-bold text-gray-800">{{ $student->kelas }}</span>
                            </div>
                            <div class="grid grid-cols-[110px_15px_1fr]">
                                <span class="font-semibold text-gray-500">JURUSAN</span>
                                <span class="text-gray-400">:</span>
                                <span class="font-bold uppercase text-gray-800">{{ $student->jurusan ?? '-' }}</span>
                            </div>
                            <div class="grid grid-cols-[110px_15px_1fr]">
                                <span class="font-semibold text-gray-500">EMAIL SEKOLAH</span>
                                <span class="text-gray-400">:</span>
                                <span class="font-semibold text-gray-700">{{ $student->email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- FORM ISI PASSWORD (HANYA MUNCUL KALAU BELUM TERDAFTAR) --}}
                    @if(!isset($sudahTerdaftar) || !$sudahTerdaftar)
                        <form action="{{ route('student.register.store') }}" method="POST" class="mt-5">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-gray-700">
                                        Masukkan Password
                                    </label>
                                    <div class="relative flex items-center">
                                        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" minlength="8" required
                                            class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3.5 pr-9 text-xs text-gray-800 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900 placeholder:text-gray-400">
                                        <button type="button" class="toggle-password absolute right-3 text-gray-400 hover:text-gray-600">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="mb-1.5 block text-[10px] font-bold uppercase tracking-wider text-gray-700">
                                        Konfirmasi Password
                                    </label>
                                    <div class="relative flex items-center">
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" minlength="8" required
                                            class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3.5 pr-9 text-xs text-gray-800 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900 placeholder:text-gray-400">
                                        <button type="button" class="toggle-password absolute right-3 text-gray-400 hover:text-gray-600">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-6 flex w-full items-center justify-center gap-2 rounded-lg bg-[#f6bd24] py-3 text-sm font-bold text-[#111827] shadow-md transition hover:bg-[#e0ab1d] active:scale-[0.99]">
                                Daftar
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </form>
                    @else
                        <div class="mt-5">
                            <a href="{{ route('student.login') }}" class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#111827] py-3 text-sm font-bold text-white shadow-md transition hover:bg-gray-800">
                                Login Sekarang
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
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