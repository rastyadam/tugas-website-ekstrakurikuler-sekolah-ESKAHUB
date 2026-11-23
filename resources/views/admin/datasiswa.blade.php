@extends('admin.layout')

@section('title', 'Data Siswa - EskaHub')

@section('header-title')
    <h1 class="text-[28px] font-bold tracking-tight text-[#14212E] leading-tight">
        Data Siswa
    </h1>
    <p class="mt-1 text-sm font-normal text-[#475361]">
        Kelola direktori siswa, NISN, status registrasi, dan penugasan kelas akademik.
    </p>
@endsection

@section('content')
<div class="mt-4 space-y-6">

    {{-- Alert --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
            <strong>Oops! Ada yang salah:</strong>
            <ul class="list-disc list-inside text-sm mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Ekspor & Import --}}
    <div class="flex flex-wrap items-center justify-start gap-3">
       <a href="{{ route('admin.datasiswa.export', request()->only(['search', 'kelas'])) }}" 
   class="inline-flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
    <i class="fa-solid fa-download text-slate-500"></i> Ekspor Data
</a>
        
        <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
            @csrf
            <label class="inline-flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm cursor-pointer">
                <i class="fa-solid fa-upload text-slate-500"></i> Import Data Siswa
                <input type="file" name="file" required class="hidden" onchange="this.form.submit()">
            </label>
        </form>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-3">
        <form action="{{ route('admin.datasiswa.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan Nama, NISN, atau NIS..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-slate-800 focus:ring-1 focus:ring-slate-800 transition">
            </div>

            <div class="relative min-w-[200px]">
                <select name="kelas" onchange="this.form.submit()" class="w-full appearance-none pl-4 pr-10 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:border-slate-800 transition cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @foreach($daftarKelas as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>

            <button type="submit" class="px-5 py-2 bg-[#14212E] hover:bg-[#0f1a24] text-white rounded-lg text-sm font-semibold transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                        <th class="py-3 px-4">NISN</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Kelas & Jurusan</th>
                        <th class="py-3 px-4">Kontak</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($siswas as $s)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4 font-mono text-xs text-slate-600">{{ $s->nisn }}</td>
                        <td class="py-3 px-4">
                            <div class="font-semibold text-slate-800">{{ $s->nama }}</div>
                            <div class="text-xs text-slate-400">{{ $s->email }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-slate-700">{{ $s->kelas }}</div>
                            <div class="text-xs text-slate-400">{{ $s->jurusan }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-600 text-xs">
                            {{ $s->no_hp ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('admin.datasiswa.show', $s->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg transition hover:bg-slate-200">
                                Detail <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-folder-open text-3xl text-slate-300 mb-3"></i>
                                <p class="font-semibold text-slate-600">Data siswa tidak ditemukan.</p>
                                <p class="text-xs mt-1">Coba ubah kata kunci pencarian atau filter kelas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-end gap-1.5 pt-2">
        {{ $siswas->links() }}
    </div>
</div>
@endsection