<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('settings')->where('key', 'sambutan_section_image')->exists()) {
            DB::table('settings')->insert([
                'key' => 'sambutan_section_image',
                'value' => '',
                'group' => 'identity',
                'type' => 'image',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Cache::forget('settings.all');
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'sambutan_section_image')->delete();
        Cache::forget('settings.all');
    }
};
