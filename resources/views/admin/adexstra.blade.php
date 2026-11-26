@extends('admin.layout')

@section('title', 'Ekstrakurikuler Admin - EskaHub')

@section('header-title')
    <h1 class="text-[28px] font-bold tracking-tight text-[#14212E] leading-tight">
        Data Ekstrakurikuler
    </h1>
    <p class="mt-1 text-sm font-normal text-[#475361]">
        Kelola direktori kegiatan, pembina pendamping, jadwal latihan, dan kuota anggota aktif.
    </p>
@endsection

@section('content')
  @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <p class="font-bold mb-2">Terjadi kesalahan:</p>

        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="mt-4 space-y-6 relative">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-semibold flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

   {{-- ACTION BUTTONS --}}
<div class="flex flex-wrap items-center justify-start gap-3">
    <a href="{{ route('admin.adexstra.export', request()->only(['search', 'status', 'sort'])) }}"
       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-gray-50 transition">
        <i class="fa-solid fa-download text-gray-500"></i> Ekspor Data
    </a>
    <button onclick="openModal()" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-amber-600 transition active:scale-95">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Ekstrakurikuler
    </button>
</div>

    {{-- TOOLBAR: SEARCH & FILTER --}}
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
        
        {{-- SEARCH BAR --}}
        <div class="relative flex-1 max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fa-solid fa-magnifying-glass text-sm text-gray-400"></i>
            </div>
            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama ekstrakurikuler, deskripsi, atau pembina..." 
                class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-9 pr-16 text-sm text-gray-700 focus:border-slate-800 focus:outline-none focus:ring-1 focus:ring-slate-800 placeholder:text-gray-400 transition"
            />
            @if(request('search') || request('status') || request('sort'))
                <a href="{{ url()->current() }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-xs font-semibold text-rose-500 hover:text-rose-700">
                    Reset
                </a>
            @endif
        </div>

        {{-- FILTERS --}}
        <div class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-600 focus:border-slate-800 focus:outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <select name="sort" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-600 focus:border-slate-800 focus:outline-none cursor-pointer">
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Urutan: Nama (A - Z)</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Urutan: Nama (Z - A)</option>
            </select>
        </div>
    </form>

    {{-- TABLE DATA --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-200 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                    <th class="py-3.5 px-4 w-10 text-center"></th>
                    <th class="py-3.5 px-4">NAMA EKSTRAKURIKULER & BIDANG</th>
                    <th class="py-3.5 px-4">PEMBINA / PELATIH</th>
                    <th class="py-3.5 px-4">KUOTA ANGGOTA</th>
                    <th class="py-3.5 px-4">STATUS</th>
                    <th class="py-3.5 px-4 text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($ekskuls as $ekskul)
                <tr class="hover:bg-slate-50/50 transition group">
                    <td class="py-4 px-4 text-center"></td>
                    
                    {{-- Nama & Deskripsi --}}
                    <td class="py-4 px-4">
                        <div class="font-bold text-slate-900">{{ $ekskul->nama }}</div>
                        <div class="text-xs text-gray-500 line-clamp-1 max-w-[250px]">{{ $ekskul->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                    </td>

                    {{-- Pembina --}}
                    <td class="py-4 px-4">
                        <div class="font-medium text-slate-800">{{ $ekskul->pembina->nama ?? 'Belum ditentukan' }}</div>
                        <div class="text-[11px] text-gray-400 capitalize">{{ $ekskul->pembina->jenis_pembina ?? 'Pelatih' }}</div>
                    </td>

                    {{-- Kuota Dinamis --}}
                    <td class="py-4 px-4 min-w-[140px]">
                        @php
                            $totalKuota = $ekskul->kuota;
                            $terisi = $ekskul->terisi ?? 0;
                            $sisa = max(0, $totalKuota - $terisi);
                            $persentase = $totalKuota > 0 ? ($terisi / $totalKuota) * 100 : 0;
                            $warnaBar = $sisa > 0 ? 'bg-emerald-500' : 'bg-rose-500';
                        @endphp

                        <div class="flex items-center gap-1 text-xs mb-1">
                            <span class="font-bold text-slate-800">{{ $terisi }} / {{ $totalKuota }}</span>
                            @if($sisa > 0)
                                <span class="text-[10px] text-emerald-600">(Sisa: {{ $sisa }})</span>
                            @else
                                <span class="text-[10px] text-rose-500 font-semibold">Penuh</span>
                            @endif
                        </div>
                        
                        <div class="h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full {{ $warnaBar }} rounded-full transition-all duration-300" style="width: {{ $persentase }}%;"></div>
                        </div>
                    </td>

                    {{-- Status --}}
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

                    {{-- Aksi --}}
                    <td class="py-4 px-4 text-right">
                        <div class="inline-flex items-center gap-3 font-medium text-xs">
                            <button
                                type="button"
                                onclick="editModal(@js($ekskul))"
                                class="text-blue-600 hover:text-blue-800">
                                Ubah
                            </button>
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
                    <td colspan="6" class="py-12 text-center">
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

{{-- ========================================== --}}
{{-- MODAL POP-UP UNTUK CRUD --}}
{{-- ========================================== --}}
<div id="crudModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm transition-all duration-300">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
        
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/50">
            <h2 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Ekstrakurikuler</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        <form id="crudForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div id="methodField"></div>

            {{-- MODAL SCROLLING BODY --}}
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Nama Ekstrakurikuler <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" id="inputNama" required class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all uppercase" placeholder="CONTOH: BASKET">
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="inputDeskripsi" rows="2" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all"></textarea>
                </div>

                {{-- JADWAL EKSTRAKURIKULER --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Hari Latihan</label>
                        <select name="hari" id="inputHari" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all bg-white">
                            <option value="">-- Pilih Hari --</option>
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
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Tanggal Masuk / Mulai</label>
                        <input type="date" name="tanggal_mulai" id="inputTanggalMulai" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="inputJamMulai" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="inputJamSelesai" class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                    </div>
                </div>
              

                {{-- KUOTA & STATUS --}}
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
                    <select name="pembina_id" id="inputPembina"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm bg-white">

                        <option value="">-- Pilih Pembina --</option>

                        @foreach($pembinas as $pembina)
                            <option value="{{ $pembina->id }}">
                                {{ $pembina->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- BANNER UPLOAD --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Foto Banner / Cover (Opsional)</label>
                    <input type="file" name="foto" id="inputFoto" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition-all cursor-pointer border border-gray-300 rounded-xl">
                    
                    {{-- Preview Banner Lama --}}
                    <div id="previewFotoContainer" class="mt-2 hidden">
                        <span class="text-[10px] text-gray-400 mb-1 block">Banner saat ini:</span>
                        <img id="previewFoto" src="" alt="Preview Banner" class="h-20 w-full rounded-lg object-cover border border-gray-200 shadow-sm">
                    </div>
                </div>

                {{-- LOGO UPLOAD --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wide mb-1.5">Logo / Ikon Bulat (Opsional)</label>
                    <p class="text-[10px] text-gray-500 mb-2">Gunakan gambar persegi (1:1) agar hasil bulat sempurna.</p>
                    <input type="file" name="logo" id="inputLogo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-gray-300 rounded-xl">

                    {{-- Preview Logo Lama --}}
                    <div id="previewLogoContainer" class="mt-2 hidden">
                        <span class="text-[10px] text-gray-400 mb-1 block">Logo saat ini:</span>
                        <img id="previewLogo" src="" alt="Preview Logo" class="h-14 w-14 rounded-full object-cover border border-gray-200 shadow-sm">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-md transition active:scale-95">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    const modal = document.getElementById('crudModal');
    const modalContent = document.getElementById('modalContent');
    const form = document.getElementById('crudForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    
    // Element untuk preview gambar
    const previewFotoContainer = document.getElementById('previewFotoContainer');
    const previewFoto = document.getElementById('previewFoto');
    const previewLogoContainer = document.getElementById('previewLogoContainer');
    const previewLogo = document.getElementById('previewLogo');

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
        
        // Sembunyikan preview gambar
        previewFotoContainer.classList.add('hidden');
        previewLogoContainer.classList.add('hidden');
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // ==========================================
    // FUNGSI EDIT MODAL (SUDAH DIPERBAIKI)
    // ==========================================
    function editModal(data) {
        openModal(); 
        modalTitle.innerText = 'Edit Ekstrakurikuler';
        
        form.action = `/admin/adexstra/${data.id}`;
        methodField.innerHTML = '@method("PUT")';

        // 1. Isi field teks & angka
        document.getElementById('inputNama').value = data.nama;
        document.getElementById('inputDeskripsi').value = data.deskripsi || '';
        document.getElementById('inputKuota').value = data.kuota;
        
        // 2. Isi Dropdown Status
        document.getElementById('inputStatus').value = data.status;

        // 3. Isi Dropdown Pembina (Gunakan String untuk memastikan value cocok)
        document.getElementById('inputPembina').value = data.pembina_id ? String(data.pembina_id) : '';

        // 4. Isi Jadwal
        document.getElementById('inputHari').value = data.hari || '';
        document.getElementById('inputTanggalMulai').value = data.tanggal_mulai || '';
        document.getElementById('inputJamMulai').value = data.jam_mulai || '';
        document.getElementById('inputJamSelesai').value = data.jam_selesai || '';

        // 5. Tampilkan Preview Foto & Logo
        if(data.foto) {
            previewFoto.src = `/storage/${data.foto}`;
            previewFotoContainer.classList.remove('hidden');
        } else {
            previewFotoContainer.classList.add('hidden');
        }

        if(data.logo) {
            previewLogo.src = `/storage/${data.logo}`;
            previewLogoContainer.classList.remove('hidden');
        } else {
            previewLogoContainer.classList.add('hidden');
        }
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // ==========================================
    // FITUR OTOMATIS HURUF BESAR SEMUA (UPPERCASE)
    // ==========================================
    const inputNama = document.getElementById('inputNama');
    inputNama.addEventListener('input', function(e) {
        // Mengubah semua huruf yang diketik menjadi kapital
        e.target.value = e.target.value.toUpperCase();
    });
</script>
@endsection