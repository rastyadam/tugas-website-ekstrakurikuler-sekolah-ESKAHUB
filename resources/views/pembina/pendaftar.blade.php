
@extends('pembina.layouts.app')

@section('title', 'Pendaftar Baru')
@section('header_title', '')

@section('content')

<div class="max-w-7xl mx-auto space-y-5">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="px-4 py-3 border border-green-200 bg-green-50 text-green-700 text-sm rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div class="px-4 py-3 border border-red-200 bg-red-50 text-red-700 text-sm rounded-md">
            {{ session('error') }}
        </div>
    @endif


    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <div>
            <h1 class="text-xl font-semibold text-slate-900">
                Pendaftar Baru
            </h1>

            <p class="text-xs text-gray-500 mt-1">
                Mengelola permohonan kegiatan ekstrakurikuler yang masuk.
            </p>
        </div>

    </div>


    {{-- TABEL PENDAFTAR --}}
    <div class="bg-white border border-gray-200 rounded-md overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-left border-collapse">

                {{-- TABLE HEADER --}}
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                            Nama Pendaftar
                        </th>

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                            Ekstrakurikuler
                        </th>

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                            Berkas
                        </th>

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                            Tanggal Pendaftaran
                        </th>

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                            Status
                        </th>

                        <th class="px-4 py-3 text-[10px] font-semibold uppercase tracking-wide text-gray-500 text-center">
                            Aksi
                        </th>

                    </tr>
                </thead>


                {{-- TABLE BODY --}}
                <tbody class="divide-y divide-gray-200">

                    @forelse($pendaftarans as $p)

                    <tr class="hover:bg-gray-50 transition-colors">

                        {{-- NAMA PENDAFTAR --}}
                        <td class="px-4 py-3">

                            <p class="text-xs font-semibold text-slate-900">
                                {{ $p->member->nama ?? 'Siswa' }}
                            </p>

                            <p class="text-[10px] text-gray-500 mt-1">
                                {{ $p->member->nisn ?? '-' }}
                            </p>

                        </td>


                        {{-- EKSTRAKURIKULER --}}
                        <td class="px-4 py-3 text-xs text-gray-600">
                            {{ $p->ekstrakurikuler->nama ?? '-' }}
                        </td>


                        {{-- BERKAS --}}
                        <td class="px-4 py-3">

                            @if($p->detailPersyaratan && $p->detailPersyaratan->berkas)

                                <a href="{{ asset('storage/' . $p->detailPersyaratan->berkas) }}"
                                   target="_blank"
                                   class="text-xs font-medium text-slate-700 hover:text-amber-700 underline underline-offset-2">

                                    Lihat Berkas

                                </a>

                            @else

                                <span class="text-xs text-gray-400">
                                    -
                                </span>

                            @endif

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-4 py-3 text-xs text-gray-600">

                            {{ $p->tanggal_daftar
                                ? \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y')
                                : '-' }}

                        </td>


                        {{-- STATUS --}}
                        <td class="px-4 py-3">

                            @if($p->status == 'pending')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800">
                                    Pending
                                </span>

                            @elseif($p->status == 'diterima')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-green-100 text-green-700">
                                    Diterima
                                </span>

                            @else

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-red-100 text-red-700">
                                    Ditolak
                                </span>

                            @endif

                        </td>


                        {{-- AKSI --}}
                        <td class="px-4 py-3">

                            <div class="flex items-center justify-center gap-1.5">

                                @if($p->status == 'pending')

                                    {{-- ATUR SELEKSI --}}
                                    <button
                                        type="button"
                                        onclick="openJadwalModal({{ $p->id }})"
                                        class="px-2.5 py-1.5 text-[10px] font-semibold bg-slate-900 text-white rounded-sm hover:bg-slate-700 transition whitespace-nowrap">

                                        Atur Seleksi

                                    </button>


                                    {{-- TERIMA LANGSUNG --}}
                                    <form
                                        action="{{ route('pembina.pendaftar.terima-langsung', $p->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menerima pendaftar ini tanpa seleksi?')">

                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="px-2.5 py-1.5 text-[10px] font-semibold bg-white border border-gray-300 text-gray-700 rounded-sm hover:bg-gray-100 transition whitespace-nowrap">

                                            Setujui

                                        </button>

                                    </form>


                                    {{-- TOLAK --}}
                                    <button
                                        type="button"
                                        onclick="openTolakModal({{ $p->id }})"
                                        class="px-2.5 py-1.5 text-[10px] font-semibold bg-gray-100 text-gray-600 rounded-sm hover:bg-red-50 hover:text-red-600 transition">

                                        Tolak

                                    </button>

                                @else

                                    <span class="text-[10px] text-gray-400">
                                        Selesai
                                    </span>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="px-4 py-12 text-center">

                            <p class="text-sm font-medium text-gray-600">
                                Belum ada pendaftar
                            </p>

                            <p class="text-xs text-gray-400 mt-1">
                                Data pendaftaran akan muncul di halaman ini.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($pendaftarans->hasPages())

            <div class="px-4 py-3 border-t border-gray-200 flex justify-end overflow-x-auto">

                {{ $pendaftarans->links() }}

            </div>

        @endif

    </div>

</div>



{{-- ===================================== --}}
{{-- MODAL TOLAK PENDAFTAR --}}
{{-- ===================================== --}}

<div id="modalTolak"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 p-4">

    <div class="w-full max-w-md bg-white rounded-md shadow-xl max-h-[90vh] overflow-y-auto">

        {{-- HEADER MODAL --}}
        <div class="px-5 py-4 border-b border-gray-200">

            <h2 class="text-base font-semibold text-slate-900">
                Alasan Penolakan
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Masukkan alasan penolakan pendaftaran siswa.
            </p>

        </div>


        {{-- FORM --}}
        <form id="formTolak" method="POST">

            @csrf
            @method('PUT')

            <input type="hidden" name="status" value="ditolak">

            <div class="p-5">

                <label class="block text-xs font-medium text-gray-700 mb-2">
                    Alasan Penolakan
                </label>

                <textarea
                    name="alasan_penolakan"
                    required
                    rows="4"
                    placeholder="Tuliskan alasan penolakan..."
                    class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200 resize-none"></textarea>

            </div>


            {{-- FOOTER --}}
            <div class="px-5 py-4 border-t border-gray-200 flex justify-end gap-2">

                <button
                    type="button"
                    onclick="closeTolakModal()"
                    class="px-4 py-2 text-xs font-medium text-gray-600 border border-gray-300 rounded-sm hover:bg-gray-50">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-slate-900 rounded-sm hover:bg-slate-700">

                    Tolak Pendaftaran

                </button>

            </div>

        </form>

    </div>

</div>



{{-- ===================================== --}}
{{-- MODAL ATUR JADWAL SELEKSI --}}
{{-- ===================================== --}}

<div id="modalJadwal"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 p-4">

    <div class="w-full max-w-md bg-white rounded-md shadow-xl max-h-[90vh] overflow-y-auto">

        {{-- HEADER --}}
        <div class="px-5 py-4 border-b border-gray-200">

            <h2 class="text-base font-semibold text-slate-900">
                Atur Jadwal Seleksi
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Tentukan jadwal seleksi untuk calon anggota.
            </p>

        </div>


        {{-- FORM --}}
        <form id="formJadwal" method="POST">

            @csrf

            <div class="p-5 space-y-4">


                {{-- TAHAP SELEKSI --}}
                <div>

                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Tahap Seleksi
                    </label>

                    <input
                        type="text"
                        name="tahap_seleksi"
                        placeholder="Contoh: Tes Tulis, Wawancara"
                        required
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200">

                </div>


                {{-- TANGGAL --}}
                <div>

                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Tanggal Seleksi
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        required
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200">

                </div>


                {{-- JAM --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <div>

                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Jam Mulai
                        </label>

                        <input
                            type="time"
                            name="jam_mulai"
                            required
                            class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200">

                    </div>


                    <div>

                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Jam Selesai
                        </label>

                        <input
                            type="time"
                            name="jam_selesai"
                            required
                            class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200">

                    </div>

                </div>


                {{-- TEMPAT --}}
                <div>

                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Tempat
                    </label>

                    <input
                        type="text"
                        name="tempat"
                        placeholder="Contoh: Lapangan Basket"
                        required
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200">

                </div>


                {{-- KETERANGAN --}}
                <div>

                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Keterangan (Opsional)
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 text-sm focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-200 resize-none"></textarea>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="px-5 py-4 border-t border-gray-200 flex justify-end gap-2">

                <button
                    type="button"
                    onclick="closeJadwalModal()"
                    class="px-4 py-2 text-xs font-medium text-gray-600 border border-gray-300 rounded-sm hover:bg-gray-50">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-slate-900 rounded-sm hover:bg-slate-700">

                    Simpan Jadwal

                </button>

            </div>

        </form>

    </div>

</div>



{{-- ===================================== --}}
{{-- JAVASCRIPT MODAL --}}
{{-- ===================================== --}}

<script>

    // MODAL TOLAK
    const modalTolak = document.getElementById('modalTolak');
    const formTolak = document.getElementById('formTolak');

    function openTolakModal(id) {

        modalTolak.classList.remove('hidden');
        modalTolak.classList.add('flex');

        formTolak.action = `/pembina/pendaftar/${id}/status`;

        document.body.classList.add('overflow-hidden');
    }

    function closeTolakModal() {

        modalTolak.classList.add('hidden');
        modalTolak.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    // MODAL JADWAL
    const modalJadwal = document.getElementById('modalJadwal');
    const formJadwal = document.getElementById('formJadwal');

    function openJadwalModal(id) {

        modalJadwal.classList.remove('hidden');
        modalJadwal.classList.add('flex');

        formJadwal.action = `/pembina/pendaftar/${id}/jadwal`;

        document.body.classList.add('overflow-hidden');
    }

    function closeJadwalModal() {

        modalJadwal.classList.add('hidden');
        modalJadwal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    // KLIK AREA LUAR MODAL
    modalTolak.addEventListener('click', function(e) {

        if (e.target === modalTolak) {
            closeTolakModal();
        }

    });

    modalJadwal.addEventListener('click', function(e) {

        if (e.target === modalJadwal) {
            closeJadwalModal();
        }

    });


    // TOMBOL ESCAPE
    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {
            closeTolakModal();
            closeJadwalModal();
        }

    });

</script>

@endsection
