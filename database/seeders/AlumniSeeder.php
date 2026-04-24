<?php

namespace Database\Seeders;

use App\Models\AlumniJob;
use App\Models\AlumniProfile;
use App\Models\Major;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $dwi   = User::where('email', 'dwi.hendriko@alumni.sch.id')->first();
        $nurul = User::where('email', 'nurul.s@alumni.sch.id')->first();

        if ($dwi) {
            AlumniProfile::updateOrCreate(
                ['user_id' => $dwi->id],
                [
                    'major_id'              => Major::where('code', 'RPL')->value('id'),
                    'graduation_year'       => 2021,
                    'current_status'        => 'bekerja',
                    'company_or_university' => 'PT Gojek Indonesia',
                    'position_or_major'     => 'Software Engineer',
                    'city'                  => 'Jakarta',
                    'bio'                   => 'Alumni angkatan 2021 yang kini berkarier sebagai Software Engineer di Gojek.',
                    'verification'          => 'verified',
                ]
            );
        }

        if ($nurul) {
            AlumniProfile::updateOrCreate(
                ['user_id' => $nurul->id],
                [
                    'major_id'              => Major::where('code', 'AKL')->value('id'),
                    'graduation_year'       => 2022,
                    'current_status'        => 'kuliah',
                    'company_or_university' => 'Universitas Indonesia',
                    'position_or_major'     => 'Akuntansi',
                    'city'                  => 'Depok',
                    'bio'                   => 'Alumni AKL 2022, kini melanjutkan S1 Akuntansi di UI.',
                    'verification'          => 'verified',
                ]
            );
        }

        if ($dwi) {
            AlumniJob::updateOrCreate(
                ['title' => 'Junior Frontend Developer', 'user_id' => $dwi->id],
                [
                    'company'       => 'PT Tokopedia',
                    'location'      => 'Jakarta Selatan',
                    'type'          => 'fulltime',
                    'salary_range'  => 'Rp6–9 juta',
                    'description'   => 'Dibutuhkan Junior Frontend Developer untuk tim produk. Fresh graduate dipersilakan.',
                    'requirements'  => 'Memahami HTML/CSS/JS, familiar React, bersedia WFO di Jakarta Selatan.',
                    'contact_email' => 'hr@tokopedia.com',
                    'closes_at'     => now()->addDays(30),
                    'status'        => 'active',
                ]
            );
        }
    }
}
