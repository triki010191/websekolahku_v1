<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title' => 'Workshop Digital Marketing DKV',   'start_at' => now()->addDays(3),  'location' => 'Aula Utama',      'status' => 'upcoming', 'description' => 'Workshop praktis teknik digital marketing untuk siswa DKV.'],
            ['title' => 'Gebyar PPDB 2026/2027',           'start_at' => now()->addDays(10), 'location' => 'Lapangan Utama', 'status' => 'upcoming', 'description' => 'Sosialisasi & open house penerimaan siswa baru.'],
            ['title' => 'LKS Tingkat Provinsi',            'start_at' => now()->subDays(5),  'location' => 'SMKN 1 Serang',  'status' => 'finished', 'description' => 'Kompetisi keahlian siswa antar SMK se-Banten.'],
            ['title' => 'Kunjungan Industri ke Cilegon',   'start_at' => now()->addDays(18), 'location' => 'Kawasan Industri Cilegon', 'status' => 'upcoming', 'description' => 'Kunjungan industri siswa kelas XI.'],
            ['title' => 'Pelantikan OSIS 2026',            'start_at' => now()->subDays(20), 'location' => 'Aula Utama',      'status' => 'finished', 'description' => 'Pelantikan pengurus OSIS baru.'],
            ['title' => 'Ujian Tengah Semester Ganjil',    'start_at' => now()->addDays(25), 'location' => 'Ruang Kelas',     'status' => 'upcoming', 'description' => 'Pelaksanaan UTS bagi seluruh siswa.'],
        ];

        foreach ($data as $e) {
            Event::updateOrCreate(
                ['title' => $e['title']],
                $e + ['slug' => Str::slug($e['title']), 'is_featured' => false]
            );
        }
    }
}
