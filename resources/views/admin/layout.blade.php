<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'EskaHub ADMIN')</title>

    {{-- Google Font: Hanken Grotesk --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
        }

        /* Kontrol eksplisit buka-tutup sidebar di Mobile/Tablet (< 1024px) */
        @media (max-width: 1023px) {
            #adminSidebar {
                transform: translateX(-100%);
            }
            #adminSidebar.is-open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="flex min-h-screen bg-white text-gray-800">

    {{-- ========================= --}}
    {{-- OVERLAY MOBILE --}}
    {{-- ========================= --}}
    <div
        id="sidebarOverlay"
        onclick="closeSidebar()"
        class="fixed inset-0 z-40 hidden bg-black/50 transition-opacity lg:hidden"
    ></div>

    {{-- ========================= --}}
    {{-- SIDEBAR (RESPONSIVE & STICKY) --}}
    {{-- ========================= --}}
    <aside
        id="adminSidebar"
        class="fixed inset-y-0 left-0 z-50 flex h-screen w-64 shrink-0 flex-col overflow-y-auto bg-[#1E2B37] text-white transition-transform duration-300 ease-in-out select-none lg:sticky lg:top-0 lg:translate-x-0"
    >

        {{-- LOGO HEADER --}}
        <div class="flex items-center justify-between px-5 pt-6 pb-5">
            <div class="flex items-center space-x-3.5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center sm:h-12 sm:w-12">
                    <img
                        src="{{ asset('assets/logo sekolah.webp') }}"
                        alt="Logo Sekolah"
                        class="h-full w-full object-contain"
                    >
                </div>

                <div class="leading-none">
                    <h1 class="text-[20px] font-bold tracking-tight text-white">
                        EskaHub
                    </h1>
                    <span class="mt-0.5 block text-[19px] font-extrabold tracking-wide text-white">
                        ADMIN
                    </span>
                </div>
            </div>

            {{-- Tombol Tutup ✕ (Khusus Mobile/Tablet) --}}
            <button
                type="button"
                onclick="closeSidebar()"
                class="relative z-10 cursor-pointer rounded-md p-2 text-gray-300 transition hover:bg-[#2D3B48] hover:text-white lg:hidden"
                aria-label="Tutup Menu"
            >
                <svg class="pointer-events-none h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- SIDEBAR MENU --}}
        <nav class="mt-1 flex-1 space-y-1">

            {{-- DASHBOARD --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="group flex items-center py-3.5 pr-6 text-[12px] font-bold tracking-wider transition-colors duration-150
                {{ request()->routeIs('admin.dashboard')
                    ? 'border-l-[4px] border-[#F6B100] bg-[#2D3B48] pl-[20px] text-white'
                    : 'px-6 text-[#64748B] hover:bg-[#263542] hover:text-gray-200' }}"
            >
                <span class="mr-3.5 flex w-5 items-center justify-center text-white">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <path d="M17.5 14v7M14 17.5h7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" />
                    </svg>
                </span>
                <span>DASHBOARD</span>
            </a>

            {{-- DATA SISWA --}}
            <a
                href="{{ route('admin.datasiswa.index') }}"
                class="group flex items-center py-3.5 pr-6 text-[12px] font-bold tracking-wider transition-colors duration-150
                {{ request()->routeIs(['admin.datasiswa', 'admin.datasiswa.*'])
                    ? 'border-l-[4px] border-[#F6B100] bg-[#2D3B48] pl-[20px] text-white'
                    : 'px-6 text-[#64748B] hover:bg-[#263542] hover:text-gray-200' }}"
            >
                <span class="mr-3.5 flex w-5 items-center justify-center text-white">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z"/>
                    </svg>
                </span>
                <span>DATA SISWA</span>
            </a>

            {{-- EKSTRAKURIKULER --}}
            <a
                href="{{ route('admin.adexstra') }}"
                class="group flex items-center py-3.5 pr-6 text-[12px] font-bold tracking-wider transition-colors duration-150
                {{ request()->routeIs(['admin.adexstra', 'admin.adexstra.*'])
                    ? 'border-l-[4px] border-[#F6B100] bg-[#2D3B48] pl-[20px] text-white'
                    : 'px-6 text-[#64748B] hover:bg-[#263542] hover:text-gray-200' }}"
            >
                <span class="mr-3.5 flex w-5 items-center justify-center text-white">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94A5.01 5.01 0 0 0 11 15.9V19H7v2h10v-2h-4v-3.1a5.01 5.01 0 0 0 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
                    </svg>
                </span>
                <span>EKSTRAKURIKULER</span>
            </a>

            {{-- PEMBINA / PELATIH --}}
            <a
                href="{{ route('admin.pelatih') }}"
                class="group flex items-center py-3.5 pr-6 text-[12px] font-bold tracking-wider transition-colors duration-150
                {{ request()->routeIs(['admin.pelatih', 'admin.pelatih.*'])
                    ? 'border-l-[4px] border-[#F6B100] bg-[#2D3B48] pl-[20px] text-white'
                    : 'px-6 text-[#64748B] hover:bg-[#263542] hover:text-gray-200' }}"
            >
                <span class="mr-3.5 flex w-5 items-center justify-center text-white">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h10.5a5.5 5.5 0 0 1-.5-2.3c0-1.26.42-2.42 1.13-3.35C11.97 14.12 10.87 14 10 14z"/>
                        <path d="M17.5 13a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm2 5h-1.5v1.5h-1V18h-1.5v-1H17v-1.5h1V17h1.5v1z"/>
                    </svg>
                </span>
                <span>PEMBINA/PELATIH</span>
            </a>

            {{-- LAPORAN --}}
            <a
                href="{{ route('admin.laporan') }}"
                class="group flex items-center py-3.5 pr-6 text-[12px] font-bold tracking-wider transition-colors duration-150
                {{ request()->routeIs(['admin.laporan', 'admin.laporan.*'])
                    ? 'border-l-[4px] border-[#F6B100] bg-[#2D3B48] pl-[20px] text-white'
                    : 'px-6 text-[#64748B] hover:bg-[#263542] hover:text-gray-200' }}"
            >
                <span class="mr-3.5 flex w-5 items-center justify-center text-white">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM9 18H7v-5h2v5zm4 0h-2v-7h2v7zm4 0h-2v-3h2v3zm-4-9V3.5L18.5 9H13z"/>
                    </svg>
                </span>
                <span>LAPORAN</span>
            </a>

        </nav>

    </aside>


    {{-- ========================= --}}
    {{-- MAIN CONTENT AREA --}}
    {{-- ========================= --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- TOP NAVBAR + JUDUL HALAMAN SEJAJAR --}}
        <header class="sticky top-0 z-30 flex items-start justify-between bg-white px-6 pt-6 pb-4 md:px-10">

            <div class="flex items-start gap-3">
                {{-- HAMBURGER BUTTON (Khusus Mobile/Tablet) --}}
                <button
                    type="button"
                    onclick="openSidebar()"
                    class="mt-0.5 cursor-pointer rounded-md p-1.5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none lg:hidden"
                    aria-label="Buka Menu"
                >
                    <svg class="pointer-events-none h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- SLOT JUDUL HALAMAN (SEJAJAR DENGAN ICON LOGOUT & PROFIL) --}}
                <div>
                    @yield('header-title')
                </div>
            </div>

            {{-- RIGHT ICONS (LOGOUT & PROFILE) --}}
         
<div class="flex shrink-0 items-center gap-4">

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}"
          method="POST"
          class="flex items-center"
          onsubmit="return confirm('Yakin ingin logout?')">
        @csrf

        <button type="submit"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-100 hover:text-gray-900"
                title="Logout">

            <svg class="h-6 w-6"
                 viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M16 13V11H7V8L2 12L7 16V13H16Z" fill="currentColor"/>
                <path d="M20 3H11C9.897 3 9 3.897 9 5V9H11V5H20V19H11V15H9V19C9 20.103 9.897 21 11 21H20C21.103 21 22 20.103 22 19V5C22 3.897 21.103 3 20 3Z" fill="currentColor"/>
            </svg>
        </button>
    </form>

    {{-- PROFILE --}}
    <a href="{{ route('admin.profil') }}"
       class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 transition hover:bg-gray-100 hover:text-gray-900"
       title="Profil Saya">

        <svg class="h-6 w-6"
             viewBox="0 0 24 24"
             fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M16.5 9C16.5 10.1935 16.0259 11.3381 15.182 12.182C14.3381 13.0259 13.1935 13.5 12 13.5C10.8065 13.5 9.66193 13.0259 8.81802 12.182C7.97411 11.3381 7.5 10.1935 7.5 9C7.5 7.80653 7.97411 6.66193 8.81802 5.81802C9.66193 4.97411 10.8065 4.5 12 4.5C13.1935 4.5 14.3381 4.97411 15.182 5.81802C16.0259 6.66193 16.5 7.80653 16.5 9Z" fill="currentColor"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12C0 8.8174 1.26428 5.76516 3.51472 3.51472C5.76516 1.26428 8.8174 0 12 0C15.1826 0 18.2348 1.26428 20.4853 3.51472C22.7357 5.76516 24 8.8174 24 12C24 15.1826 22.7357 18.2348 20.4853 20.4853C18.2348 22.7357 15.1826 24 12 24C8.8174 24 5.76516 22.7357 3.51472 20.4853C1.26428 18.2348 0 15.1826 0 12ZM12 1.5C10.0227 1.50011 8.08555 2.05854 6.4116 3.11104C4.73766 4.16354 3.39492 5.66732 2.53795 7.44929C1.68097 9.23127 1.34458 11.219 1.5675 13.1837C1.79042 15.1485 2.56358 17.0103 3.798 18.555C4.863 16.839 7.2075 15 12 15C16.7925 15 19.1355 16.8375 20.202 18.555C21.4364 17.0103 22.2096 15.1485 22.4325 13.1837C22.6554 11.219 22.319 9.23127 21.4621 7.44929C20.6051 5.66732 19.2623 4.16354 17.5884 3.11104C15.9145 2.05854 13.9773 1.50011 12 1.5Z" fill="currentColor"/>
        </svg>
    </a>

</div>


        </header>

        {{-- CONTENT --}}
        <main class="flex-1 px-6 pb-8 md:px-10">
            @yield('content')
        </main>

    </div>

    {{-- SCRIPT BUKA / TUTUP SIDEBAR --}}
    <script>
        function openSidebar() {
            document.getElementById('adminSidebar').classList.add('is-open');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }

        function closeSidebar() {
            document.getElementById('adminSidebar').classList.remove('is-open');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    </script>

</body>

</html>