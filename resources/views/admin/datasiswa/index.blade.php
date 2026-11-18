@extends('admin.layout')

@section('title', 'Data Siswa - EskaHub ADMIN')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Siswa
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data siswa melalui import dan export Excel.
            </p>
        </div>

        <div class="flex gap-3">

            {{-- IMPORT --}}
            <form
                action="{{ route('admin.datasiswa.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex items-center gap-2">

                @csrf

                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls,.csv"
                    required
                    class="text-sm border rounded-lg bg-white px-3 py-2">

                <button
                    type="submit"
                    class="bg-[#1B2A38] hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">

                    <i class="fa-solid fa-file-import mr-2"></i>
                    Import

                </button>

            </form>


            {{-- EXPORT --}}
            <a
                href="{{ route('admin.datasiswa.export') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">

                <i class="fa-solid fa-file-export mr-2"></i>
                Export

            </a>

        </div>

    </div>


    {{-- ALERT --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">

            <i class="fa-solid fa-circle-check mr-2"></i>

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">

            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif


    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            No
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            NISN
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            NIS
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            Kelas
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-gray-600">
                            Jenis Kelamin
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($students as $student)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium">
                                {{ $student->nisn }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $student->nis ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $student->nama }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $student->kelas }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $student->jenis_kelamin === 'L'
                                    ? 'Laki-laki'
                                    : 'Perempuan' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-gray-500">

                                <i class="fa-solid fa-users text-4xl mb-3 text-gray-300"></i>

                                <p>
                                    Belum ada data siswa.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection