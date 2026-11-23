@extends('admin.layout')

@section('title', 'Manajemen Pembina & Pelatih - EskaHub')

@section('header-title')
    <h1 class="text-[28px] font-bold tracking-tight text-[#14212E] leading-tight">
        Manajemen Pembina & Pelatih
    </h1>
    <p class="mt-1 text-sm font-normal text-[#475361]">
        Kelola data personil pembina ekstrakurikuler, pelatih resmi, penugasan kegiatan, serta status ketersediaan personil semester ini.
    </p>
@endsection

@section('content')
<div class="mt-4 space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    {{-- ACTION BUTTON --}}
    <div class="flex justify-start">
        <button onclick="openModal()" class="inline-flex items-center gap-2 rounded-lg bg-[#F7B500] px-4 py-2.5 text-sm font-bold text-[#14212E] shadow-xs hover:bg-[#E5A700] transition active:scale-95 cursor-pointer">
            <svg class="h-4 w-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pembina
        </button>
    </div>

    {{-- TABS & SUMMARY METRICS BAR --}}
    <div class="flex flex-col justify-between gap-4 border-b border-slate-200/80 pt-2 lg:flex-row lg:items-center">
        {{-- Kiri: Tabs --}}
        @php $currentTab = request('tab', 'all'); @endphp
        <div class="flex items-center gap-6 overflow-x-auto text-sm">
            <a href="{{ request()->fullUrlWithQuery(['tab' => 'all', 'page' => 1]) }}"
               class="flex items-center gap-2 border-b-2 pb-3 font-semibold whitespace-nowrap transition {{ $currentTab === 'all' ? 'border-[#14212E] text-[#14212E]' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                <span>Semua Personil</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-700">{{ $totalPersonil }}</span>
            </a>

            <a href="{{ request()->fullUrlWithQuery(['tab' => 'aktif', 'page' => 1]) }}"
               class="flex items-center gap-2 border-b-2 pb-3 font-medium whitespace-nowrap transition {{ $currentTab === 'aktif' ? 'border-[#14212E] text-[#14212E] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span>Aktif Bertugas</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $aktifBertugas }}</span>
            </a>

            <a href="{{ request()->fullUrlWithQuery(['tab' => 'nonaktif', 'page' => 1]) }}"
               class="flex items-center gap-2 border-b-2 pb-3 font-medium whitespace-nowrap transition {{ $currentTab === 'nonaktif' ? 'border-[#14212E] text-[#14212E] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                <span>Belum Ditugaskan</span>
                <span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $belumDitugaskan }}</span>
            </a>
        </div>

        {{-- Kanan: Ringkasan Cakupan Unit --}}
        <div class="flex items-center gap-3 pb-3 text-xs text-slate-500">
            <div>
                Cakupan Unit: <span class="font-bold text-[#14212E]">{{ $totalUnit }} Ekstrakurikuler</span>
            </div>
            <span class="text-slate-300">&bull;</span>
            <div class="flex items-center gap-1">
                <span>Rasio Pengampu:</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ $rasioPengampu }}% Terisi
                </span>
            </div>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-[0_2px_10px_-3px_rgba(20,33,46,0.03)]">
        
        {{-- TOOLBAR SEARCH & SORT --}}
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col justify-between gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-center">
            @if(request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}">
            @endif

            {{-- Kiri: Search Input + Filter Status --}}
            <div class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative w-full max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari pembina, email, atau kegiatan..."
                        class="w-full rounded-lg border border-slate-200 bg-white py-2 pl-10 pr-12 text-xs sm:text-sm text-[#14212E] placeholder:text-slate-400 focus:border-[#14212E] focus:outline-none"
                    >
                    @if(request('search'))
                        <a href="{{ route('admin.pelatih') }}" title="Reset Pencarian" class="absolute inset-y-0 right-2 flex items-center px-1.5 text-slate-400 hover:text-rose-500">
                            <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold">ESC</span>
                        </a>
                    @endif
                </div>

                <select name="tab" onchange="this.form.submit()" class="rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-medium text-[#14212E] focus:border-[#14212E] focus:outline-none cursor-pointer">
                    <option value="all" {{ $currentTab === 'all' ? 'selected' : '' }}>Semua Status Keaktifan</option>
                    <option value="aktif" {{ $currentTab === 'aktif' ? 'selected' : '' }}>Aktif Bertugas</option>
                    <option value="nonaktif" {{ $currentTab === 'nonaktif' ? 'selected' : '' }}>Belum Ditugaskan</option>
                </select>
            </div>

        
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#F9FAFB] text-[11px] font-bold tracking-wider text-slate-400 uppercase">
                        <th class="w-12 py-3.5 pl-5 pr-2"></th>
                        <th class="py-3.5 px-4">Nama & Kontak</th>
                        <th class="py-3.5 px-4">Ekstrakurikuler Diampu</th>
                        <th class="py-3.5 px-4">No. Telepon</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 pl-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($pelatih as $p)
                    <tr class="group hover:bg-slate-50/70 transition">
                        <td class="py-4 pl-5 pr-2"></td>

                        {{-- Nama & Email --}}
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-[#14212E] ring-1 ring-slate-200/70">
                                    {{ strtoupper(substr($p->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-[#14212E]">{{ $p->nama }}</div>
                                    <div class="mt-0.5 font-mono text-xs text-slate-400">
                                        {{ $p->pengguna->email ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Ekstrakurikuler Diampu --}}
                        <td class="py-4 px-4 font-bold text-[#14212E]">
                            {{ $p->ekstrakurikuler->pluck('nama')->join(', ') ?: 'Belum ada penugasan' }}
                        </td>

                        {{-- No Telepon --}}
                        <td class="py-4 px-4 font-mono text-xs text-[#475361]">
                            {{ $p->no_hp ?? '-' }}
                        </td>

                        {{-- Status --}}
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                        </td>

                        {{-- Aksi: Detail, Edit, Titik Tiga (Hapus) --}}
                        <td class="py-4 pl-4 pr-6 text-right">
                            <div class="inline-flex items-center justify-end gap-4 text-xs font-medium text-slate-500">
                                <button type="button" onclick='detailModal(@json($p))' class="hover:text-[#14212E] transition cursor-pointer">
                                    Detail
                                </button>
                                <button type="button" onclick='editModal(@json($p))' class="hover:text-[#14212E] transition cursor-pointer">
                                    Edit
                                </button>
                                
                                {{-- Dropdown Titik Tiga untuk Hapus --}}
                                <div class="relative inline-block text-left">
                                    <button type="button" onclick="toggleDropdown({{ $p->id }})" class="rounded p-1 text-slate-400 hover:bg-slate-100 hover:text-[#14212E] cursor-pointer">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $p->id }}" class="action-dropdown absolute right-0 z-20 mt-1 hidden w-32 origin-top-right rounded-xl border border-slate-200 bg-white py-1 shadow-lg">
                                        <form action="{{ route('admin.pelatih.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pembina & akun login ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex w-full items-center px-3.5 py-2 text-left text-xs font-semibold text-rose-600 hover:bg-rose-50 cursor-pointer">
                                                Hapus Data
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-sm text-slate-400">
                            Tidak ada data pembina atau pelatih yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="flex items-center justify-end pt-1">
        {{ $pelatih->links() }}
    </div>

</div>

{{-- ========================================== --}}
{{-- MODAL DETAIL --}}
{{-- ========================================== --}}
<div id="modalDetail" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4 backdrop-blur-xs">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="text-lg font-bold text-[#14212E]">Detail Personil Pembina</h2>
            <button onclick="closeModalDetail()" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>

        <div class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-50 pb-2">
                <span class="text-slate-400">Nama Lengkap</span>
                <span id="det_nama" class="font-bold text-[#14212E]">-</span>
            </div>
            <div class="flex justify-between border-b border-slate-50 pb-2">
                <span class="text-slate-400">Email Akun</span>
                <span id="det_email" class="font-mono text-xs font-semibold text-[#14212E]">-</span>
            </div>
            <div class="flex justify-between border-b border-slate-50 pb-2">
                <span class="text-slate-400">No. Telepon</span>
                <span id="det_no_hp" class="font-semibold text-[#14212E]">-</span>
            </div>
            <div class="flex justify-between border-b border-slate-50 pb-2">
                <span class="text-slate-400">Jenis Pembina</span>
                <span id="det_jenis" class="font-semibold text-[#14212E]">-</span>
            </div>
            <div class="flex justify-between border-b border-slate-50 pb-2">
                <span class="text-slate-400">Asal Instansi</span>
                <span id="det_asal" class="font-semibold text-[#14212E]">-</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Ekskul Diampu</span>
                <span id="det_ekskul" class="font-bold text-emerald-600 text-right">-</span>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="button" onclick="closeModalDetail()" class="rounded-xl bg-[#14212E] px-5 py-2 text-xs font-bold text-white hover:bg-slate-800">Tutup</button>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL TAMBAH --}}
{{-- ========================================== --}}
<div id="modalTambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4 backdrop-blur-xs">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
        <h2 class="mb-4 text-lg font-bold text-[#14212E]">Tambah Akun Pembina</h2>
        
        <form action="{{ route('admin.pelatih.store') }}" method="POST">
            @csrf
            <div class="space-y-3.5">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Email (Untuk Login)</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Password Awal</label>
                    <input type="text" name="password" value="password123" readonly class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-3.5 py-2 text-sm text-slate-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">No HP</label>
                        <input type="text" name="no_hp" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Jenis Pembina</label>
                        <input type="text" name="jenis_pembina" placeholder="Internal / Eksternal" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Asal Instansi</label>
                    <input type="text" name="asal" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambah()" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-xl bg-[#F7B500] px-4 py-2 text-sm font-bold text-[#14212E] hover:bg-[#E5A700]">Buat Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL EDIT --}}
{{-- ========================================== --}}
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4 backdrop-blur-xs">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
        <h2 class="mb-4 text-lg font-bold text-[#14212E]">Edit Data Pembina</h2>
        
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-3.5">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">No HP</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-slate-700">Jenis Pembina</label>
                        <input type="text" name="jenis_pembina" id="edit_jenis_pembina" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-700">Asal Instansi</label>
                    <input type="text" name="asal" id="edit_asal" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-[#14212E] focus:outline-none">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModalEdit()" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="submit" class="rounded-xl bg-[#14212E] px-4 py-2 text-sm font-bold text-white hover:bg-slate-800">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Select All Checkbox
    document.getElementById('checkAll')?.addEventListener('change', function() {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // Dropdown Titik Tiga
    function toggleDropdown(id) {
        document.querySelectorAll('.action-dropdown').forEach(el => {
            if (el.id !== `dropdown-${id}`) el.classList.add('hidden');
        });
        document.getElementById(`dropdown-${id}`).classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.action-dropdown').forEach(el => el.classList.add('hidden'));
        }
    });

    // Modal Detail
    const modalDetail = document.getElementById('modalDetail');
    function detailModal(data) {
        document.getElementById('det_nama').innerText = data.nama || '-';
        document.getElementById('det_email').innerText = data.pengguna ? data.pengguna.email : '-';
        document.getElementById('det_no_hp').innerText = data.no_hp || '-';
        document.getElementById('det_jenis').innerText = data.jenis_pembina || '-';
        document.getElementById('det_asal').innerText = data.asal || '-';
        
        const ekskuls = data.ekstrakurikuler && data.ekstrakurikuler.length
            ? data.ekstrakurikuler.map(e => e.nama).join(', ')
            : 'Belum ada penugasan';
        document.getElementById('det_ekskul').innerText = ekskuls;

        modalDetail.classList.remove('hidden');
        modalDetail.classList.add('flex');
    }
    function closeModalDetail() {
        modalDetail.classList.add('hidden');
        modalDetail.classList.remove('flex');
    }

    // Modal Tambah
    const modalTambah = document.getElementById('modalTambah');
    function openModal() {
        modalTambah.classList.remove('hidden');
        modalTambah.classList.add('flex');
    }
    function closeModalTambah() {
        modalTambah.classList.add('hidden');
        modalTambah.classList.remove('flex');
    }

    // Modal Edit
    const modalEdit = document.getElementById('modalEdit');
    const formEdit = document.getElementById('formEdit');
    function editModal(data) {
        modalEdit.classList.remove('hidden');
        modalEdit.classList.add('flex');

        // Catatan: Pastikan URL action sesuai dengan route update Anda (/admin/pelatih/ atau /admin/pembina/)
        formEdit.action = `/admin/pembina/${data.id}`;

        document.getElementById('edit_nama').value = data.nama;
        document.getElementById('edit_email').value = data.pengguna ? data.pengguna.email : '';
        document.getElementById('edit_no_hp').value = data.no_hp || '';
        document.getElementById('edit_jenis_pembina').value = data.jenis_pembina || '';
        document.getElementById('edit_asal').value = data.asal || '';
    }
    function closeModalEdit() {
        modalEdit.classList.add('hidden');
        modalEdit.classList.remove('flex');
    }
</script>
@endsection