<?php

namespace App\Exports;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EkstrakurikulerExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $status;
    protected $sort;

    public function __construct($search = null, $status = null, $sort = 'asc')
    {
        $this->search = $search;
        $this->status = $status;
        $this->sort   = $sort;
    }

    public function query(): Builder
    {
        $query = Ekstrakurikuler::query()->with('pembina');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('pembina', function ($p) {
                      $p->where('nama', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $arah = $this->sort === 'desc' ? 'desc' : 'asc';
        return $query->orderBy('nama', $arah);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Ekstrakurikuler',
            'Deskripsi',
            'Pembina',
            'Jenis Pembina',
            'Kuota',
            'Terisi',
            'Sisa Kuota',
            'Status',
        ];
    }

    public function map($ekskul): array
    {
        static $no = 0;
        $no++;

        $terisi = $ekskul->terisi ?? 0;
        $sisa   = max(0, $ekskul->kuota - $terisi);

        return [
            $no,
            $ekskul->nama,
            $ekskul->deskripsi ?? '-',
            $ekskul->pembina->nama ?? 'Belum ditentukan',
            $ekskul->pembina->jenis_pembina ?? '-',
            $ekskul->kuota,
            $terisi,
            $sisa,
            ucfirst($ekskul->status),
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