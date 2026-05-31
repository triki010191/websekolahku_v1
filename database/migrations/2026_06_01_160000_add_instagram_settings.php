<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            [
                'key' => 'instagram_profile_url',
                'value' => 'https://www.instagram.com/smkn8pandeglang_official',
                'group' => 'social',
                'type' => 'text',
            ],
            [
                'key' => 'instagram_post_urls',
                'value' => '',
                'group' => 'social',
                'type' => 'text',
            ],
        ];

        foreach ($rows as $row) {
            Setting::query()->firstOrCreate(
                ['key' => $row['key']],
                ['value' => $row['value'], 'group' => $row['group'], 'type' => $row['type']]
            );
        }
    }

    public function down(): void
    {
        Setting::query()->whereIn('key', ['instagram_profile_url', 'instagram_post_urls'])->delete();
    }
};
