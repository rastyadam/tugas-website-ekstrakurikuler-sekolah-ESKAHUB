@extends('pembina.layouts.app')

@section('content')
<div class="min-h-screen bg-white text-gray-800 font-sans">
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-8 py-8">
        
        <!-- Page Header & Export Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Anggota</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola siswa yang diterima di ekstrakurikuler Anda.</p>
            </div>

            <div>
                <a href="{{ route('pembina.anggota.export') }}" 
                   class="inline-flex items-center gap-2 bg-[#111827] hover:bg-gray-800 text-white text-xs font-medium px-4 py-2.5 rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <form method="GET" action="{{ route('pembina.anggota') }}" class="flex flex-wrap items-center gap-3 mb-6">
            
            <!-- Filter Kelas (Bisa kamu dinamiskan nanti, sementara hardcode dulu) -->
            <div class="relative">
                <select name="kelas" onchange="this.form.submit()" 
                        class="appearance-none bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-md pl-8 pr-4 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 cursor-pointer">
                    <option value="">Semua Kelas</option>
                    <option value="X RPL 1" {{ request('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1</option>
                    <option value="XI TKJ 2" {{ request('kelas') == 'XI TKJ 2' ? 'selected' : '' }}>XI TKJ 2</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-gray-700">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                    </svg>
                </div>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau NISN..." 
                    class="w-full bg-white border border-gray-300 text-gray-700 placeholder-gray-400 text-xs rounded-md pl-8 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400"
                >
            </div>
            
            <button type="submit" class="hidden">Cari</button>
        </form>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#dcdfe4] text-[#374151] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-6 text-center sm:text-left sm:pl-24">DETAIL ANGGOTA</th>
                        <th class="py-3.5 px-6">EKSTRAKURIKULER</th>
                        <th class="py-3.5 px-6">KELAS</th>
                        <th class="py-3.5 px-6">TANGGAL BERGABUNG</th>
                        <th class="py-3.5 px-6 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse ($members as $member)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <!-- Detail Anggota -->
                            <td class="py-4 px-6 sm:pl-20">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-[#d9e4fc] text-[#1e293b] font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($member->member->nama ?? 'S', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">
                                            {{ $member->member->nama ?? 'Siswa' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ $member->member->nisn ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Ekstrakurikuler -->
                            <td class="py-4 px-6 text-xs text-gray-600 font-medium">
                                {{ $member->ekstrakurikuler->nama ?? '-' }}
                            </td>

                            <!-- Kelas Badge -->
                            <td class="py-4 px-6">
                                <span class="inline-block bg-[#dcdfe4] text-gray-700 text-[11px] font-medium px-2.5 py-1 rounded">
                                    {{ $member->member->kelas ?? '-' }}
                                </span>
                            </td>

                            <!-- Tanggal Bergabung -->
                            <td class="py-4 px-6 text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($member->tanggal_daftar)->format('d M Y') }}
                            </td>

                            <!-- Aksi (Three Dots Menu) -->
                            <td class="py-4 px-6 text-center relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false" type="button" class="text-gray-600 hover:text-gray-900 p-1 rounded-full focus:outline-none">
                                    <svg class="w-4 h-4 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Aksi -->
                                <div x-show="open" x-transition style="display: none;" 
                                     class="origin-top-right absolute right-12 mt-1 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 text-left">
                                    <div class="py-1 text-xs text-gray-700">
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Lihat Detail</a>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit Siswa</a>
                                        <button type="button" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Hapus</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-500">
                                Tidak ada data anggota yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $members->links() }}
        </div>

    </main>
</div>
@endsection