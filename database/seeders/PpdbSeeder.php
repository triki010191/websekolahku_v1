<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Database\Seeder;

class PpdbSeeder extends Seeder
{
    public function run(): void
    {
        $majorRpl  = Major::where('code', 'RPL')->first();
        $majorAk   = Major::where('code', 'AK')->first();
        $majorDkv  = Major::where('code', 'DKV')->first();
        $majorTsm  = Major::where('code', 'TSM')->first();
        $majorTitl = Major::where('code', 'TITL')->first();

        $data = [
            ['full_name' => 'Ahmad Fauzi Ramadhan', 'nisn' => '0081234567', 'gender' => 'L', 'previous_school' => 'SMPN 1 Pandeglang', 'major_id' => $majorRpl?->id,  'pathway' => 'zonasi',   'status' => 'pending'],
            ['full_name' => 'Siti Nurhaliza',       'nisn' => '0081234568', 'gender' => 'P', 'previous_school' => 'MTs Al-Hidayah',    'major_id' => $majorAk?->id,  'pathway' => 'prestasi', 'status' => 'revisi'],
            ['full_name' => 'Rendi Prasetya',       'nisn' => '0081234569', 'gender' => 'L', 'previous_school' => 'SMPN 2 Pandeglang', 'major_id' => $majorDkv?->id,  'pathway' => 'zonasi',   'status' => 'accepted'],
            ['full_name' => 'Bagus Wicaksono',      'nisn' => '0081234570', 'gender' => 'L', 'previous_school' => 'SMPN 3 Pandeglang', 'major_id' => $majorTsm?->id, 'pathway' => 'afirmasi', 'status' => 'pending'],
            ['full_name' => 'Dewi Lestari',         'nisn' => '0081234571', 'gender' => 'P', 'previous_school' => 'MTs Mathla\'ul Anwar', 'major_id' => $majorTitl?->id, 'pathway' => 'zonasi', 'status' => 'rejected'],
        ];

        foreach ($data as $i => $d) {
            PpdbRegistration::updateOrCreate(
                ['nisn' => $d['nisn']],
                $d + [
                    'registration_number' => 'PPDB-' . date('Y') . '-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'religion'            => 'Islam',
                    'birth_place'         => 'Pandeglang',
                    'birth_date'          => now()->subYears(16)->subDays(random_int(1, 365)),
                    'phone'               => '08' . random_int(100000000, 999999999),
                    'email'               => strtolower(str_replace(' ', '.', $d['full_name'])) . '@example.com',
                    'address'             => 'Jl. Contoh No. ' . ($i + 1),
                    'city'                => 'Pandeglang',
                    'postal_code'         => '42252',
                    'graduation_year'     => 2026,
                ]
            );
        }
    }
}
