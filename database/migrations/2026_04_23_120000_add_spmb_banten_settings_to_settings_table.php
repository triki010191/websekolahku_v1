<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::updateOrCreate(
            ['key' => 'spmb_banten_url'],
            [
                'value' => 'https://spmb.bantenprov.go.id/',
                'group' => 'ppdb',
                'type'  => 'text',
            ]
        );
        Setting::updateOrCreate(
            ['key' => 'spmb_banten_logo'],
            [
                'value' => '',
                'group' => 'ppdb',
                'type'  => 'image',
            ]
        );
    }

    public function down(): void
    {
        Setting::query()->whereIn('key', ['spmb_banten_url', 'spmb_banten_logo'])->delete();
    }
};
