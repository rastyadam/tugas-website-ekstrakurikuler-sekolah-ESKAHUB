@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">


    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
        <strong>Oops! Ada yang salah:</strong>
        <ul class="list-disc list-inside text-sm mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Siswa</h1>
            <p class="text-sm text-slate-500">Kelola data siswa terdaftar.</p>
        </div>
        
        {{-- Form Import Excel --}}
        <form action="{{ route('admin.datasiswa.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" required class="text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-bold">
                Import Excel
            </button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

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
                           <a href="{{ route('admin.datasiswa.show', $s->id) }}" class="text-xs font-medium text-slate-600 hover:text-slate-900 bg-slate-100 px-3 py-1.5 rounded-lg transition hover:bg-slate-200">
    Detail
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $siswas->links() }}</div>
</div>
@endsection