<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->string('cover')->nullable()->after('icon');
            $table->longText('content')->nullable()->after('description');
            $table->unsignedInteger('sort_order')->default(0)->after('member_count');
        });
    }

    public function down(): void
    {
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->dropColumn(['cover', 'content', 'sort_order']);
        });
    }
};
