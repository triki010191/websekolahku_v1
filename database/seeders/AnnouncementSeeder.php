<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', User::ROLE_SUPER_ADMIN)->first();
        $akademik = Category::where(['type' => 'announcement', 'name' => 'Akademik'])->first();
        $ppdb     = Category::where(['type' => 'announcement', 'name' => 'PPDB'])->first();
        $libur    = Category::where(['type' => 'announcement', 'name' => 'Libur'])->first();

        $data = [
            ['title' => 'Rapat Dinas Persiapan UAS Ganjil 2026', 'priority' => 'important', 'category_id' => $akademik?->id, 'published_at' => now(), 'expires_at' => now()->addDays(10), 'content' => 'Seluruh guru wajib hadir rapat persiapan UAS pada hari Senin depan.'],
            ['title' => 'Pelaksanaan UTS Ganjil 2026',             'priority' => 'normal',    'category_id' => $akademik?->id, 'published_at' => now()->subDays(3), 'expires_at' => now()->addDays(10), 'content' => 'Pelaksanaan UTS ganjil dimulai tanggal 15 April 2026. Lihat jadwal lengkap di menu Download.'],
            ['title' => 'Pendaftaran PPDB 2026/2027 Dibuka',       'priority' => 'urgent',    'category_id' => $ppdb?->id,     'published_at' => now()->subDays(5), 'expires_at' => now()->addDays(30), 'content' => 'Pendaftaran PPDB 2026/2027 telah dibuka. Segera daftar melalui portal online.'],
            ['title' => 'Libur Hari Raya Idul Fitri 1447 H',        'priority' => 'important', 'category_id' => $libur?->id,    'published_at' => now()->subDays(1), 'expires_at' => now()->addDays(12), 'content' => 'Sekolah libur mulai tanggal X sampai Y. Selamat merayakan Idul Fitri.'],
            ['title' => 'Workshop Digital Marketing bagi Siswa DKV','priority' => 'normal',    'category_id' => $akademik?->id, 'published_at' => now()->subDays(2), 'expires_at' => now()->addDays(8), 'content' => 'Workshop digital marketing khusus siswa DKV bersama praktisi industri.'],
        ];

        foreach ($data as $a) {
            Announcement::updateOrCreate(
                ['title' => $a['title']],
                $a + [
                    'user_id' => $user?->id,
                    'slug'    => Str::slug($a['title']),
                    'status'  => 'active',
                ]
            );
        }
    }
}
