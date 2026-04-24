<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'PT Astra Honda Motor',  'industry' => 'Otomotif',      'mou_start' => '2023-01-10', 'mou_end' => '2026-01-10'],
            ['name' => 'PT Telkom Indonesia',   'industry' => 'Telekomunikasi','mou_start' => '2022-05-20', 'mou_end' => '2025-05-20'],
            ['name' => 'PT Krakatau Steel',     'industry' => 'Manufaktur',    'mou_start' => '2023-08-01', 'mou_end' => '2026-08-01'],
            ['name' => 'Bank Syariah Indonesia','industry' => 'Perbankan',     'mou_start' => '2024-03-15', 'mou_end' => '2027-03-15'],
            ['name' => 'PT Indofood CBP',       'industry' => 'FMCG',          'mou_start' => '2023-10-10', 'mou_end' => '2026-10-10'],
            ['name' => 'Yamaha Service School', 'industry' => 'Otomotif',      'mou_start' => '2024-02-02', 'mou_end' => '2027-02-02'],
            ['name' => 'Tokopedia',             'industry' => 'E-commerce',    'mou_start' => '2024-07-01', 'mou_end' => '2027-07-01'],
            ['name' => 'PT PLN (Persero)',      'industry' => 'Energi',        'mou_start' => '2023-06-15', 'mou_end' => '2026-06-15'],
        ];

        foreach ($data as $i => $p) {
            Partner::updateOrCreate(
                ['name' => $p['name']],
                $p + ['slug' => Str::slug($p['name']), 'sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
