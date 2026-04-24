<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Ruang Kelas',     'icon' => 'bi-easel',         'description' => '36 ruang kelas modern dilengkapi AC, proyektor, dan sistem audio.'],
            ['name' => 'Lab Komputer',    'icon' => 'bi-pc-display',    'description' => '4 lab komputer dengan PC dan jaringan gigabit untuk program RPL, AKL, DKV.'],
            ['name' => 'Perpustakaan',    'icon' => 'bi-book',          'description' => 'Koleksi > 5.000 buku, e-library, ruang baca nyaman, akses WiFi cepat.'],
            ['name' => 'Bengkel Praktik', 'icon' => 'bi-tools',         'description' => 'Bengkel TBSM dan TITL berstandar industri untuk praktikum harian.'],
            ['name' => 'Mushola',         'icon' => 'bi-moon-stars',    'description' => 'Mushola dua lantai dengan kapasitas 300 jamaah.'],
            ['name' => 'Lapangan',        'icon' => 'bi-dribbble',      'description' => 'Lapangan multifungsi untuk upacara, futsal, basket, dan voli.'],
            ['name' => 'Kantin',          'icon' => 'bi-cup-hot',       'description' => 'Kantin sehat dengan 10 tenant terverifikasi higienis.'],
            ['name' => 'Parkiran',        'icon' => 'bi-p-circle',      'description' => 'Parkir kendaraan siswa, guru, dan tamu yang aman.'],
            ['name' => 'Ruang Guru',      'icon' => 'bi-people',        'description' => 'Ruang guru representatif dengan fasilitas kerja lengkap.'],
            ['name' => 'Ruang TU',        'icon' => 'bi-person-badge',  'description' => 'Front office pelayanan administrasi siswa & orang tua.'],
        ];

        foreach ($data as $i => $f) {
            Facility::updateOrCreate(
                ['name' => $f['name']],
                $f + ['slug' => \Illuminate\Support\Str::slug($f['name']), 'sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
