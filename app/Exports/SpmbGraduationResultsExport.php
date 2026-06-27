<?php

namespace App\Exports;

use App\Models\SpmbGraduationResult;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SpmbGraduationResultsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return SpmbGraduationResult::query()
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NO. URUT',
            'NO. DAFTAR',
            'NISN',
            'NAMA LENGKAP',
            'JK',
            'ASAL SEKOLAH',
            'DITERIMA PADA JURUSAN',
        ];
    }

    public function map($row): array
    {
        return [
            $row->sort_order,
            $row->registration_number,
            $row->nisn,
            $row->full_name,
            $row->gender,
            $row->origin_school,
            $row->accepted_major,
        ];
    }
}
