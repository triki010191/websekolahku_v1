<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => 'youtube_featured_video'],
            [
                'value' => 'https://www.youtube.com/watch?v=maqRd3EeizQ',
                'group' => 'social',
                'type' => 'text',
            ]
        );
    }

    public function down(): void
    {
        Setting::query()->where('key', 'youtube_featured_video')->delete();
    }
};
