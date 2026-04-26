<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const NEW_URL = 'https://spmb.bantenprov.go.id/';

    /** @var list<string> */
    private const LEGACY_PPG = [
        'https://ppdb.bantenprov.go.id/',
        'https://ppdb.bantenprov.go.id',
    ];

    public function up(): void
    {
        $row = Setting::query()->where('key', 'spmb_banten_url')->first();
        if ($row && in_array($row->value, self::LEGACY_PPG, true)) {
            $row->value = self::NEW_URL;
            $row->save();
        }
    }

    public function down(): void
    {
        $row = Setting::query()->where('key', 'spmb_banten_url')->where('value', self::NEW_URL)->first();
        if ($row) {
            $row->value = 'https://ppdb.bantenprov.go.id/';
            $row->save();
        }
    }
};
