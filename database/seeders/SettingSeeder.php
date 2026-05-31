<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // identity
            ['key' => 'site_name',         'value' => 'SMK Negeri 8 Pandeglang',                  'group' => 'identity'],
            ['key' => 'site_short',        'value' => 'SMKN 8 Pandeglang',                        'group' => 'identity'],
            ['key' => 'site_tagline',      'value' => 'Pusat Keunggulan & Prestasi Akademik',     'group' => 'identity'],
            ['key' => 'site_npsn',         'value' => '20604321',                                 'group' => 'identity'],
            ['key' => 'site_accreditation', 'value' => 'A (Unggul)',                               'group' => 'identity'],
            ['key' => 'site_logo',         'value' => '',                                         'group' => 'identity', 'type' => 'image'],
            ['key' => 'hero_principal_image', 'value' => '',                                    'group' => 'identity', 'type' => 'image'],
            ['key' => 'hero_principal_caption', 'value' => 'Ir. ASDIARNITA, M.Pd.',              'group' => 'identity'],
            ['key' => 'sambutan_section_image', 'value' => '',                                    'group' => 'identity', 'type' => 'image'],

            // theme
            ['key' => 'theme_primary',     'value' => '#1d4ed8', 'group' => 'theme', 'type' => 'color'],
            ['key' => 'theme_secondary',   'value' => '#f59e0b', 'group' => 'theme', 'type' => 'color'],
            ['key' => 'theme_accent',      'value' => '#10b981', 'group' => 'theme', 'type' => 'color'],
            ['key' => 'theme_mode',        'value' => 'light',   'group' => 'theme'],

            // contact
            ['key' => 'contact_address',  'value' => 'Jl. Raya Pandeglang Km. 5, Kadomas, Pandeglang, Banten 42252', 'group' => 'contact'],
            ['key' => 'contact_phone',    'value' => '(0253) 123-4567',                  'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '+6281234567890',                   'group' => 'contact'],
            ['key' => 'contact_email',    'value' => 'info@smkn8pandeglang.sch.id',      'group' => 'contact'],
            ['key' => 'contact_ppdb',     'value' => 'ppdb@smkn8pandeglang.sch.id',      'group' => 'contact'],
            ['key' => 'contact_latitude', 'value' => '-6.3000',                          'group' => 'contact'],
            ['key' => 'contact_longitude', 'value' => '106.1023',                         'group' => 'contact'],

            // social
            ['key' => 'social_instagram', 'value' => 'smkn8pandeglang', 'group' => 'social'],
            ['key' => 'social_facebook',  'value' => 'smkn8pandeglang', 'group' => 'social'],
            ['key' => 'social_youtube',   'value' => '@smkn8pandeglang', 'group' => 'social'],
            ['key' => 'social_tiktok',    'value' => '@smkn8pandeglang', 'group' => 'social'],

            // seo
            ['key' => 'seo_title',       'value' => 'SMKN 8 Pandeglang — Pusat Keunggulan & Prestasi Akademik', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'SMK Negeri 8 Pandeglang — SMK rujukan di Banten dengan 5 jurusan unggulan: RPL, AKL, DKV, TBSM, TITL. PPDB 2026/2027 sedang dibuka.', 'group' => 'seo'],
            ['key' => 'seo_keywords',    'value' => 'SMKN 8 Pandeglang, SMK Banten, PPDB Pandeglang, RPL, AKL, DKV, TBSM, TITL', 'group' => 'seo'],

            // PPDB
            ['key' => 'ppdb_year',     'value' => '2026/2027',       'group' => 'ppdb'],
            ['key' => 'ppdb_is_open',  'value' => '1',               'group' => 'ppdb', 'type' => 'bool'],
            ['key' => 'ppdb_start',    'value' => '2026-06-01',      'group' => 'ppdb', 'type' => 'date'],
            ['key' => 'ppdb_end',      'value' => '2026-07-15',      'group' => 'ppdb', 'type' => 'date'],
            ['key' => 'ppdb_announce', 'value' => '2026-07-20',      'group' => 'ppdb', 'type' => 'date'],
            ['key' => 'spmb_banten_url',  'value' => 'https://spmb.bantenprov.go.id/', 'group' => 'ppdb'],
            ['key' => 'spmb_banten_logo', 'value' => '',               'group' => 'ppdb', 'type' => 'image'],
        ];

        foreach ($data as $row) {
            Setting::updateOrCreate(
                ['key' => $row['key']],
                [
                    'value' => $row['value'],
                    'group' => $row['group'] ?? 'general',
                    'type' => $row['type'] ?? 'text',
                ]
            );
        }
    }
}
