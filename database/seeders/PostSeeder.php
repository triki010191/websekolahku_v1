<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $editor = User::where('role', User::ROLE_ADMIN_BERITA)->first() ?? $admin;

        $catKegiatan  = Category::where(['type' => 'post', 'name' => 'Kegiatan'])->first();
        $catPrestasi  = Category::where(['type' => 'post', 'name' => 'Prestasi'])->first();
        $catAkademik  = Category::where(['type' => 'post', 'name' => 'Akademik'])->first();
        $catKerjasama = Category::where(['type' => 'post', 'name' => 'Kerjasama'])->first();

        $posts = [
            [
                'title' => 'Kunjungan Industri Siswa SMKN 8 ke Kawasan Industri Cilegon',
                'category_id' => $catKegiatan?->id,
                'excerpt' => 'Sebanyak 120 siswa mengunjungi perusahaan manufaktur di Cilegon sebagai bagian dari program link-and-match.',
                'content' => '<p>Sebanyak 120 siswa kelas XI mengunjungi beberapa perusahaan di Kawasan Industri Cilegon sebagai bagian dari program link-and-match SMKN 8 Pandeglang. Kegiatan ini bertujuan untuk memberikan pengalaman langsung kepada siswa mengenai dunia kerja di industri manufaktur modern.</p><p>Siswa juga berkesempatan berdiskusi dengan para engineer dan melihat proses produksi secara langsung.</p>',
                'is_featured' => true,
                'views' => 1284,
            ],
            [
                'title' => 'Siswa RPL Raih Juara 1 Lomba Kompetensi Siswa Tingkat Provinsi',
                'category_id' => $catPrestasi?->id,
                'excerpt' => 'Ahmad Rizki, siswa kelas XII RPL, berhasil meraih Juara 1 cabang IT Network pada LKS Provinsi Banten 2025.',
                'content' => '<p>Prestasi membanggakan kembali ditorehkan siswa SMKN 8 Pandeglang. Ahmad Rizki, siswa kelas XII RPL, berhasil meraih <strong>Juara 1</strong> cabang IT Network pada LKS Provinsi Banten 2025.</p>',
                'views' => 2150,
            ],
            [
                'title' => 'Peluncuran Jurusan DKV 2.0 — Penguatan Multimedia Digital',
                'category_id' => $catAkademik?->id,
                'excerpt' => 'SMKN 8 meluncurkan kurikulum DKV 2.0 dengan fokus pada motion graphic, video editing, dan UI/UX design.',
                'content' => '<p>Dalam rangka menjawab kebutuhan industri kreatif, SMKN 8 Pandeglang meluncurkan <strong>DKV 2.0</strong> — kurikulum baru yang fokus pada motion graphic, video editing profesional, dan UI/UX design.</p>',
                'views' => 840,
            ],
            [
                'title' => 'MoU SMKN 8 Pandeglang dengan PT Astra Honda Motor',
                'category_id' => $catKerjasama?->id,
                'excerpt' => 'Penandatanganan kerjasama dengan AHM untuk program magang dan sertifikasi siswa TBSM.',
                'content' => '<p>SMKN 8 Pandeglang resmi menjalin kerjasama dengan PT Astra Honda Motor (AHM) untuk program magang dan sertifikasi siswa TBSM. Kerjasama ini diharapkan dapat meningkatkan kompetensi lulusan.</p>',
                'views' => 980,
            ],
            [
                'title' => 'Pembiasaan Literasi Membaca 15 Menit Sebelum KBM',
                'category_id' => $catAkademik?->id,
                'excerpt' => 'Kepala Sekolah mencanangkan program literasi 15 menit sebelum KBM dimulai.',
                'content' => '<p>Guna menumbuhkan budaya literasi, SMKN 8 mencanangkan program membaca 15 menit sebelum KBM dimulai setiap hari Senin–Jumat.</p>',
                'views' => 520,
            ],
            [
                'title' => 'Perayaan HUT RI ke-80 di SMKN 8 Pandeglang',
                'category_id' => $catKegiatan?->id,
                'excerpt' => 'Upacara bendera, lomba panjat pinang, dan aneka pertandingan meriahkan HUT RI.',
                'content' => '<p>SMKN 8 Pandeglang menggelar upacara bendera dan aneka lomba untuk memeriahkan HUT RI ke-80. Seluruh warga sekolah antusias mengikuti kegiatan.</p>',
                'views' => 720,
            ],
        ];

        foreach ($posts as $p) {
            Post::updateOrCreate(
                ['title' => $p['title']],
                [
                    'user_id'      => $editor?->id,
                    'category_id'  => $p['category_id'],
                    'slug'         => Str::slug($p['title']),
                    'excerpt'      => $p['excerpt'],
                    'content'      => $p['content'],
                    'status'       => 'published',
                    'published_at' => now()->subDays(random_int(1, 30)),
                    'views'        => $p['views'] ?? 0,
                    'is_featured'  => $p['is_featured'] ?? false,
                    'tags'         => 'sekolah, smkn8, pandeglang',
                ]
            );
        }
    }
}
