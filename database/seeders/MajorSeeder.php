<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                'code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak', 'slug' => 'rpl',
                'tagline' => 'Menyiapkan pengembang aplikasi, database, dan sistem teknologi informasi.',
                'description' => 'Kompetensi RPL fokus pada pengembangan aplikasi berbasis web, mobile, desktop, serta pemrograman database dan integrasi sistem.',
                'curriculum' => "Dasar Pemrograman|Pemrograman Web (HTML, CSS, JS, PHP)|Basis Data (MySQL, PostgreSQL)|Pemrograman Mobile (Flutter/Android)|Rekayasa Perangkat Lunak|Praktik Kerja Industri",
                'career_prospects' => "Software Engineer|Web Developer|Mobile App Developer|Database Administrator|IT Support|Wirausaha IT",
                'certifications' => "BNSP Junior Web Developer|Oracle Database|Google Associate Android Developer",
                'head_teacher' => 'Imran Sumarsa, S.T.', 'color' => 'primary',
                'student_count' => 288, 'quota' => 72, 'spmb_quota' => 36, 'sort_order' => 1,
            ],
            [
                'code' => 'AK', 'name' => 'Akuntansi', 'slug' => 'ak',
                'tagline' => 'Pembekalan akuntansi, audit, dan keuangan sesuai standar industri.',
                'description' => 'Kompetensi Akuntansi mempersiapkan lulusan menjadi tenaga akuntansi yang profesional, jujur, dan berintegritas.',
                'curriculum' => "Akuntansi Dasar|Akuntansi Keuangan|Komputer Akuntansi (MYOB, Accurate)|Perpajakan|Administrasi Perkantoran|Praktik Kerja Industri",
                'career_prospects' => "Staff Akuntansi|Staff Pajak|Kasir|Teller Bank|Wirausaha",
                'certifications' => "BNSP Teknisi Akuntansi Junior|Brevet Pajak A",
                'head_teacher' => 'Budi Pranoto, M.T.', 'color' => 'success',
                'student_count' => 216, 'quota' => 72, 'spmb_quota' => 36, 'sort_order' => 2,
            ],
            [
                'code' => 'DKV', 'name' => 'Disain Komunikasi Visual', 'slug' => 'dkv',
                'tagline' => 'Melatih desainer visual, motion graphic, dan multimedia profesional.',
                'description' => 'Kompetensi DKV mempersiapkan siswa menjadi desainer kreatif untuk industri grafis, advertising, dan digital media.',
                'curriculum' => "Dasar Desain Grafis|Typography|Illustrasi Digital|Fotografi|Videografi & Editing|Motion Graphic|Praktik Kerja Industri",
                'career_prospects' => "Graphic Designer|Illustrator|Motion Designer|Fotografer|Video Editor|Wirausaha Kreatif",
                'certifications' => "Adobe Certified Associate|BNSP Desainer Grafis Muda",
                'head_teacher' => 'Maya Sari, S.Ds.', 'color' => 'info',
                'student_count' => 180, 'quota' => 60, 'spmb_quota' => 30, 'sort_order' => 3,
            ],
            [
                'code' => 'TSM', 'name' => 'Teknik Sepeda Motor', 'slug' => 'tsm',
                'tagline' => 'Membentuk teknisi sepeda motor bersertifikasi industri.',
                'description' => 'Kompetensi TSM fokus pada perawatan, perbaikan, dan diagnosis sepeda motor modern dengan teknologi injeksi.',
                'curriculum' => "Dasar Teknik Otomotif|Sistem Engine Sepeda Motor|Sistem Kelistrikan|Injeksi Bahan Bakar|Manajemen Bengkel|Praktik Kerja Industri",
                'career_prospects' => "Teknisi Sepeda Motor|Service Advisor|Quality Control|Sales Sparepart|Wirausaha Bengkel",
                'certifications' => "AHASS Training|Yamaha YES|BNSP Teknisi Kendaraan Ringan",
                'head_teacher' => 'Rahmat Hidayat, S.T.', 'color' => 'danger',
                'student_count' => 252, 'quota' => 84, 'spmb_quota' => 42, 'sort_order' => 4,
            ],
            [
                'code' => 'TITL', 'name' => 'Teknik Instalasi Tenaga Listrik', 'slug' => 'titl',
                'tagline' => 'Menghasilkan teknisi kelistrikan industri dan domestik yang kompeten.',
                'description' => 'Kompetensi TITL mempersiapkan lulusan untuk merancang, memasang, dan memelihara instalasi listrik sesuai standar PUIL.',
                'curriculum' => "Dasar Kelistrikan|Instalasi Penerangan|Instalasi Tenaga|PLC & Otomasi Industri|K3 Listrik|Praktik Kerja Industri",
                'career_prospects' => "Teknisi Listrik|Operator PLC|Kontraktor Instalasi|Pemeliharaan Gedung|Wirausaha",
                'certifications' => "LSK-K3 Listrik|BNSP Teknisi Instalasi Listrik",
                'head_teacher' => 'Dwi Santoso, S.T.', 'color' => 'warning',
                'student_count' => 216, 'quota' => 72, 'spmb_quota' => 36, 'sort_order' => 5,
            ],
        ];

        foreach ($majors as $m) Major::updateOrCreate(['code' => $m['code']], $m + ['is_active' => true]);
    }
}
