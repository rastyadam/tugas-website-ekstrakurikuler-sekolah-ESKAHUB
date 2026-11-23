@extends('pembina.layouts.app')

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 tracking-tight">Anggota</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola siswa yang diterima di ekstrakurikuler Anda.</p>
            </div>

            <div class="shrink-0">
                <a href="{{ route('pembina.anggota.export') }}"
                   class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-gray-900 hover:bg-gray-800 text-white text-xs font-medium px-3.5 py-2 rounded-md transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <form method="GET" action="{{ route('pembina.anggota') }}" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
            <div class="relative w-full sm:w-44">
                <select name="kelas"
                        onchange="this.form.submit()"
                        aria-label="Filter Kelas"
                        class="w-full appearance-none bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-md pl-3 pr-8 py-2 focus:outline-none focus:border-gray-500 cursor-pointer">
                    <option value="">Semua Kelas</option>
                    <option value="X RPL 1" {{ request('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1</option>
                    <option value="XI TKJ 2" {{ request('kelas') == 'XI TKJ 2' ? 'selected' : '' }}>XI TKJ 2</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <div class="relative w-full sm:w-64">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau NISN..."
                       class="w-full bg-white border border-gray-300 text-gray-800 placeholder-gray-400 text-xs rounded-md pl-9 pr-3 py-2 focus:outline-none focus:border-gray-500">
            </div>

            @if(request('kelas') || request('search'))
                <a href="{{ route('pembina.anggota') }}"
                   class="text-xs text-gray-500 hover:text-gray-800 underline underline-offset-2 self-start sm:self-center">
                    Reset
                </a>
            @endif

            <button type="submit" class="hidden">Cari</button>
        </form>

        <!-- Tampilan Mobile (Card Ringkas) -->
        <div class="space-y-3 md:hidden">
            @forelse ($members as $member)
                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-md bg-blue-50 text-blue-900 font-semibold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($member->member->nama ?? 'S', 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $member->member->nama ?? 'Siswa' }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    NISN: {{ $member->member->nisn ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="relative shrink-0" x-data="{ open: false }">
                            <button type="button"
                                    @click="open = !open"
                                    @click.outside="open = false"
                                    class="p-1.5 text-gray-500 hover:text-gray-800 rounded-md hover:bg-gray-100"
                                    aria-label="Menu aksi">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition
                                 style="display: none;"
                                 class="origin-top-right absolute right-0 mt-1 w-36 rounded-md shadow-md bg-white border border-gray-200 py-1 z-20 text-xs text-gray-700">
                                <a href="#" class="block px-3.5 py-2 hover:bg-gray-50">Lihat Detail</a>
                                <a href="#" class="block px-3.5 py-2 hover:bg-gray-50">Edit Siswa</a>
                                <button type="button" class="block w-full text-left px-3.5 py-2 text-red-600 hover:bg-gray-50">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100 grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <span class="text-gray-400 block">Ekstrakurikuler</span>
                            <span class="text-gray-700 font-medium">{{ $member->ekstrakurikuler->nama ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block">Kelas</span>
                            <span class="inline-block mt-0.5 bg-gray-100 text-gray-700 font-medium px-2 py-0.5 rounded">
                                {{ $member->member->kelas ?? '-' }}
                            </span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-400">Bergabung:</span>
                            <span class="text-gray-600 ml-1">{{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="border border-gray-200 rounded-lg py-8 px-4 text-center text-sm text-gray-500">
                    Tidak ada data anggota yang ditemukan.
                </div>
            @endforelse
        </div>

        <!-- Tampilan Desktop / Tablet (Tabel) -->
        <div class="hidden md:block overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/90 text-gray-600 text-[11px] font-semibold uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-4">Detail Anggota</th>
                        <th class="py-3 px-4">Ekstrakurikuler</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Tanggal Bergabung</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm bg-white">
                    @forelse ($members as $member)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-md bg-blue-50 text-blue-900 font-semibold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($member->member->nama ?? 'S', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 leading-snug">
                                            {{ $member->member->nama ?? 'Siswa' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $member->member->nisn ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-xs font-medium text-gray-700">
                                {{ $member->ekstrakurikuler->nama ?? '-' }}
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="inline-block bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $member->member->kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-xs text-gray-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d M Y') }}
                            </td>

                            <td class="py-3.5 px-4 text-right relative" x-data="{ open: false }">
                                <button type="button"
                                        @click="open = !open"
                                        @click.outside="open = false"
                                        class="p-1.5 text-gray-500 hover:text-gray-800 rounded-md hover:bg-gray-100 inline-flex items-center justify-center"
                                        aria-label="Menu aksi">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>

                                <div x-show="open"
                                     x-transition
                                     style="display: none;"
                                     class="origin-top-right absolute right-4 mt-1 w-36 rounded-md shadow-md bg-white border border-gray-200 py-1 z-20 text-left text-xs text-gray-700">
                                    <a href="#" class="block px-3.5 py-2 hover:bg-gray-50">Lihat Detail</a>
                                    <a href="#" class="block px-3.5 py-2 hover:bg-gray-50">Edit Siswa</a>
                                    <button type="button" class="block w-full text-left px-3.5 py-2 text-red-600 hover:bg-gray-50">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-sm text-gray-500">
                                Tidak ada data anggota yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($members->hasPages())
            <div class="mt-5">
                {{ $members->withQueryString()->links() }}
            </div>
        @endif

    </main>
</div>
@endsection