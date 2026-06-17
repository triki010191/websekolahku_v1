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

        if ($this->statusEnumIncludes('valid')) {
            return;
        }

        DB::statement(
            "ALTER TABLE ppdb_registrations MODIFY status ENUM('pending', 'revisi', 'valid', 'accepted', 'rejected') NOT NULL DEFAULT 'pending'"
        );
    }

    private function statusEnumIncludes(string $value): bool
    {
        $column = DB::selectOne("SHOW COLUMNS FROM ppdb_registrations WHERE Field = 'status'");

        if (! $column || ! isset($column->Type)) {
            return false;
        }

        return str_contains((string) $column->Type, "'{$value}'");
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
