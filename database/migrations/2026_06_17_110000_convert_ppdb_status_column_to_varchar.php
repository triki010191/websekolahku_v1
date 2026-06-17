<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // VARCHAR mencegah error "Data truncated" di hosting saat menambah status baru di aplikasi.
        DB::statement(
            "ALTER TABLE ppdb_registrations MODIFY status VARCHAR(20) NOT NULL DEFAULT 'pending'"
        );
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement(
            "ALTER TABLE ppdb_registrations MODIFY status ENUM('pending', 'revisi', 'valid', 'accepted', 'rejected') NOT NULL DEFAULT 'pending'"
        );
    }
};
