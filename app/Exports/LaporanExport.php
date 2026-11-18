<?php

namespace App\Exports;

use App\Models\Ekstrakurikuler;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Enumerable;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil data dari database
     */
    public function collection(): Enumerable
    {
        return Ekstrakurikuler::with('pembina')
            ->withCount(['pendaftarans as total_peserta' => function ($query) {
                $query->where('status', 'diterima');
            }])
            ->get();
    }

    /**
     * Judul Kolom di Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Ekstrakurikuler',
            'Pembina',
            'Total Peserta Diterima',
            'Status',
        ];
    }

    /**
     * Isi Baris per Data
     */
    public function map($ekskul): array
    {
        return [
            'RPT-' . str_pad($ekskul->id, 2, '0', STR_PAD_LEFT),
            $ekskul->nama,
            $ekskul->pembina->nama ?? 'Belum ada',
            $ekskul->total_peserta ?? 0,
            ucfirst($ekskul->status),
        ];
    }
}