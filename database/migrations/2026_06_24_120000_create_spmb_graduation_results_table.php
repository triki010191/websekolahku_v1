<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spmb_graduation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('registration_number', 50)->nullable();
            $table->string('nisn', 10);
            $table->string('full_name');
            $table->char('gender', 1);
            $table->string('origin_school')->nullable();
            $table->string('accepted_major');
            $table->string('academic_year', 20)->default('2026/2027');
            $table->timestamps();

            $table->unique('nisn');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmb_graduation_results');
    }
};
