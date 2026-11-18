<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EksaHub Pembina Portal')</title>
    <!-- Tailwind CSS (Gunakan Vite di Laravel: @vite(['resources/css/app.css', 'resources/js/app.js'])) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 antialiased flex h-screen overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-64 bg-[#0d141e] text-gray-300 flex flex-col justify-between shrink-0 border-r border-gray-800">
        <div>
            <!-- Header Brand -->
            <div class="p-6 border-b border-gray-800/60">
                <h1 class="text-white font-bold text-lg leading-snug tracking-tight">
                    EksaHub Pembina<br>Portal
                </h1>
                <p class="text-xs text-gray-500 font-medium mt-1">
                    Extracurricular System
                </p>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-4 px-0 space-y-1">
                <!-- Dashboard (Active State) -->
                <a href="{{ route('pembina.dashboard-pembina') }}" 
                   class="flex items-center space-x-3 px-6 py-3 text-amber-500 font-medium bg-[#141d2b] border-l-4 border-amber-500 transition-all">
                    <!-- Icon Dashboard -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>

                <!-- Pendaftar -->
                <a href="{{ route('pembina.pendaftar') }}" 
   class="flex items-center space-x-3 px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-l-4 border-transparent transition-all">
                    <!-- Icon User Add -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span class="text-sm">Pendaftar</span>
                </a>

                <!-- Anggota -->
                <a href="{{ route('pembina.anggota') }}" class="flex items-center space-x-3 px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-l-4 border-transparent transition-all">
                    <!-- Icon Users Group -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5 5 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-sm">Anggota</span>
                </a>

                <!-- Jadwal Latihan -->
                <a href="{{ route('pembina.jadwal-latihan') }}" class="flex items-center space-x-3 px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-l-4 border-transparent transition-all">
                    <!-- Icon Calendar -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 0v4m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Jadwal Latihan</span>
                </a>

                <!-- Pengumuman -->
                <a href="{{ route('pembina.pengumuman') }}" class="flex items-center space-x-3 px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-l-4 border-transparent transition-all">
                    <!-- Icon Megaphone / Announcement -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <span class="text-sm">Pengumuman</span>
                </a>

                <!-- Laporan -->
                <a href="#" class="flex items-center space-x-3 px-6 py-3 text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-l-4 border-transparent transition-all">
                    <!-- Icon Chart / Report -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-sm">Laporan</span>
                </a>
            </nav>
        </div>

        <!-- Footer / Logout -->
        <div class="border-t border-gray-800/80 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2 text-gray-400 hover:text-red-400 transition-colors">
                    <!-- Icon Logout -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT AREA ================= -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
            <!-- Left Header Content / Dynamic Title -->
            <div class="flex items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    @yield('header_title', 'Dashboard')
                </h2>
            </div>

            <!-- Right Header Actions (Icons) -->
            <div class="flex items-center space-x-4">
                <!-- Notification Bell Icon -->
                <button class="text-gray-600 hover:text-gray-900 focus:outline-none p-1 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <!-- Profile User Icon -->
                <button class="text-gray-600 hover:text-gray-900 focus:outline-none p-1 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
        
    </div>

</body>
</html>