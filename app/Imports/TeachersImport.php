<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToCollection, WithHeadingRow
{
    public int $created = 0;
    public int $updated = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $name = trim((string) ($row['nama_lengkap_gelar'] ?? $row['nama_lengkap'] ?? ''));
            if ($name === '' || str_starts_with(strtolower($name), 'contoh:')) {
                continue;
            }

            $id = $row['id'] ?? null;
            $nip = $this->nullable($row['nip_nuptk'] ?? $row['nip'] ?? null);

            $attrs = [
                'name'              => $name,
                'nip'               => $nip,
                'gender'            => in_array(strtoupper((string) ($row['jenis_kelamin_l_p'] ?? $row['jenis_kelamin'] ?? 'L')), ['L', 'P'], true)
                    ? strtoupper((string) ($row['jenis_kelamin_l_p'] ?? $row['jenis_kelamin']))
                    : 'L',
                'position'          => $this->required($row['jabatan'] ?? 'Guru'),
                'subject'           => $this->nullable($row['mata_pelajaran'] ?? null),
                'education'         => $this->nullable($row['pendidikan_terakhir'] ?? null),
                'email'             => $this->nullable($row['email_sekolah'] ?? null),
                'phone'             => $this->nullable($row['no_hp'] ?? null),
                'employment_status' => $this->employment($row['status_kepegawaian_pnspppkhonorer'] ?? $row['status_kepegawaian'] ?? 'pns'),
                'field'             => $this->nullable($row['bidang_jurusan'] ?? $row['bidang'] ?? null),
                'motto'             => $this->nullable($row['moto_hidup'] ?? null),
                'bio'               => $this->nullable($row['bio'] ?? null),
                'sort_order'        => (int) ($row['urutan_tampil'] ?? 0),
                'is_active'         => (int) ($row['aktif_10'] ?? $row['aktif'] ?? 1) === 1,
            ];

            $teacher = null;
            if ($id) {
                $teacher = Teacher::find($id);
            }
            if (! $teacher && $nip) {
                $teacher = Teacher::where('nip', $nip)->first();
            }
            if (! $teacher) {
                $teacher = Teacher::where('name', $name)->first();
            }

            if ($teacher) {
                if (! $teacher->slug) {
                    $attrs['slug'] = $this->makeSlug($name, $teacher->id);
                }
                $teacher->update($attrs);
                $this->updated++;
            } else {
                $attrs['slug'] = $this->makeSlug($name);
                Teacher::create($attrs);
                $this->created++;
            }
        }
    }

    private function employment(?string $value): string
    {
        $v = strtolower(trim((string) $value));
        return in_array($v, ['pns', 'pppk', 'honorer'], true) ? $v : 'pns';
    }

    private function nullable(mixed $value): ?string
    {
        $v = trim((string) $value);

        return $v === '' ? null : $v;
    }

    private function required(mixed $value): string
    {
        return trim((string) $value) ?: 'Guru';
    }

    private function makeSlug(string $name, ?int $exceptId = null): string
    {
        $base = Str::slug($name) ?: 'guru';
        $slug = $base;
        $i = 1;
        while (Teacher::where('slug', $slug)->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
