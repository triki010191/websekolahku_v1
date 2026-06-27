<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpmbGraduationResultsTemplateExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return collect([
            [
                1,
                '0012345678',
                '0113804305',
                'Contoh: Ahmad Fauzi',
                'L',
                'SMP Negeri 1 Pandeglang',
                'Rekayasa Perangkat Lunak 1',
            ],
        ]);
    }

    public function headings(): array
    {
        return (new SpmbGraduationResultsExport)->headings();
    }
}
