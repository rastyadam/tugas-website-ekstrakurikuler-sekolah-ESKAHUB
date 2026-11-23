<?php

namespace App\Exports;

use App\Models\MemberSiswa;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $kelas;

    public function __construct($search = null, $kelas = null)
    {
        $this->search = $search;
        $this->kelas  = $kelas;
    }

    public function query(): Builder
    {
        $query = MemberSiswa::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->kelas) {
            $query->where('kelas', $this->kelas);
        }

        return $query->orderBy('nama');
    }

    public function headings(): array
    {
        return ['No', 'NISN', 'Nama Siswa', 'Email', 'Kelas', 'Jurusan'];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nisn,
            $siswa->nama,
            $siswa->email ?? '-',
            $siswa->kelas ?? '-',
            $siswa->jurusan ?? '-',
        ];
    }

   public function styles(Worksheet $sheet): ?array
{
    return [
        1 => [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '14212E'],
            ],
        ],
    ];
}
}