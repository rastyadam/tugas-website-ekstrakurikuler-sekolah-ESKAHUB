@extends('pembina.layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50/70 text-slate-800">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm flex items-center justify-between gap-3">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header Halaman -->
        <div class="bg-white border border-slate-200/90 rounded-xl px-5 py-4 sm:px-6 sm:py-5 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-900 tracking-tight">
                    Jadwal Latihan Ekstrakurikuler
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Atur jadwal latihan rutin untuk ekstrakurikuler yang Anda ampu.
                </p>
            </div>
            <div class="text-xs text-slate-500">
                Total: <span class="font-semibold text-slate-700">{{ $ekskuls->count() }}</span> ekskul
            </div>
        </div>

        <!-- Daftar Ekstrakurikuler & Jadwal -->
        @forelse($ekskuls as $ekskul)
            <section class="bg-white border border-slate-200/90 rounded-xl shadow-xs overflow-hidden">
                <!-- Header Ekskul -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 bg-slate-50/80 border-b border-slate-200/80">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                        <h2 class="text-base sm:text-lg font-semibold text-slate-900 truncate">
                            {{ $ekskul->nama }}
                        </h2>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full shrink-0 {{ $ekskul->jadwalLatihan->isEmpty() ? 'bg-slate-100 text-slate-500 border border-slate-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                            {{ $ekskul->jadwalLatihan->count() }} sesi
                        </span>
                    </div>

                    <button type="button"
                            onclick="openModal({{ $ekskul->id }}, @js($ekskul->nama))"
                            class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-xs font-medium px-3.5 py-2 rounded-lg transition-colors cursor-pointer">
                        <span>+ Tambah Jadwal</span>
                    </button>
                </div>

                <!-- Isi Jadwal -->
                <div class="p-5">
                    @if($ekskul->jadwalLatihan->isEmpty())
                        <div class="border border-dashed border-slate-200 rounded-lg py-6 px-4 text-center bg-slate-50/40">
                            <p class="text-sm text-slate-500">
                                Belum ada jadwal latihan untuk ekstrakurikuler ini.
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                Klik tombol <span class="font-medium text-slate-600">+ Tambah Jadwal</span> untuk membuat sesi latihan rutin.
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($ekskul->jadwalLatihan as $jadwal)
                                <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5 sm:gap-4">
                                    <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                                        <!-- Blok Hari & Jam -->
                                        <div class="w-28 shrink-0 bg-slate-50 border border-slate-200/80 rounded-lg px-2.5 py-1.5">
                                            <p class="text-xs font-semibold text-slate-800">{{ $jadwal->hari }}</p>
                                            <p class="text-[11px] text-slate-500 tabular-nums mt-0.5">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </p>
                                        </div>

                                        <!-- Jenis Latihan, Tempat & Keterangan -->
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-900 truncate">
                                                {{ $jadwal->jenis_latihan }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5 flex flex-wrap items-center gap-x-1.5 gap-y-0.5">
                                                <span class="text-slate-600 font-medium">{{ $jadwal->tempat }}</span>
                                                @if(!empty($jadwal->keterangan))
                                                    <span class="text-slate-300">•</span>
                                                    <span>{{ $jadwal->keterangan }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @empty
            <div class="bg-white border border-slate-200 rounded-xl p-8 text-center text-sm text-slate-500">
                Belum ada ekstrakurikuler yang terdaftar untuk akun pembina ini.
            </div>
        @endforelse

    </main>
</div>

<!-- Modal Tambah Jadwal -->
<div id="modalJadwal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 p-4"
     role="dialog"
     aria-modal="true"
     aria-labelledby="modalTitle">
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 bg-slate-50/70 border-b border-slate-200">
            <h2 id="modalTitle" class="text-base font-semibold text-slate-900 truncate pr-2">
                Tambah Jadwal — <span id="modalEkskulName" class="text-amber-600 font-semibold"></span>
            </h2>
            <button type="button"
                    onclick="closeModal()"
                    class="text-slate-400 hover:text-slate-700 text-sm px-2 py-1 rounded-md hover:bg-slate-100 transition-colors"
                    aria-label="Tutup modal">
                ✕
            </button>
        </div>

        <form id="formJadwal" method="POST" class="p-5 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Jenis Latihan</label>
                <input type="text"
                       name="jenis_latihan"
                       placeholder="Contoh: Latihan Rutin"
                       required
                       class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Hari</label>
                    <select name="hari"
                            required
                            class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:border-amber-500">
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
                    <label class="block text-xs font-medium text-slate-700 mb-1">Tempat</label>
                    <input type="text"
                           name="tempat"
                           placeholder="Contoh: Lapangan"
                           required
                           class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Jam Mulai</label>
                    <input type="time"
                           name="jam_mulai"
                           required
                           class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Jam Selesai</label>
                    <input type="time"
                           name="jam_selesai"
                           required
                           class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan"
                          rows="2"
                          placeholder="Catatan tambahan jika ada..."
                          class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-amber-500"></textarea>
            </div>

            <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
                <button type="button"
                        onclick="closeModal()"
                        class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-xs font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-colors cursor-pointer">
                    Simpan Jadwal
                </button>
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
        nameSpan.textContent = nama;
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endsection