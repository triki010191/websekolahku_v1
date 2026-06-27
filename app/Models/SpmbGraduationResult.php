<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpmbGraduationResult extends Model
{
    public const ACCEPTED_MAJORS = [
        'Akuntansi 1',
        'Akuntansi 2',
        'Rekayasa Perangkat Lunak 1',
        'Rekayasa Perangkat Lunak 2',
        'Teknik Instalasi Tenaga Listrik 1',
        'Teknik Instalasi Tenaga Listrik 2',
        'Teknik Sepeda Motor',
        'Desain Komunikasi Visual',
    ];

    protected $fillable = [
        'sort_order',
        'registration_number',
        'nisn',
        'full_name',
        'gender',
        'origin_school',
        'accepted_major',
        'academic_year',
    ];

    public static function normalizeMajor(string $value): ?string
    {
        $value = trim(preg_replace('/\s+/', ' ', $value) ?? '');

        if ($value === '') {
            return null;
        }

        foreach (self::ACCEPTED_MAJORS as $major) {
            if (strcasecmp($major, $value) === 0) {
                return $major;
            }
        }

        $aliases = [
            'rakayasa perangkat lunak 1' => 'Rekayasa Perangkat Lunak 1',
            'rakayasa perangkat lunak 2' => 'Rekayasa Perangkat Lunak 2',
            'rpl 1'                      => 'Rekayasa Perangkat Lunak 1',
            'rpl 2'                      => 'Rekayasa Perangkat Lunak 2',
            'titr 1'                     => 'Teknik Instalasi Tenaga Listrik 1',
            'titr 2'                     => 'Teknik Instalasi Tenaga Listrik 2',
            'titl 1'                     => 'Teknik Instalasi Tenaga Listrik 1',
            'titl 2'                     => 'Teknik Instalasi Tenaga Listrik 2',
            'tsm'                        => 'Teknik Sepeda Motor',
            'dkv'                        => 'Desain Komunikasi Visual',
            'ak 1'                       => 'Akuntansi 1',
            'ak 2'                       => 'Akuntansi 2',
        ];

        $key = strtolower($value);

        return $aliases[$key] ?? $value;
    }

    public static function genderLabel(string $gender): string
    {
        return strtoupper($gender) === 'P' ? 'P' : 'L';
    }
}
