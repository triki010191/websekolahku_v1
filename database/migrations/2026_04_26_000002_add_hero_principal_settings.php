<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            ['key' => 'hero_principal_image', 'value' => '', 'group' => 'identity', 'type' => 'image', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_principal_caption', 'value' => 'Kepala Sekolah', 'group' => 'identity', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
        ];
        foreach ($rows as $row) {
            $exists = DB::table('settings')->where('key', $row['key'])->exists();
            if (! $exists) {
                DB::table('settings')->insert($row);
            }
        }
        Cache::forget('settings.all');
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['hero_principal_image', 'hero_principal_caption'])->delete();
    }
};
