<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Pramuka',           'icon' => '⛺', 'category' => 'Kepanduan', 'schedule' => 'Jumat, 14.00 – 16.00', 'coach' => 'Kak Ahmad',   'member_count' => 180],
            ['name' => 'Paskibra',          'icon' => '🇮🇩', 'category' => 'Kedisiplinan', 'schedule' => 'Sabtu, 07.00 – 09.00', 'coach' => 'Kak Budi', 'member_count' => 40],
            ['name' => 'Rohis',             'icon' => '🕌', 'category' => 'Keagamaan', 'schedule' => 'Jumat, 13.00 – 14.00', 'coach' => 'Ust. Yusuf', 'member_count' => 120],
            ['name' => 'Basket',            'icon' => '🏀', 'category' => 'Olahraga', 'schedule' => 'Rabu, 15.30 – 17.30', 'coach' => 'Pak Dani', 'member_count' => 35],
            ['name' => 'Futsal',            'icon' => '⚽', 'category' => 'Olahraga', 'schedule' => 'Selasa, 15.30 – 17.30', 'coach' => 'Pak Adi', 'member_count' => 60],
            ['name' => 'Band Sekolah',      'icon' => '🎸', 'category' => 'Seni', 'schedule' => 'Kamis, 15.30 – 17.30', 'coach' => 'Pak Riki', 'member_count' => 25],
            ['name' => 'English Club',      'icon' => '🌐', 'category' => 'Akademik', 'schedule' => 'Senin, 15.30 – 17.00', 'coach' => 'Ms. Rina', 'member_count' => 45],
            ['name' => 'KIR (Karya Ilmiah)','icon' => '🔬', 'category' => 'Akademik', 'schedule' => 'Kamis, 15.00 – 16.30', 'coach' => 'Bu Sari',  'member_count' => 30],
            ['name' => 'PMR',               'icon' => '❤️', 'category' => 'Kesehatan', 'schedule' => 'Rabu, 14.00 – 15.30', 'coach' => 'Bu Nining', 'member_count' => 28],
            ['name' => 'E-Sport',           'icon' => '🎮', 'category' => 'Teknologi', 'schedule' => 'Sabtu, 13.00 – 15.00', 'coach' => 'Pak Rendi', 'member_count' => 50],
        ];

        foreach ($data as $e) {
            Extracurricular::updateOrCreate(
                ['name' => $e['name']],
                $e + ['slug' => Str::slug($e['name']), 'is_active' => true]
            );
        }
    }
}
