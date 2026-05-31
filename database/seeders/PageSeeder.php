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
                'content' => "<p>Assalamu'alaikum warahmatullahi wabarakatuh,</p><p>Selamat datang di laman resmi SMK Negeri 8 Pandeglang. Kami berkomitmen untuk mencetak lulusan yang tidak hanya siap kerja, tetapi juga siap berkembang menjadi pribadi yang tangguh, berkarakter, dan berorientasi global.</p><p>Dengan dukungan kurikulum modern, fasilitas bengkel praktik yang lengkap, serta sinergi dengan industri, kami yakin para siswa dapat menempa kompetensi terbaik untuk masa depan mereka.</p><p><strong>Ir. ASDIARNITA, M.Pd. — Kepala Sekolah SMKN 8 Pandeglang</strong></p>",
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
            [
                'title' => 'Informasi SPMB 2026',
                'slug'  => 'spmb-2026',
                'content' => "<h4>Alur Pendaftaran</h4><ol><li>Pastikan memenuhi persyaratan usia dan kelulusan SMP/MTs/sederajat.</li><li>Siapkan NISN, ijazah/surat keterangan lulus, KK, akta kelahiran, dan pas foto.</li><li>Daftar online melalui tombol <strong>Daftar Online</strong> di halaman ini, atau portal resmi SPMB Provinsi Banten.</li><li>Upload berkas persyaratan dengan jelas dan lengkap.</li><li>Pantau pengumuman di kolom kanan halaman ini untuk info seleksi dan hasil.</li></ol><h4>Persyaratan Umum</h4><ul><li>Lulus SMP/MTs/sederajat tahun berjalan atau sebelumnya.</li><li>Sehat jasmani dan rohani.</li><li>Bersedia mengikuti tata tertib sekolah.</li></ul><h4>Jalur Pendaftaran</h4><p>Zonasi, prestasi, afirmasi, dan mutasi — sesuai ketentuan SPMB yang berlaku.</p><h4>Catatan</h4><p>Informasi jadwal pembukaan, penutupan, dan pengumuman hasil diperbarui secara berkala. Perubahan mendadak akan diumumkan melalui kolom <strong>Pengumuman SPMB</strong> di halaman ini.</p>",
                'meta_title' => 'Info SPMB 2026/2027 — SMKN 8 Pandeglang',
                'meta_description' => 'Informasi resmi SPMB SMKN 8 Pandeglang: jadwal, kuota jurusan, alur pendaftaran, dan pengumuman terbaru.',
            ],
        ];

        foreach ($pages as $p) Page::updateOrCreate(['slug' => $p['slug']], $p + ['is_published' => true]);
    }
}
