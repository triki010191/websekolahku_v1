<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title'       => 'Pusat Keunggulan & Prestasi Akademik',
                'subtitle'    => 'Sekolah Pusat Keunggulan',
                'description' => 'Mencetak lulusan unggul melalui pendidikan vokasi berkualitas, integrasi industri, dan lingkungan belajar yang kolaboratif.',
                'cta_text'    => 'Daftar PPDB',
                'cta_url'     => '/ppdb',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'PPDB 2026/2027 Telah Dibuka',
                'subtitle'    => 'Pendaftaran Online',
                'description' => 'Bergabunglah dengan SMKN 8 Pandeglang. 5 jurusan unggulan, 360 kursi tersedia. Pendaftaran 1 Juni – 15 Juli 2026.',
                'cta_text'    => 'Daftar Sekarang',
                'cta_url'     => '/ppdb',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Jurusan Unggulan & Link-and-Match Industri',
                'subtitle'    => '5 Kompetensi Keahlian',
                'description' => 'RPL, AKL, DKV, TBSM, TITL — dibina oleh guru bersertifikasi industri dan mitra DU-DI nasional.',
                'cta_text'    => 'Lihat Jurusan',
                'cta_url'     => '/jurusan',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($banners as $b) Banner::updateOrCreate(['title' => $b['title']], $b);
    }
}
