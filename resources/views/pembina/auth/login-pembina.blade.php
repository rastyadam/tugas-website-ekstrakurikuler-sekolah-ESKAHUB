<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun Pembina</title>
    <!-- Tailwind CSS (via CDN untuk pengujian cepat atau gunakan Vite @vite(['resources/css/app.css', 'resources/js/app.js'])) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- Main Form Section -->
        <div class="p-8">
            <!-- Header Badges -->
            <div class="flex items-center justify-between mb-6">
                <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-md uppercase tracking-wider">
                    AUTENTIKASI PEMBINA
                </span>
                <span class="text-xs text-gray-400 font-medium">
                    Koneksi Aman SSL
                </span>
            </div>

            <!-- Title & Subtitle -->
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Masuk ke Akun Pembina
            </h1>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                Masukkan kredensial Anda untuk memantau absensi & program ekstrakurikuler.
            </p>

            <!-- Form -->
            <form action="{{ route('login.pembina.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">
                        EMAIL TERDAFTAR
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <!-- Icon User / Person -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                            placeholder="nama.pembina@guru.smkhebat.sch.id"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Kata Sandi -->
<div>
    <div class="flex items-center justify-between mb-2">
        <label for="password" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
            KATA SANDI
        </label>
        <a href="{{ route('password.request') }}" class="text-xs text-gray-600 hover:text-gray-900 font-medium transition-colors">
            Lupa Kata Sandi?
        </a>
    </div>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <!-- Icon Lock -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        
        {{-- Input Password --}}
        <input type="password" id="password" name="password" required
            placeholder="••••••••••••"
            class="w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
        
        {{-- Tombol Mata --}}
        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>
    @error('password')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

                <!-- Checkbox Ingat Saya -->
                <div class="flex items-center pt-1 pb-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-amber-500 border-gray-300 rounded focus:ring-amber-400">
                    <label for="remember" class="ml-2 text-xs text-gray-500 select-none">
                        Ingat saya di perangkat ini selama 14 hari
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-gray-900 font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center space-x-2">
                    <span>Masuk sebagai pembina</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Card Footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-800">Ada kendala dalam login? hubungi admin</p>
                <p class="text-[11px] text-gray-400">Admin akan memperbarui password anda.</p>
            </div>
            <a href="https://wa.me/628123456789" target="_blank" class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-100 transition-colors shadow-sm whitespace-nowrap">
                Hubungi Admin
            </a>
        </div>

    </div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Ganti icon (buka/tutup mata)
        if (type === 'password') {
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        } else {
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        }
    });
</script>

</body>

</html>