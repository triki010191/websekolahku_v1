<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            ['title' => 'HUT RI ke-80',              'category' => 'Upacara'],
            ['title' => 'LKS Provinsi 2026',         'category' => 'Lomba'],
            ['title' => 'PKL Batch #8',              'category' => 'PKL'],
            ['title' => 'Upacara Senin Rutin',       'category' => 'Upacara'],
            ['title' => 'Kunjungan Industri Cilegon','category' => 'Kegiatan'],
            ['title' => 'Class Meeting 2025',        'category' => 'Kegiatan'],
        ];

        foreach ($albums as $i => $a) {
            $album = GalleryAlbum::updateOrCreate(
                ['slug' => Str::slug($a['title'])],
                [
                    'title'        => $a['title'],
                    'slug'         => Str::slug($a['title']),
                    'category'     => $a['category'],
                    'description'  => 'Dokumentasi kegiatan: ' . $a['title'],
                    'is_published' => true,
                ]
            );

            for ($n = 1; $n <= 6; $n++) {
                GalleryItem::updateOrCreate(
                    ['album_id' => $album->id, 'sort_order' => $n],
                    [
                        'type'  => 'photo',
                        'title' => $a['title'] . ' #' . $n,
                        'url'   => 'https://picsum.photos/seed/' . urlencode($a['title'] . $n) . '/800/600',
                    ]
                );
            }
        }
    }
}
