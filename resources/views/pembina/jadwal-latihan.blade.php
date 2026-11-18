@extends('pembina.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <h1 class="text-2xl font-bold text-slate-800">Jadwal Latihan Ekstrakurikuler</h1>
        <p class="text-sm text-slate-500">Atur jadwal latihan rutin untuk ekskul yang Anda ampu.</p>
    </div>

    @foreach($ekskuls as $ekskul)
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <h2 class="text-lg font-bold text-slate-800">{{ $ekskul->nama }}</h2>
            <button onclick="openModal({{ $ekskul->id }}, '{{ $ekskul->nama }}')" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                + Tambah Jadwal
            </button>
        </div>

        {{-- Daftar Jadwal Latihan --}}
        @if($ekskul->jadwalLatihan->isEmpty())
            <p class="text-sm text-slate-400 italic">Belum ada jadwal latihan untuk ekskul ini.</p>
        @else
            <div class="space-y-3">
                @foreach($ekskul->jadwalLatihan as $jadwal)
                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 flex flex-col items-center justify-center shrink-0">
                        <span class="text-[10px] font-bold uppercase">{{ substr($jadwal->hari, 0, 3) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">{{ $jadwal->jenis_latihan }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</p>
                        <p class="text-xs text-slate-500">{{ $jadwal->tempat }} • {{ $jadwal->keterangan ?? '-' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    @endforeach
</div>

{{-- MODAL TAMBAH JADWAL --}}
<div id="modalJadwal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Tambah Jadwal Latihan: <span id="modalEkskulName" class="text-amber-500"></span></h2>
        <form id="formJadwal" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Latihan</label>
                    <input type="text" name="jenis_latihan" placeholder="Misal: Latihan Rutin" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Hari</label>
                        <select name="hari" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tempat</label>
                        <input type="text" name="tempat" placeholder="Misal: Lapangan" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-xl border-gray-300 p-2.5 text-sm"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalJadwal');
    const form = document.getElementById('formJadwal');
    const nameSpan = document.getElementById('modalEkskulName');

    function openModal(id, nama) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        form.action = `/pembina/jadwal-latihan/${id}`;
        nameSpan.innerText = nama;
    }
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection