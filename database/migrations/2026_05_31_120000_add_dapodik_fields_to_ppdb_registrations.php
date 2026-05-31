<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->string('spmb_banten_number', 64)->nullable()->after('registration_number');
            $table->string('form_status', 20)->default('draft')->after('status');
            $table->string('draft_token', 64)->nullable()->unique()->after('form_status');

            $table->string('nik', 20)->nullable()->after('nisn');
            $table->string('birth_cert_number', 40)->nullable()->after('birth_date');
            $table->string('citizenship', 10)->nullable()->after('religion');
            $table->string('country_name', 80)->nullable()->after('citizenship');
            $table->json('special_needs')->nullable()->after('country_name');

            $table->string('rt', 5)->nullable()->after('address');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('hamlet', 80)->nullable()->after('rw');
            $table->string('village', 80)->nullable()->after('hamlet');
            $table->string('district', 80)->nullable()->after('village');
            $table->decimal('latitude', 10, 7)->nullable()->after('postal_code');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');

            $table->string('residence_type', 40)->nullable()->after('longitude');
            $table->string('transport_mode', 40)->nullable()->after('residence_type');

            $table->string('kks_number', 40)->nullable()->after('transport_mode');
            $table->unsignedTinyInteger('child_order')->nullable()->after('kks_number');
            $table->boolean('kps_pkh_receiver')->nullable()->after('child_order');
            $table->string('kps_pkh_number', 40)->nullable()->after('kps_pkh_receiver');
            $table->boolean('pip_eligible')->nullable()->after('kps_pkh_number');
            $table->boolean('kip_receiver')->nullable()->after('pip_eligible');
            $table->string('kip_number', 40)->nullable()->after('kip_receiver');
            $table->string('kip_name')->nullable()->after('kip_number');
            $table->boolean('kip_card_received')->nullable()->after('kip_name');
            $table->string('pip_reason', 80)->nullable()->after('kip_card_received');

            $table->string('bank_name', 80)->nullable()->after('pip_reason');
            $table->string('bank_account_number', 40)->nullable()->after('bank_name');
            $table->string('bank_account_holder')->nullable()->after('bank_account_number');

            $table->string('father_nik', 20)->nullable()->after('father_name');
            $table->unsignedSmallInteger('father_birth_year')->nullable()->after('father_nik');
            $table->string('father_education', 40)->nullable()->after('father_birth_year');
            $table->string('father_income', 40)->nullable()->after('father_job');
            $table->json('father_special_needs')->nullable()->after('father_income');

            $table->string('mother_nik', 20)->nullable()->after('mother_name');
            $table->unsignedSmallInteger('mother_birth_year')->nullable()->after('mother_nik');
            $table->string('mother_education', 40)->nullable()->after('mother_birth_year');
            $table->string('mother_income', 40)->nullable()->after('mother_job');
            $table->json('mother_special_needs')->nullable()->after('mother_income');

            $table->string('guardian_name')->nullable()->after('mother_special_needs');
            $table->string('guardian_nik', 20)->nullable()->after('guardian_name');
            $table->unsignedSmallInteger('guardian_birth_year')->nullable()->after('guardian_nik');
            $table->string('guardian_education', 40)->nullable()->after('guardian_birth_year');
            $table->string('guardian_job')->nullable()->after('guardian_education');
            $table->string('guardian_income', 40)->nullable()->after('guardian_job');

            $table->string('home_phone', 32)->nullable()->after('phone');

            $table->unsignedSmallInteger('height_cm')->nullable()->after('graduation_year');
            $table->unsignedSmallInteger('weight_kg')->nullable()->after('height_cm');
            $table->string('distance_category', 20)->nullable()->after('weight_kg');
            $table->decimal('distance_km', 6, 2)->nullable()->after('distance_category');
            $table->unsignedTinyInteger('travel_hours')->nullable()->after('distance_km');
            $table->unsignedTinyInteger('travel_minutes')->nullable()->after('travel_hours');
            $table->unsignedTinyInteger('siblings_count')->nullable()->after('travel_minutes');

            $table->json('achievements')->nullable()->after('siblings_count');
            $table->json('scholarships')->nullable()->after('achievements');

            $table->string('registration_type', 30)->nullable()->after('pathway');
            $table->string('nis', 20)->nullable()->after('registration_type');
            $table->date('school_entry_date')->nullable()->after('nis');
            $table->string('exam_number', 40)->nullable()->after('school_entry_date');
            $table->string('diploma_serial', 40)->nullable()->after('exam_number');
            $table->string('skhus_serial', 40)->nullable()->after('diploma_serial');
            $table->boolean('data_declaration')->default(false)->after('skhus_serial');
        });

        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropForeign(['major_id']);
        });

        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('major_id')->nullable()->change();
            $table->foreign('major_id')->references('id')->on('majors')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'spmb_banten_number', 'form_status', 'draft_token',
                'nik', 'birth_cert_number', 'citizenship', 'country_name', 'special_needs',
                'rt', 'rw', 'hamlet', 'village', 'district', 'latitude', 'longitude',
                'residence_type', 'transport_mode',
                'kks_number', 'child_order', 'kps_pkh_receiver', 'kps_pkh_number',
                'pip_eligible', 'kip_receiver', 'kip_number', 'kip_name', 'kip_card_received', 'pip_reason',
                'bank_name', 'bank_account_number', 'bank_account_holder',
                'father_nik', 'father_birth_year', 'father_education', 'father_income', 'father_special_needs',
                'mother_nik', 'mother_birth_year', 'mother_education', 'mother_income', 'mother_special_needs',
                'guardian_name', 'guardian_nik', 'guardian_birth_year', 'guardian_education', 'guardian_job', 'guardian_income',
                'home_phone',
                'height_cm', 'weight_kg', 'distance_category', 'distance_km', 'travel_hours', 'travel_minutes', 'siblings_count',
                'achievements', 'scholarships',
                'registration_type', 'nis', 'school_entry_date', 'exam_number', 'diploma_serial', 'skhus_serial', 'data_declaration',
            ]);
        });
    }
};
