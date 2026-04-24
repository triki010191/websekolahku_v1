<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['category' => 'ppdb', 'question' => 'Kapan pendaftaran PPDB 2026/2027 dibuka?',
             'answer' => 'Pendaftaran PPDB 2026/2027 dibuka mulai 1 Juni – 15 Juli 2026 melalui portal online.'],
            ['category' => 'ppdb', 'question' => 'Apa saja syarat pendaftaran PPDB?',
             'answer' => 'Fotokopi ijazah SMP/MTs, Kartu Keluarga, akta kelahiran, dan pas foto 3×4 latar merah.'],
            ['category' => 'ppdb', 'question' => 'Bagaimana jalur penerimaan PPDB di SMKN 8?',
             'answer' => 'Terdapat 4 jalur: Zonasi, Prestasi, Afirmasi (KIP/tidak mampu), dan Mutasi orang tua.'],
            ['category' => 'akademik', 'question' => 'Berapa jumlah jurusan di SMKN 8 Pandeglang?',
             'answer' => 'SMKN 8 Pandeglang memiliki 5 jurusan: RPL, AKL, DKV, TBSM, dan TITL.'],
            ['category' => 'akademik', 'question' => 'Apakah ada program magang?',
             'answer' => 'Ya, semua jurusan menjalani PKL/Magang selama 4–6 bulan di mitra DU-DI.'],
            ['category' => 'umum',     'question' => 'Di mana lokasi SMKN 8 Pandeglang?',
             'answer' => 'Jl. Raya Pandeglang Km. 5, Kadomas, Kec. Pandeglang, Banten 42252.'],
        ];

        foreach ($data as $i => $f) {
            Faq::updateOrCreate(
                ['question' => $f['question']],
                $f + ['sort_order' => $i, 'is_published' => true]
            );
        }
    }
}
