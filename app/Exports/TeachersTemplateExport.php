<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersTemplateExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return collect([
            [
                '',
                'Contoh: Drs. Ahmad Fauzi, M.Pd.',
                '196508101990031004',
                'L',
                'Guru Produktif',
                'Matematika',
                'S1 Pendidikan Matematika — UNJ',
                'guru@smkn8pandeglang.sch.id',
                '081234567890',
                'pns',
                'rpl',
                'Belajar sepanjang hayat.',
                '',
                '0',
                '1',
                '',
            ],
        ]);
    }

    public function headings(): array
    {
        return (new TeachersExport)->headings();
    }
}
