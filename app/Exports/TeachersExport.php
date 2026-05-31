<?php

namespace App\Exports;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Teacher::with('user')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap & Gelar',
            'NIP / NUPTK',
            'Jenis Kelamin (L/P)',
            'Jabatan',
            'Mata Pelajaran',
            'Pendidikan Terakhir',
            'Email Sekolah',
            'No HP',
            'Status Kepegawaian (pns/pppk/honorer)',
            'Bidang / Jurusan',
            'Moto Hidup',
            'Bio',
            'Urutan Tampil',
            'Aktif (1/0)',
            'Email Akun Login',
        ];
    }

    public function map($t): array
    {
        return [
            $t->id,
            $t->name,
            $t->nip,
            $t->gender,
            $t->position,
            $t->subject,
            $t->education,
            $t->email,
            $t->phone,
            $t->employment_status,
            $t->field,
            $t->motto,
            $t->bio,
            $t->sort_order,
            $t->is_active ? 1 : 0,
            $t->user?->email,
        ];
    }
}
