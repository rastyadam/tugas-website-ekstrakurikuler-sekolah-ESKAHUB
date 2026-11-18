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

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen bg-white text-gray-800">

    {{-- ========================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================= --}}

    <aside class="flex min-h-screen w-64 flex-col bg-[#1b2b3a] text-white">

        {{-- LOGO --}}
        <div class="flex items-center space-x-3 bg-[#16222f] p-4">

            <div class="flex h-12 w-12 items-center justify-center">
                <img
                    src="{{ asset('assets/logo sekolah.webp') }}"
                    alt="Logo"
                    class="h-full w-full object-contain"
                >
            </div>

            <div>
                <h1 class="text-lg font-extrabold leading-tight tracking-wide text-white">
                    EskaHub
                </h1>

                <span class="block text-sm font-extrabold tracking-wide text-white">
                    ADMIN
                </span>
            </div>

        </div>


        {{-- ========================= --}}
        {{-- SIDEBAR MENU --}}
        {{-- ========================= --}}

        <nav class="flex-1 space-y-0.5">

            {{-- DASHBOARD --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center py-3.5 pr-6 text-xs font-bold tracking-wider transition-all duration-150
                {{ request()->routeIs('admin.dashboard')
                    ? 'border-l-4 border-amber-500 bg-[#2b3c4d] pl-[20px] text-white'
                    : 'px-6 text-gray-400 hover:bg-[#233343] hover:text-gray-200' }}"
            >
                <i class="fa-solid fa-table-cells-large w-7 text-sm"></i>
                <span>DASHBOARD</span>
            </a>


            {{-- DATA SISWA --}}
            <a
                href="{{ route('admin.datasiswa.index') }}"
                class="flex items-center py-3.5 pr-6 text-xs font-bold tracking-wider transition-all duration-150
                {{ request()->routeIs('admin.datasiswa.*')
                    ? 'border-l-4 border-amber-500 bg-[#2b3c4d] pl-[20px] text-white'
                    : 'px-6 text-gray-400 hover:bg-[#233343] hover:text-gray-200' }}"
            >
                <i class="fa-solid fa-user w-7 text-sm"></i>
                <span>DATA SISWA</span>
            </a>


            {{-- EKSTRAKURIKULER --}}
            <a
                href="{{ route('admin.adexstra') }}"
                class="flex items-center py-3.5 pr-6 text-xs font-bold tracking-wider transition-all duration-150
                {{ request()->routeIs('admin.adexstra.*')
                    ? 'border-l-4 border-amber-500 bg-[#2b3c4d] pl-[20px] text-white'
                    : 'px-6 text-gray-400 hover:bg-[#233343] hover:text-gray-200' }}"
            >
                <i class="fa-solid fa-trophy w-7 text-sm"></i>
                <span>EKSTRAKURIKULER</span>
            </a>


            {{-- PEMBINA / PELATIH --}}
            <a
                href="{{ route('admin.pelatih') }}"
                class="flex items-center py-3.5 pr-6 text-xs font-bold tracking-wider transition-all duration-150
                {{ request()->routeIs('admin.pelatih.*')
                    ? 'border-l-4 border-amber-500 bg-[#2b3c4d] pl-[20px] text-white'
                    : 'px-6 text-gray-400 hover:bg-[#233343] hover:text-gray-200' }}"
            >
                <i class="fa-solid fa-user-gear w-7 text-sm"></i>
                <span>PEMBINA/PELATIH</span>
            </a>


            {{-- LAPORAN --}}
            <a
                href="{{ route('admin.laporan') }}"
                class="flex items-center py-3.5 pr-6 text-xs font-bold tracking-wider transition-all duration-150
                {{ request()->routeIs('admin.laporan.*')
                    ? 'border-l-4 border-amber-500 bg-[#2b3c4d] pl-[20px] text-white'
                    : 'px-6 text-gray-400 hover:bg-[#233343] hover:text-gray-200' }}"
            >
                <i class="fa-solid fa-file-lines w-7 text-sm"></i>
                <span>LAPORAN</span>
            </a>

        </nav>

    </aside>


    {{-- ========================= --}}
    {{-- MAIN CONTENT AREA --}}
    {{-- ========================= --}}

    <div class="flex min-w-0 flex-1 flex-col">

        {{-- TOP NAVBAR --}}
        <header class="flex h-16 items-center justify-end space-x-4  bg-white px-8">

            {{-- NOTIFICATION --}}
           <button
    type="button"
    class="text-gray-600 transition hover:text-gray-800"
>
    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 13V11H7V8L2 12L7 16V13H16Z" fill="currentColor"/>
        <path d="M20 3H11C9.897 3 9 3.897 9 5V9H11V5H20V19H11V15H9V19C9 20.103 9.897 21 11 21H20C21.103 21 22 20.103 22 19V5C22 3.897 21.103 3 20 3Z" fill="currentColor"/>
    </svg>
</button>


            {{-- PROFILE --}}
            <button
                type="button"
                class="text-gray-600 transition hover:text-gray-800"
            >
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.5 9C16.5 10.1935 16.0259 11.3381 15.182 12.182C14.3381 13.0259 13.1935 13.5 12 13.5C10.8065 13.5 9.66193 13.0259 8.81802 12.182C7.97411 11.3381 7.5 10.1935 7.5 9C7.5 7.80653 7.97411 6.66193 8.81802 5.81802C9.66193 4.97411 10.8065 4.5 12 4.5C13.1935 4.5 14.3381 4.97411 15.182 5.81802C16.0259 6.66193 16.5 7.80653 16.5 9Z" fill="black"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M0 12C0 8.8174 1.26428 5.76516 3.51472 3.51472C5.76516 1.26428 8.8174 0 12 0C15.1826 0 18.2348 1.26428 20.4853 3.51472C22.7357 5.76516 24 8.8174 24 12C24 15.1826 22.7357 18.2348 20.4853 20.4853C18.2348 22.7357 15.1826 24 12 24C8.8174 24 5.76516 22.7357 3.51472 20.4853C1.26428 18.2348 0 15.1826 0 12ZM12 1.5C10.0227 1.50011 8.08555 2.05854 6.4116 3.11104C4.73766 4.16354 3.39492 5.66732 2.53795 7.44929C1.68097 9.23127 1.34458 11.219 1.5675 13.1837C1.79042 15.1485 2.56358 17.0103 3.798 18.555C4.863 16.839 7.2075 15 12 15C16.7925 15 19.1355 16.8375 20.202 18.555C21.4364 17.0103 22.2096 15.1485 22.4325 13.1837C22.6554 11.219 22.319 9.23127 21.4621 7.44929C20.6051 5.66732 19.2623 4.16354 17.5884 3.11104C15.9145 2.05854 13.9773 1.50011 12 1.5Z" fill="black"/>
</svg>


            </button>

        </header>


        {{-- CONTENT --}}
        <main class="flex-1 p-8">

            @yield('content')

        </main>

    </div>

</body>

</html>