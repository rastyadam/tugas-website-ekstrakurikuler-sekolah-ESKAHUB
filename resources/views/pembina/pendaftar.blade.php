@extends('pembina.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Daftar Pendaftar</h1>
        <p class="text-sm text-slate-500">Kelola siswa yang mendaftar ke ekstrakurikuler yang Anda ampu.</p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Ekstrakurikuler</th>
                        <th class="py-3 px-4">Berkas</th>
                        <th class="py-3 px-4">Tanggal Daftar</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($pendaftarans as $p)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3 px-4">
                            <div class="font-semibold text-slate-800">{{ $p->member->nama ?? 'Siswa' }}</div>
                            <div class="text-xs text-slate-400">{{ $p->member->nisn ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $p->ekstrakurikuler->nama ?? '-' }}</td>
                        <td class="py-3 px-4">
                            @if($p->detailPersyaratan && $p->detailPersyaratan->berkas)
                                <a href="{{ asset('storage/' . $p->detailPersyaratan->berkas) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat
                                </a>
                            @else
                                <span class="text-[11px] text-slate-400 italic">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-slate-500 text-xs">
                            {{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4">
                            @if($p->status == 'pending')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">Pending</span>
                            @elseif($p->status == 'diterima')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">Diterima</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800">Ditolak</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if($p->status == 'pending')
                                <div class="inline-flex gap-2 items-center">
                                    <button onclick="openJadwalModal({{ $p->id }})" class="text-xs font-bold text-amber-600 hover:text-amber-800 bg-amber-50 px-2 py-1 rounded">Atur Seleksi</button>
                                    
                                    <form action="{{ route('pembina.pendaftar.terima-langsung', $p->id) }}" method="POST" onsubmit="return confirm('Yakin terima tanpa seleksi?')">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">Terima Langsung</button>
                                    </form>
                                    
                                    <button onclick="openTolakModal({{ $p->id }})" class="text-xs font-bold text-rose-600 hover:text-rose-800">Tolak</button>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">Belum ada siswa yang mendaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div>{{ $pendaftarans->links() }}</div>
</div>

{{-- ========================================== --}}
{{-- MODAL TOLAK --}}
{{-- ========================================== --}}
<div id="modalTolak" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Alasan Penolakan</h2>
        <form id="formTolak" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="ditolak">
            <textarea name="alasan_penolakan" required rows="3" class="w-full rounded-xl border border-gray-300 p-3 text-sm focus:ring-rose-500 focus:border-rose-500" placeholder="Tulis alasan penolakan..."></textarea>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="closeTolakModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-rose-500 hover:bg-rose-600 rounded-xl">Tolak Pendaftaran</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL ATUR JADWAL SELEKSI --}}
{{-- ========================================== --}}
<div id="modalJadwal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-4">Atur Jadwal Seleksi</h2>
        <form id="formJadwal" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tahap Seleksi</label>
                    <input type="text" name="tahap_seleksi" placeholder="Misal: Tes Tulis, Wawancara" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
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
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tempat</label>
                    <input type="text" name="tempat" placeholder="Misal: Lapangan Basket" required class="w-full rounded-xl border-gray-300 p-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="2" class="w-full rounded-xl border-gray-300 p-2.5 text-sm"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="closeJadwalModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Tolak
    const modalTolak = document.getElementById('modalTolak');
    const formTolak = document.getElementById('formTolak');
    
    function openTolakModal(id) {
        modalTolak.classList.remove('hidden');
        modalTolak.classList.add('flex');
        formTolak.action = `/pembina/pendaftar/${id}/status`;
    }
    function closeTolakModal() {
        modalTolak.classList.add('hidden');
        modalTolak.classList.remove('flex');
    }

    // Modal Jadwal
    const modalJadwal = document.getElementById('modalJadwal');
    const formJadwal = document.getElementById('formJadwal');

    function openJadwalModal(id) {
        modalJadwal.classList.remove('hidden');
        modalJadwal.classList.add('flex');
        formJadwal.action = `/pembina/pendaftar/${id}/jadwal`;
    }
    function closeJadwalModal() {
        modalJadwal.classList.add('hidden');
        modalJadwal.classList.remove('flex');
    }
</script>
@endsection