<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji status HTTP halaman publik utama setelah seed.
     */
    public function test_key_public_routes_respond_ok(): void
    {
        $this->seed();

        $getPaths = [
            '/',
            '/berita',
            '/pengumuman',
            '/jurusan',
            '/guru',
            '/galeri',
            '/event',
            '/kalender',
            '/download',
            '/fasilitas',
            '/ekstrakurikuler',
            '/alumni',
            '/alumni/lowongan',
            '/kerjasama',
            '/faq',
            '/kontak',
            '/ppdb',
            '/spmb-2026',
            '/ppdb/daftar',
            '/profil/sejarah',
            '/profil/sambutan',
        ];

        foreach ($getPaths as $path) {
            $this->get($path)->assertOk();
        }

        $teacher = \App\Models\Teacher::where('is_active', true)->whereNotNull('slug')->first();
        if ($teacher) {
            $this->get('/guru/'.$teacher->slug)->assertOk();
        }

        $post = Post::published()->first();
        if ($post) {
            $this->get('/berita/'.$post->slug)->assertOk();
        }
    }
}
