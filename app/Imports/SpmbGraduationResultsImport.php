<?php

namespace App\Imports;

use App\Models\SpmbGraduationResult;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpmbGraduationResultsImport implements ToCollection, WithHeadingRow
{
    public int $created = 0;

    public int $updated = 0;

    public int $skipped = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $name = trim((string) ($row['nama_lengkap'] ?? ''));
            $nisn = preg_replace('/\D/', '', (string) ($row['nisn'] ?? ''));

            if ($name === '' || str_starts_with(strtolower($name), 'contoh:')) {
                $this->skipped++;

                continue;
            }

            if (strlen($nisn) !== 10) {
                $this->skipped++;

                continue;
            }

            $major = SpmbGraduationResult::normalizeMajor(
                (string) ($row['diterima_pada_jurusan'] ?? '')
            );

            if ($major === null || $major === '') {
                $this->skipped++;

                continue;
            }

            $gender = strtoupper(trim((string) ($row['jk'] ?? 'L')));
            if (! in_array($gender, ['L', 'P'], true)) {
                $gender = 'L';
            }

            $attrs = [
                'sort_order'           => (int) ($row['no_urut'] ?? 0),
                'registration_number'  => $this->nullable($row['no_daftar'] ?? null),
                'nisn'                 => $nisn,
                'full_name'            => $name,
                'gender'               => $gender,
                'origin_school'        => $this->nullable($row['asal_sekolah'] ?? null),
                'accepted_major'       => $major,
                'academic_year'        => setting('ppdb_year', '2026/2027'),
            ];

            $existing = SpmbGraduationResult::where('nisn', $nisn)->first();

            if ($existing) {
                $existing->update($attrs);
                $this->updated++;
            } else {
                SpmbGraduationResult::create($attrs);
                $this->created++;
            }
        }
    }

    private function nullable(mixed $value): ?string
    {
        $v = trim((string) $value);

        return $v === '' ? null : $v;
    }
}
