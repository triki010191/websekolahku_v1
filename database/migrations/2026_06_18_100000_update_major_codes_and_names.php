<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $updates = [
            'AKL' => ['code' => 'AK', 'name' => 'Akuntansi', 'slug' => 'ak'],
            'TBSM' => ['code' => 'TSM', 'name' => 'Teknik Sepeda Motor', 'slug' => 'tsm'],
            'DKV' => ['name' => 'Disain Komunikasi Visual'],
            'RPL' => ['name' => 'Rekayasa Perangkat Lunak'],
            'TITL' => ['name' => 'Teknik Instalasi Tenaga Listrik'],
        ];

        foreach ($updates as $oldCode => $data) {
            DB::table('majors')->where('code', $oldCode)->update($data);
        }
    }

    public function down(): void
    {
        $reverts = [
            'AK' => ['code' => 'AKL', 'name' => 'Akuntansi & Keuangan Lembaga', 'slug' => 'akl'],
            'TSM' => ['code' => 'TBSM', 'name' => 'Teknik & Bisnis Sepeda Motor', 'slug' => 'tbsm'],
            'DKV' => ['name' => 'Desain Komunikasi Visual'],
        ];

        foreach ($reverts as $code => $data) {
            DB::table('majors')->where('code', $code)->update($data);
        }
    }
};
