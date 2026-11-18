<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Student::select(
            'nisn',
            'nis',
            'nama',
            'kelas',
            'jenis_kelamin',
            'alamat'
        )->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'NIS',
            'Nama',
            'Kelas',
            'Jenis Kelamin',
            'Alamat',
        ];
    }
}