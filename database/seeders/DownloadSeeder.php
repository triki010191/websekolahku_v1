<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Download;
use Illuminate\Database\Seeder;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        $formulir = Category::where(['type' => 'download', 'name' => 'Formulir'])->first();
        $kurikulum= Category::where(['type' => 'download', 'name' => 'Kurikulum'])->first();
        $admin    = Category::where(['type' => 'download', 'name' => 'Administrasi'])->first();
        $materi   = Category::where(['type' => 'download', 'name' => 'Materi Pembelajaran'])->first();

        $data = [
            ['title' => 'Formulir PPDB 2026/2027 (PDF)',        'category_id' => $formulir?->id,  'file_type' => 'pdf',  'file_size' => 245_000],
            ['title' => 'Juknis PPDB 2026/2027',                'category_id' => $formulir?->id,  'file_type' => 'pdf',  'file_size' => 1_200_000],
            ['title' => 'Kalender Akademik 2026/2027',          'category_id' => $admin?->id,     'file_type' => 'pdf',  'file_size' => 380_000],
            ['title' => 'Kurikulum Merdeka — RPL',              'category_id' => $kurikulum?->id, 'file_type' => 'pdf',  'file_size' => 720_000],
            ['title' => 'Modul Ajar Dasar Pemrograman',         'category_id' => $materi?->id,    'file_type' => 'docx', 'file_size' => 96_000],
            ['title' => 'Contoh Surat Izin Tidak Masuk',        'category_id' => $admin?->id,     'file_type' => 'doc',  'file_size' => 52_000],
        ];

        foreach ($data as $d) {
            Download::updateOrCreate(
                ['title' => $d['title']],
                $d + [
                    'file_path'   => 'downloads/' . \Illuminate\Support\Str::slug($d['title']) . '.' . $d['file_type'],
                    'description' => 'Unduhan resmi dari SMKN 8 Pandeglang.',
                    'is_public'   => true,
                ]
            );
        }
    }
}
