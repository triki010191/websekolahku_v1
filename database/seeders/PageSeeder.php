<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Sejarah Sekolah',
                'slug'  => 'sejarah',
                'content' => "<p>SMK Negeri 8 Pandeglang didirikan pada tahun <strong>2008</strong> sebagai jawaban atas kebutuhan tenaga kerja terampil di wilayah Pandeglang dan sekitarnya. Berawal dari ruang kelas sementara, kini SMKN 8 Pandeglang telah menjelma menjadi salah satu SMK rujukan di Banten.</p><p>Sepanjang perjalanannya, SMKN 8 konsisten mengembangkan kurikulum link-and-match dengan kebutuhan DU-DI, membangun bengkel praktik yang modern, dan menghadirkan guru-guru bersertifikasi industri untuk mendukung pencapaian siswa.</p>",
            ],
            [
                'title' => 'Sambutan Kepala Sekolah',
                'slug'  => 'sambutan',
                'content' => "<p>Assalamu'alaikum warahmatullahi wabarakatuh,</p><p>Selamat datang di laman resmi SMK Negeri 8 Pandeglang. Kami berkomitmen untuk mencetak lulusan yang tidak hanya siap kerja, tetapi juga siap berkembang menjadi pribadi yang tangguh, berkarakter, dan berorientasi global.</p><p>Dengan dukungan kurikulum modern, fasilitas bengkel praktik yang lengkap, serta sinergi dengan industri, kami yakin para siswa dapat menempa kompetensi terbaik untuk masa depan mereka.</p><p><strong>Drs. H. Ahmad Fauzi, M.Pd — Kepala Sekolah SMKN 8 Pandeglang</strong></p>",
            ],
            [
                'title' => 'Visi & Misi',
                'slug'  => 'visi-misi',
                'content' => "<h4>Visi</h4><p>Terwujudnya lembaga pendidikan dan pelatihan kejuruan yang bermutu, berkarakter, dan berdaya saing internasional menghasilkan lulusan yang cerdas, kompetitif, dan berakhlak mulia.</p><h4>Misi</h4><ol><li>Melaksanakan pembelajaran yang berbasis kompetensi dan berstandar industri.</li><li>Mengembangkan karakter peserta didik yang religius, disiplin, dan peduli lingkungan.</li><li>Menjalin kerjasama strategis dengan DU-DI untuk memperluas akses magang dan serapan lulusan.</li><li>Menerapkan Sistem Manajemen Mutu yang akuntabel dan transparan.</li></ol>",
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug'  => 'struktur',
                'content' => "<p>Struktur organisasi SMKN 8 Pandeglang mendukung tata kelola yang efektif, transparan, dan berorientasi pada pelayanan mutu pendidikan.</p>",
            ],
            [
                'title' => 'Prestasi Sekolah',
                'slug'  => 'prestasi',
                'content' => "<p>SMKN 8 Pandeglang secara konsisten meraih prestasi di tingkat kabupaten, provinsi, hingga nasional — termasuk bidang LKS IT, Adiwiyata, dan kerjasama internasional.</p><p>Prestasi ini didukung oleh bimbingan guru, fasilitas praktik yang memadai, serta semangat kolaboratif seluruh warga sekolah.</p>",
            ],
            [
                'title' => 'Tata Tertib',
                'slug'  => 'tata-tertib',
                'content' => "<h4>Kewajiban Siswa</h4><ol><li>Hadir di sekolah paling lambat 10 menit sebelum jam pelajaran.</li><li>Mengenakan seragam sesuai jadwal.</li><li>Mengikuti seluruh kegiatan pembelajaran dengan baik.</li></ol><h4>Larangan</h4><ol><li>Merokok di lingkungan sekolah.</li><li>Menggunakan HP selama KBM tanpa izin guru.</li><li>Membawa barang yang tidak berkaitan dengan pembelajaran.</li></ol>",
            ],
        ];

        foreach ($pages as $p) Page::updateOrCreate(['slug' => $p['slug']], $p + ['is_published' => true]);
    }
}
