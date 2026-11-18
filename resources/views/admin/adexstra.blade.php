@extends('admin.layout')

@section('title', 'Ekstrakurikuler Admin - EskaHub')

@section('content')
<div class="min-h-screen bg-white px-6 py-8 sm:px-10 lg:px-12 relative">
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        {{-- TOP NAVIGATION / HEADER UTAMA --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-slate-900">Data Ekstrakurikuler</h1>
                <p class="text-xs text-gray-500">
                    Kelola direktori kegiatan, pembina pendamping, jadwal latihan, dan kuota anggota aktif.
                </p>
            </div>
        </div>

        {{-- ACTION BUTTONS & FILTER TOOLBAR --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pt-2">
            {{-- SEARCH BAR --}}
            <div class="relative flex-1 max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fa-solid fa-magnifying-glass text-xs text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    placeholder="Cari nama ekstrakurikuler, pembina, atau hari..." 
                    class="w-full rounded-xl border border-gray-200 bg-white py-2 pl-9 pr-4 text-xs text-gray-700 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 placeholder:text-gray-400"
                />
            </div>

            {{-- ACTIONS & FILTERS --}}
            <div class="flex flex-wrap items-center gap-3">
                <select class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs text-gray-600 focus:outline-none">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>

                <select class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs text-gray-600 focus:outline-none">
                    <option>Urutan: Nama (A - Z)</option>
                    <option>Urutan: Nama (Z - A)</option>
                </select>

                <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-slate-700 shadow-sm hover:bg-gray-50">
                    <i class="fa-solid fa-download text-gray-500"></i>
                    Ekspor Data
                </button>

                {{-- TOMBOL TAMBAH (Buka Modal) --}}
                <button onclick="openModal()" class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-600 transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Ekstrakurikuler
                </button>
            </div>
        </div>

        {{-- TABLE DATA --}}
        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-gray-100 text-[11px] font-bold tracking-wider text-slate-600 uppercase">
                        <th class="py-3.5 px-4">NAMA EKSTRAKURIKULER & BIDANG</th>
                        <th class="py-3.5 px-4">PEMBINA / PELATIH</th>
                        <th class="py-3.5 px-4">KUOTA ANGGOTA</th>
                        <th class="py-3.5 px-4">STATUS</th>
                        <th class="py-3.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs">

                    @forelse($ekskuls as $ekskul)
                    <tr class="hover:bg-slate-50/50 transition group">
                        
                        {{-- Kolom Nama & Deskripsi --}}
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $ekskul->nama }}</div>
                            <div class="text-[11px] text-gray-500 line-clamp-1 max-w-[250px]">{{ $ekskul->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                        </td>

                        {{-- Kolom Pembina --}}
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-800">{{ $ekskul->pembina->nama ?? 'Belum ditentukan' }}</div>
                            <div class="text-[11px] text-gray-400">{{ $ekskul->pembina->jenis_pembina ?? 'Pelatih' }}</div>
                        </td>

                        {{-- Kolom Kuota Dinamis --}}
                        <td class="py-4 px-4 min-w-[130px]">
                            @php
                                $totalKuota = $ekskul->kuota;
                                $terisi = $ekskul->terisi ?? 0;
                                $sisa = max(0, $totalKuota - $terisi);
                                $persentase = $totalKuota > 0 ? ($terisi / $totalKuota) * 100 : 0;
                                $warnaBar = $sisa > 0 ? 'bg-emerald-500' : 'bg-rose-500';
                            @endphp

                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold text-slate-800">{{ $sisa }} Sisa</span>
                                <span class="text-gray-500">/ {{ $totalKuota }}</span>
                            </div>
                            
                            <div class="h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full {{ $warnaBar }} rounded-full transition-all duration-300" style="width: {{ $persentase }}%;"></div>
                            </div>
                        </td>

                        {{-- Kolom Status --}}
                        <td class="py-4 px-4">
                            @if($ekskul->status == 'aktif')
                                <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 font-semibold text-rose-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="py-4 px-4 text-right">
                            <div class="inline-flex items-center gap-3 font-medium">
                                <button onclick="editModal({{ $ekskul }})" class="text-blue-600 hover:text-blue-800">Ubah</button>
                                
                                <form action="{{ route('admin.adexstra.destroy', $ekskul->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ekstrakurikuler ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-folder-open text-2xl text-slate-400"></i>
                                </div>
                                <p class="font-semibold text-slate-600">Belum ada data ekstrakurikuler</p>
                                <p class="text-xs mt-1 text-gray-400">Silakan tambahkan data baru dengan tombol di atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        <div class="flex items-center justify-end gap-1.5 pt-2">
            {{ $ekskuls->links() }}
        </div>

    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL POP-UP UNTUK CRUD --}}
{{-- ========================================== --}}
<div id="crudModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm transition-all duration-300">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
        
        {{-- Header Modal --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/50">
            <h2 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Ekstrakurikuler</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        {{-- Form --}}
        <form id="crudForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div id="methodField"></div>

            <div class="space-y-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Nama Ekstrakurikuler <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="inputNama" required class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="inputDeskripsi" rows="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Kuota <span class="text-rose-500">*</span></label>
                        <input type="number" name="kuota" id="inputKuota" required min="1" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Status <span class="text-rose-500">*</span></label>
                        <select name="status" id="inputStatus" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all bg-white">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Pembina / Pelatih</label>
                    <select name="pembina_id" id="inputPembina" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all bg-white">
                        <option value="">-- Pilih Pembina --</option>
                        @foreach($pembinas as $pembina)
                            <option value="{{ $pembina->id }}">{{ $pembina->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Foto Banner (Opsional)</label>
                    <input type="file" name="foto" id="inputFoto" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition-all cursor-pointer border border-gray-300 rounded-xl">
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-md transition active:scale-95">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT UNTUK MODAL & INTERAKSI --}}
<script>
    const modal = document.getElementById('crudModal');
    const modalContent = document.getElementById('modalContent');
    const form = document.getElementById('crudForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);

        modalTitle.innerText = 'Tambah Ekstrakurikuler';
        form.action = "{{ route('admin.adexstra.store') }}";
        form.reset();
        methodField.innerHTML = '';
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function editModal(data) {
        openModal(); 
        modalTitle.innerText = 'Edit Ekstrakurikuler';
        
        form.action = `/admin/adexstra/${data.id}`;
        methodField.innerHTML = '@method("PUT")';

        document.getElementById('inputNama').value = data.nama;
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';
        document.getElementById('inputKuota').value = data.kuota;
        document.getElementById('inputStatus').value = data.status;
        document.getElementById('inputPembina').value = data.pembina_id || '';
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endsection