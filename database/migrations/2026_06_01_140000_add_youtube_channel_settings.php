<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            ['key' => 'youtube_channel_url', 'value' => 'https://www.youtube.com/@SMKN8PANDEGLANG', 'group' => 'social', 'type' => 'text'],
            ['key' => 'youtube_channel_id', 'value' => 'UCtCA4dKgYRDjqqAf5d5d1rg', 'group' => 'social', 'type' => 'text'],
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
        Setting::query()->whereIn('key', ['youtube_channel_url', 'youtube_channel_id'])->delete();
    }
};
