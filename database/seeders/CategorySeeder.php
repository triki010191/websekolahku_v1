<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Post categories
            ['name' => 'Kegiatan',   'color' => 'primary',   'type' => 'post'],
            ['name' => 'Prestasi',   'color' => 'warning',   'type' => 'post'],
            ['name' => 'Akademik',   'color' => 'info',      'type' => 'post'],
            ['name' => 'Kerjasama',  'color' => 'success',   'type' => 'post'],
            ['name' => 'Umum',       'color' => 'secondary', 'type' => 'post'],

            // Announcement categories
            ['name' => 'Akademik',   'color' => 'primary', 'type' => 'announcement'],
            ['name' => 'PPDB',       'color' => 'warning', 'type' => 'announcement'],
            ['name' => 'Libur',      'color' => 'danger',  'type' => 'announcement'],
            ['name' => 'Kegiatan',   'color' => 'success', 'type' => 'announcement'],

            // Download categories
            ['name' => 'Formulir',           'color' => 'primary',  'type' => 'download'],
            ['name' => 'Kurikulum',          'color' => 'info',     'type' => 'download'],
            ['name' => 'Administrasi',       'color' => 'warning',  'type' => 'download'],
            ['name' => 'Materi Pembelajaran','color' => 'success',  'type' => 'download'],
        ];

        foreach ($data as $r) {
            Category::updateOrCreate(
                ['slug' => Str::slug($r['name'] . '-' . $r['type'])],
                $r + ['slug' => Str::slug($r['name'] . '-' . $r['type'])]
            );
        }
    }
}
