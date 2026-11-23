<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EksaHub Pembina Portal')</title>
    <!-- Tailwind CSS (Gunakan Vite di Laravel: @vite(['resources/css/app.css', 'resources/js/app.js'])) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Kontrol eksplisit buka-tutup sidebar di Mobile/Tablet (< 1024px) */
        @media (max-width: 1023px) {
            #pembinaSidebar {
                transform: translateX(-100%);
            }
            #pembinaSidebar.is-open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 antialiased flex min-h-screen">

    <!-- ================= OVERLAY MOBILE ================= -->
    <div
        id="sidebarOverlay"
        onclick="closeSidebar()"
        class="fixed inset-0 z-40 hidden bg-black/50 transition-opacity lg:hidden"
    ></div>

    <!-- ================= SIDEBAR (RESPONSIVE & STICKY) ================= -->
    <aside
        id="pembinaSidebar"
        class="fixed inset-y-0 left-0 z-50 flex h-screen w-64 shrink-0 flex-col justify-between overflow-y-auto border-r border-gray-800 bg-[#0d141e] text-gray-300 transition-transform duration-300 ease-in-out select-none lg:sticky lg:top-0 lg:translate-x-0"
    >
        <div>
            <!-- Header Brand -->
            <div class="flex items-start justify-between border-b border-gray-800/60 p-6">
                <div>
                    <h1 class="text-white font-bold text-lg leading-snug tracking-tight">
                        EksaHub Pembina<br>Portal
                    </h1>
                    <p class="text-xs text-gray-500 font-medium mt-1">
                        Extracurricular System
                    </p>
                </div>

                <!-- Tombol Tutup ✕ (Khusus Mobile/Tablet) -->
                <button
                    type="button"
                    onclick="closeSidebar()"
                    class="relative z-10 -mr-2 -mt-1 cursor-pointer rounded-md p-2 text-gray-400 transition hover:bg-[#141d2b] hover:text-white lg:hidden"
                    aria-label="Tutup Menu"
                >
                    <svg class="pointer-events-none h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-4 px-0 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('pembina.dashboard-pembina') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs('pembina.dashboard-pembina')
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    {{-- Icon Dashboard --}}
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>

                    <span class="text-sm">Dashboard</span>
                </a>

                <!-- Pendaftar -->
                <a href="{{ route('pembina.pendaftar') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs(['pembina.pendaftar', 'pembina.pendaftar.*'])
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>

                    <span class="text-sm">Pendaftar</span>
                </a>

                <!-- Anggota -->
                <a href="{{ route('pembina.anggota') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs(['pembina.anggota', 'pembina.anggota.*'])
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    <svg class="shrink-0" width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 16V13.2C0 12.6333 0.145833 12.1125 0.4375 11.6375C0.729167 11.1625 1.11667 10.8 1.6 10.55C2.63333 10.0333 3.68333 9.64583 4.75 9.3875C5.81667 9.12917 6.9 9 8 9C9.1 9 10.1833 9.12917 11.25 9.3875C12.3167 9.64583 13.3667 10.0333 14.4 10.55C14.8833 10.8 15.2708 11.1625 15.5625 11.6375C15.8542 12.1125 16 12.6333 16 13.2V16H0V16M18 16V13C18 12.2667 17.7958 11.5625 17.3875 10.8875C16.9792 10.2125 16.4 9.63333 15.65 9.15C16.5 9.25 17.3 9.42083 18.05 9.6625C18.8 9.90417 19.5 10.2 20.15 10.55C20.75 10.8833 21.2083 11.2542 21.525 11.6625C21.8417 12.0708 22 12.5167 22 13V16H18V16M8 8C6.9 8 5.95833 7.60833 5.175 6.825C4.39167 6.04167 4 5.1 4 4C4 2.9 4.39167 1.95833 5.175 1.175C5.95833 0.391667 6.9 0 8 0C9.1 0 10.0417 0.391667 10.825 1.175C11.6083 1.95833 12 2.9 12 4C12 5.1 11.6083 6.04167 10.825 6.825C10.0417 7.60833 9.1 8 8 8V8M18 4C18 5.1 17.6083 6.04167 16.825 6.825C16.0417 7.60833 15.1 8 14 8C13.8167 8 13.5833 7.97917 13.3 7.9375C13.0167 7.89583 12.7833 7.85 12.6 7.8C13.05 7.26667 13.3958 6.675 13.6375 6.025C13.8792 5.375 14 4.7 14 4C14 3.3 13.8792 2.625 13.6375 1.975C13.3958 1.325 13.05 0.733333 12.6 0.2C12.8333 0.116667 13.0667 0.0625 13.3 0.0375C13.5333 0.0125 13.7667 0 14 0C15.1 0 16.0417 0.391667 16.825 1.175C17.6083 1.95833 18 2.9 18 4V4M2 14H14V13.2C14 13.0167 13.9542 12.85 13.8625 12.7C13.7708 12.55 13.65 12.4333 13.5 12.35C12.6 11.9 11.6917 11.5625 10.775 11.3375C9.85833 11.1125 8.93333 11 8 11C7.06667 11 6.14167 11.1125 5.225 11.3375C4.30833 11.5625 3.4 11.9 2.5 12.35C2.35 12.4333 2.22917 12.55 2.1375 12.7C2.04583 12.85 2 13.0167 2 13.2V14V14M8 6C8.55 6 9.02083 5.80417 9.4125 5.4125C9.80417 5.02083 10 4.55 10 4C10 3.45 9.80417 2.97917 9.4125 2.5875C9.02083 2.19583 8.55 2 8 2C7.45 2 6.97917 2.19583 6.5875 2.5875C6.19583 2.97917 6 3.45 6 4C6 4.55 6.19583 5.02083 6.5875 5.4125C6.97917 5.80417 7.45 6 8 6V6Z" fill="white"/>
                    </svg>

                    <span class="text-sm">Anggota</span>
                </a>

                <!-- Jadwal Latihan -->
                <a href="{{ route('pembina.jadwal-latihan') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs(['pembina.jadwal-latihan', 'pembina.jadwal-latihan.*'])
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>

                    <span class="text-sm">Jadwal Latihan</span>
                </a>

                <!-- Pengumuman -->
                <a href="{{ route('pembina.pengumuman') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs(['pembina.pengumuman', 'pembina.pengumuman.*'])
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    <svg class="shrink-0" width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 9V7H20V9H16V9M17.2 16L14 13.6L15.2 12L18.4 14.4L17.2 16V16M15.2 4L14 2.4L17.2 0L18.4 1.6L15.2 4V4M3 15V11H2C1.45 11 0.979167 10.8042 0.5875 10.4125C0.195833 10.0208 0 9.55 0 9V7C0 6.45 0.195833 5.97917 0.5875 5.5875C0.979167 5.19583 1.45 5 2 5H6L11 2V14L6 11H5V15H3V15M9 10.45V5.55L6.55 7H2V9H6.55L9 10.45V10.45M12 11.35V4.65C12.45 5.05 12.8125 5.5375 13.0875 6.1125C13.3625 6.6875 13.5 7.31667 13.5 8C13.5 8.68333 13.3625 9.3125 13.0875 9.8875C12.8125 10.4625 12.45 10.95 12 11.35V11.35Z" fill="white"/>
                    </svg>

                    <span class="text-sm">Pengumuman</span>
                </a>

                <!-- Laporan -->
                <a href="{{ route('pembina.laporan') }}"
                   class="flex items-center space-x-3 px-6 py-3 border-l-4 transition-all
                   {{ request()->routeIs(['pembina.laporan', 'pembina.laporan.*'])
                        ? 'text-amber-500 font-medium bg-[#141d2b] border-amber-500'
                        : 'text-gray-400 hover:text-gray-200 hover:bg-[#141d2b]/50 border-transparent' }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>

                    <span class="text-sm">Laporan</span>
                </a>
            </nav>
        </div>

        <!-- Footer / Logout -->
        <div class="border-t border-gray-800/80 p-4">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit"
                    class="w-full flex items-center space-x-3 px-3 py-2 text-gray-400 hover:text-red-400 transition-colors cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT AREA ================= -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Topbar (Sticky di Atas) -->
        <header class="sticky top-0 z-30 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
            <!-- Left Header Content: Hamburger + Dynamic Title -->
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger Button (Khusus Mobile/Tablet) -->
                <button
                    type="button"
                    onclick="openSidebar()"
                    class="cursor-pointer rounded-md p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none lg:hidden"
                    aria-label="Buka Menu"
                >
                    <svg class="pointer-events-none h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h2 class="truncate text-base sm:text-lg font-semibold text-gray-800">
                    @yield('header_title', 'Dashboard')
                </h2>
            </div>

            <!-- Right Header Actions (Icons) -->
            <div class="flex items-center space-x-3 sm:space-x-4 shrink-0">
                <!-- Notification Bell Icon -->
                <div class="relative" x-data="{ openNotif: false }">
                    <button @click="openNotif = !openNotif" class="relative text-gray-600 hover:text-gray-900 focus:outline-none p-1.5 rounded-full hover:bg-gray-100 transition-colors cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        
                        {{-- Badge Merah Kalau Ada Notif --}}
                        @if(isset($notifikasiPembinas) && $notifikasiPembinas->count() > 0)
                            <span class="absolute top-0 right-0 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white">
                                {{ $notifikasiPembinas->count() }}
                            </span>
                        @endif
                    </button>

                    {{-- DROPDOWN NOTIFIKASI (Responsif di layar HP) --}}
                    <div x-show="openNotif" @click.outside="openNotif = false" x-transition
                         class="fixed inset-x-4 top-16 sm:absolute sm:inset-x-auto sm:right-0 sm:top-full z-[100] mt-2 sm:w-[380px] overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
                         style="display: none;">
                         
                        {{-- Header Notifikasi --}}
                        <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-slate-800">Notifikasi Pembina</h3>
                                @if(isset($notifikasiPembinas) && $notifikasiPembinas->count() > 0)
                                    <span class="bg-amber-400 text-slate-900 text-[10px] font-bold px-2 py-0.5 rounded-md">{{ $notifikasiPembinas->count() }} Baru</span>
                                @endif
                            </div>
                            <button @click="openNotif = false" class="text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        {{-- List Notifikasi --}}
                        <div class="max-h-[350px] overflow-y-auto divide-y divide-gray-100">
                            @forelse($notifikasiPembinas ?? [] as $notif)
                                <div class="p-4 hover:bg-slate-50 transition relative">
                                    <div class="flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-[#1a2b4c] text-amber-400 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-user-plus text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-1">
                                                <h4 class="text-xs font-bold text-slate-800">Pengajuan Anggota Baru</h4>
                                                <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">Perlu Respon</span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                                <strong>{{ $notif->member->nama ?? 'Siswa' }}</strong> mendaftar ke <strong>{{ $notif->ekstrakurikuler->nama ?? '-' }}</strong>.
                                            </p>
                                            <div class="flex items-center gap-2 mt-3">
                                                <a href="{{ route('pembina.pendaftar') }}" class="bg-[#1a2b4c] text-white text-[10px] font-bold px-2.5 py-1 rounded hover:bg-[#0f1c33]">Proses</a>
                                                <span class="text-[10px] text-gray-400 flex items-center gap-1"><i class="fa-regular fa-clock"></i> {{ $notif->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <p class="text-xs text-gray-500">Belum ada notifikasi baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Profile User Icon -->
                <a href="{{ route('pembina.profil') }}" class="text-gray-600 hover:text-gray-900 focus:outline-none p-1.5 rounded-full hover:bg-gray-100 transition-colors" title="Profil Saya">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="flex-1 p-4 sm:p-6 bg-gray-50">
            @yield('content')
        </main>
        
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function openSidebar() {
            document.getElementById('pembinaSidebar').classList.add('is-open');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        }

        function closeSidebar() {
            document.getElementById('pembinaSidebar').classList.remove('is-open');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        }
    </script>
</body>
</html>