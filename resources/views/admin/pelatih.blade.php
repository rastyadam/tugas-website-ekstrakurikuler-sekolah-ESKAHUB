@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pembina & Pelatih</h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola data personil pembina ekstrakurikuler, pelatih resmi, penugasan kegiatan.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="openModal()" class="flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-sm transition active:scale-95">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pembina
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-[11px] font-bold tracking-wider text-slate-500 uppercase">
                        <th class="py-3 px-4">Nama & Kontak</th>
                        <th class="py-3 px-4">Ekstrakurikuler Diampu</th>
                        <th class="py-3 px-4">No. Telepon</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    
                    @forelse($pelatih as $p)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-600 font-semibold text-xs flex items-center justify-center">
                                    {{ strtoupper(substr($p->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $p->nama }}</div>
                                    <div class="text-xs text-slate-400">{{ $p->pengguna->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-semibold text-slate-700">
                            {{ $p->ekstrakurikuler->pluck('nama')->join(', ') ?: 'Belum ada' }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-xs">
                            {{ $p->no_hp ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center text-xs font-semibold text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-2">
                            <button onclick="editModal({{ $p }})" class="text-xs font-medium text-blue-600 hover:text-blue-800">Edit</button>
                            
                            <form action="{{ route('admin.pelatih.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-medium ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            Belum ada data pelatih. Silakan tambah data baru.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Section --}}
    <div class="flex items-center justify-end space-x-1.5 text-sm">
        {{ $pelatih->links() }}
    </div>

</div>

{{-- ========================================== --}}
{{-- MODAL TAMBAH --}}
{{-- ========================================== --}}
<div id="modalTambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Tambah Akun Pembina</h2>
        
        <form action="{{ route('admin.pelatih.store') }}" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email (Untuk Login)</label>
                    <input type="email" name="email" required class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password Awal</label>
                    <input type="text" name="password" value="password123" readonly class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">No HP</label>
                        <input type="text" name="no_hp" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Pembina</label>
                        <input type="text" name="jenis_pembina" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm" placeholder="Internal/Eksternal">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Asal Instansi</label>
                    <input type="text" name="asal" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambah()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl">Buat Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL EDIT --}}
{{-- ========================================== --}}
<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Edit Data Pembina</h2>
        
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm" placeholder="Kosongkan jika tidak diganti">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">No HP</label>
                        <input type="text" name="no_hp" id="edit_no_hp" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Pembina</label>
                        <input type="text" name="jenis_pembina" id="edit_jenis_pembina" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Asal Instansi</label>
                    <input type="text" name="asal" id="edit_asal" class="w-full rounded-xl border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModalEdit()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-xl">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
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

        // Set Action URL
        formEdit.action = `/admin/pembina/${data.id}`;

        // Isi Form dengan data yang dipilih
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