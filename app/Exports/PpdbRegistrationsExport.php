<?php

namespace App\Exports;

use App\Models\PpdbRegistration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PpdbRegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private ?string $status = null) {}

    public function collection(): Collection
    {
        return PpdbRegistration::with('major')
            ->where('form_status', 'submitted')
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Daftar Ulang', 'No SPMB Banten', 'Nama Lengkap', 'NISN', 'NIK', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Kewarganegaraan', 'Alamat', 'RT', 'RW',
            'Desa/Kel', 'Kecamatan', 'Kode Pos', 'No HP', 'Email',
            'Nama Ayah', 'NIK Ayah', 'Nama Ibu', 'NIK Ibu', 'Nama Wali', 'NIK Wali',
            'Tinggi (cm)', 'Berat (kg)', 'Jarak ke Sekolah', 'Jumlah Saudara',
            'Jurusan', 'Jenis Pendaftaran', 'NIS', 'Asal Sekolah', 'Tgl Masuk Sekolah',
            'No Peserta Ujian', 'No Seri Ijazah', 'No SKHUS', 'Status', 'Tanggal Submit',
        ];
    }

    public function map($r): array
    {
        return [
            $r->registration_number,
            $r->spmb_banten_number,
            $r->full_name,
            $r->nisn,
            $r->nik,
            $r->genderLabel(),
            $r->birth_place,
            $r->birth_date?->format('Y-m-d'),
            $r->religion,
            $r->citizenship,
            $r->address,
            $r->rt,
            $r->rw,
            $r->village,
            $r->district,
            $r->postal_code,
            $r->phone,
            $r->email,
            $r->father_name,
            $r->father_nik,
            $r->mother_name,
            $r->mother_nik,
            $r->guardian_name,
            $r->guardian_nik,
            $r->height_cm,
            $r->weight_kg,
            $r->distance_category,
            $r->siblings_count,
            $r->major?->name,
            $r->registration_type,
            $r->nis,
            $r->previous_school,
            $r->school_entry_date?->format('Y-m-d'),
            $r->exam_number,
            $r->diploma_serial,
            $r->skhus_serial,
            $r->statusLabel(),
            $r->updated_at?->format('Y-m-d H:i'),
        ];
    }
}
