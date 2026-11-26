<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EskaHub')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FFFFFF] font-['Inter'] text-[#1A2530] antialiased">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-[#E5E5E5] bg-[#FFFFFF]/90 backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-6 lg:px-8">

            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('assets/logo sekolah.webp') }}" alt="Logo Sekolah" class="h-9 w-9 object-contain">
                <span class="text-lg font-semibold tracking-tight text-[#1A2530]">
                    EskaHub<span class="text-[#D9A512]">.</span>
                </span>
            </a>

            <div class="hidden items-center gap-7 md:flex">
                <a href="{{ route('landing') }}" class="text-sm font-medium text-[#1A2530]">Beranda</a>
                <a href="#tentang" class="text-sm font-medium text-[#666666] transition hover:text-[#1A2530]">Tentang</a>
                <a href="#ekstrakurikuler" class="text-sm font-medium text-[#666666] transition hover:text-[#1A2530]">Ekstrakurikuler</a>
                <a href="#cara-kerja" class="text-sm font-medium text-[#666666] transition hover:text-[#1A2530]">Cara Kerja</a>
            </div>

            <div class="flex items-center gap-5">
                <a href="{{ route('student.login') }}" class="hidden text-sm font-medium text-[#1A2530] transition hover:text-[#D9A512] sm:block">
                    Masuk
                </a>
                <a href="{{ route('student.register') }}" class="rounded-md bg-[#1A2530] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#2C3E50]">
                    Daftar
                </a>
            </div>

        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-[#E5E5E5] bg-[#FAFAFA]">
        <div class="mx-auto max-w-6xl px-6 py-10 lg:px-8">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                <div>
                    <span class="text-base font-semibold text-[#1A2530]">
                        EskaHub<span class="text-[#D9A512]">.</span>
                    </span>
                    <p class="mt-1.5 max-w-sm text-sm leading-6 text-[#666666]">
                        Platform informasi dan pendaftaran kegiatan ekstrakurikuler sekolah.
                    </p>
                </div>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-[#666666]">
                    <a href="#tentang" class="hover:text-[#1A2530]">Tentang</a>
                    <a href="#ekstrakurikuler" class="hover:text-[#1A2530]">Ekstrakurikuler</a>
                    <a href="#cara-kerja" class="hover:text-[#1A2530]">Cara Kerja</a>
                    <a href="{{ route('student.login') }}" class="hover:text-[#1A2530]">Masuk</a>
                </div>
            </div>
        </div>
        <div class="border-t border-[#E5E5E5] px-6 py-4 text-center text-xs text-[#666666]">
            &copy; {{ date('Y') }} EskaHub. All rights reserved.
        </div>
    </footer>

</body>
</html>