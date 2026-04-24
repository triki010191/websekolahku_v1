<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->longText('curriculum')->nullable();
            $table->longText('career_prospects')->nullable();
            $table->longText('certifications')->nullable();
            $table->string('head_teacher')->nullable();
            $table->string('cover')->nullable();
            $table->string('color', 20)->default('primary');
            $table->unsignedInteger('student_count')->default(0);
            $table->unsignedInteger('quota')->default(72);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
