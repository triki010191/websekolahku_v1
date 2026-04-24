<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 32)->unique();
            $table->foreignId('major_id')->constrained()->restrictOnDelete();

            // Personal data
            $table->string('full_name');
            $table->string('nisn', 20);
            $table->enum('gender', ['L', 'P']);
            $table->string('religion', 30)->nullable();
            $table->string('birth_place', 80)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 80)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('previous_school')->nullable();
            $table->year('graduation_year')->nullable();

            // Parent data
            $table->string('father_name')->nullable();
            $table->string('father_job')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('parent_phone', 32)->nullable();
            $table->string('parent_income')->nullable();

            // Admission pathway
            $table->enum('pathway', ['zonasi', 'prestasi', 'afirmasi', 'mutasi'])->default('zonasi');

            // Documents
            $table->string('doc_ijazah')->nullable();
            $table->string('doc_kk')->nullable();
            $table->string('doc_photo')->nullable();
            $table->string('doc_akta')->nullable();

            // Status
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('nisn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
