@extends('pembina.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Pengumuman</h1>
            <p class="text-sm text-slate-500">Buat informasi penting yang akan muncul di halaman siswa.</p>
        </div>
        <button onclick="openModal()" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition">
            + Buat Pengumuman
        </button>
    </div>

    {{-- Daftar Pengumuman --}}
    <div class="space-y-4">
        @forelse($pengumumans as $p)
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700">
                            {{ $p->ekstrakurikuler->nama ?? 'Umum' }}
                        </span>
                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">{{ $p->judul }}</h3>
                    <p class="text-sm text-slate-600 mt-1 line-clamp-2">{{ $p->isi }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">
            <p class="text-slate-500">Belum ada pengumuman yang dibuat.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL BUAT PENGUMUMAN --}}
<div id="modalPengumuman" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Buat Pengumuman Baru</h2>
        <form action="{{ route('pembina.pengumuman.store') }}" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Ekstrakurikuler</label>
                    <select name="ekstrakurikuler_id" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                        <option value="">-- Pilih Ekskul --</option>
                        @foreach($ekskuls as $ekskul)
                            <option value="{{ $ekskul->id }}">{{ $ekskul->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" placeholder="Misal: Latihan Diliburkan" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Isi Pengumuman</label>
                    <textarea name="isi" rows="4" placeholder="Tulis detail informasinya di sini..." required class="w-full rounded-xl border-gray-300 p-2.5 text-sm"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl">Kirim Pengumuman</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalPengumuman');
    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection