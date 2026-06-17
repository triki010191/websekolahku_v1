<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE ppdb_registrations MODIFY status ENUM('pending', 'revisi', 'valid', 'accepted', 'rejected') NOT NULL DEFAULT 'pending'"
            );
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::table('ppdb_registrations')
                ->where('status', 'valid')
                ->update(['status' => 'pending']);

            DB::statement(
                "ALTER TABLE ppdb_registrations MODIFY status ENUM('pending', 'revisi', 'accepted', 'rejected') NOT NULL DEFAULT 'pending'"
            );
        }
    }
};
