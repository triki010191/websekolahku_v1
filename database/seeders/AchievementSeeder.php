<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title' => 'Juara 1 LKS IT Network',          'level' => 'provinsi',       'category' => 'IT Network',      'winner' => 'Ahmad Rizki (XII RPL)',     'year' => 2025],
            ['title' => 'Juara 2 Lomba Akuntansi Digital', 'level' => 'nasional',       'category' => 'Akuntansi',       'winner' => 'Nurul Safitri (XII AKL)',   'year' => 2024],
            ['title' => 'Finalist Festival Inovasi Pelajar','level' => 'nasional',      'category' => 'Inovasi',         'winner' => 'Tim Robotik SMKN 8',        'year' => 2024],
            ['title' => 'Juara 1 Desain Poster Hari Guru', 'level' => 'kabupaten',      'category' => 'Desain Grafis',   'winner' => 'Rizky Kurniawan (XII DKV)', 'year' => 2024],
            ['title' => 'Juara 3 LKS Otomotif Sepeda Motor','level' => 'provinsi',      'category' => 'Otomotif',        'winner' => 'Bagus Wicaksono (XII TBSM)','year' => 2025],
            ['title' => 'Juara Harapan Karya Tulis Ilmiah','level' => 'provinsi',       'category' => 'Akademik',        'winner' => 'KIR SMKN 8',                'year' => 2023],
        ];

        foreach ($data as $a) Achievement::updateOrCreate(['title' => $a['title']], $a);
    }
}
