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
            ['key' => 'contact_latitude', 'value' => '-6.3127483',                         'group' => 'contact'],
            ['key' => 'contact_longitude', 'value' => '106.0009228',                        'group' => 'contact'],
            ['key' => 'google_maps_url', 'value' => 'https://www.google.com/maps/place/SMKN+8+Pandeglang/@-6.3127483,105.9983479,17z/data=!4m14!1m7!3m6!1s0x2e42253a4c8313ab:0xe7feefa55f6c6cd1!2sSMKN+8+Pandeglang!8m2!3d-6.3127483!4d106.0009228!16s%2Fg%2F1q5bl88qp!3m5!1s0x2e42253a4c8313ab:0xe7feefa55f6c6cd1!8m2!3d-6.3127483!4d106.0009228!16s%2Fg%2F1q5bl88qp?entry=ttu', 'group' => 'contact'],

            // social
            ['key' => 'social_instagram', 'value' => 'smkn8pandeglang_official', 'group' => 'social'],
            ['key' => 'social_facebook',  'value' => 'smkn8pandeglang', 'group' => 'social'],
            ['key' => 'social_youtube',   'value' => '@SMKN8PANDEGLANG', 'group' => 'social'],
            ['key' => 'social_tiktok',    'value' => '@smkn8pandeglang', 'group' => 'social'],
            ['key' => 'youtube_channel_url', 'value' => 'https://www.youtube.com/@SMKN8PANDEGLANG', 'group' => 'social'],
            ['key' => 'youtube_channel_id',  'value' => 'UCtCA4dKgYRDjqqAf5d5d1rg', 'group' => 'social'],
            ['key' => 'youtube_featured_video', 'value' => 'https://www.youtube.com/watch?v=maqRd3EeizQ', 'group' => 'social'],
            ['key' => 'instagram_profile_url', 'value' => 'https://www.instagram.com/smkn8pandeglang_official', 'group' => 'social'],
            ['key' => 'instagram_post_urls', 'value' => '', 'group' => 'social'],

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
            ['key' => 'spmb_graduation_published', 'value' => '0', 'group' => 'ppdb', 'type' => 'bool'],
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
