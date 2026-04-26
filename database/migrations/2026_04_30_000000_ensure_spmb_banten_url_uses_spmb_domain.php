<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const OFFICIAL = 'https://spmb.bantenprov.go.id/';

    public function up(): void
    {
        $row = Setting::query()->where('key', 'spmb_banten_url')->first();
        if (! $row) {
            Setting::set('spmb_banten_url', self::OFFICIAL, 'ppdb', 'text');

            return;
        }

        $v = (string) $row->value;
        if ($v === '' || str_contains(strtolower($v), 'ppdb.bantenprov')) {
            $row->value = self::OFFICIAL;
            $row->save();
        }
    }

    public function down(): void
    {
        // Jangan ubah kembali ke ppdb; biarkan data pengguna
    }
};
