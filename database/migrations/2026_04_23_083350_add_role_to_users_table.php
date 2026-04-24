<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin_berita', 'admin_alumni', 'alumni'])
                ->default('alumni')->after('email');
            $table->string('phone', 32)->nullable()->after('role');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active')->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'avatar', 'status']);
        });
    }
};
