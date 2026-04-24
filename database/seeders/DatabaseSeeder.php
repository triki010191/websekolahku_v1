<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            BannerSeeder::class,
            PageSeeder::class,
            MajorSeeder::class,
            TeacherSeeder::class,
            FacilitySeeder::class,
            ExtracurricularSeeder::class,
            EventSeeder::class,
            AchievementSeeder::class,
            PartnerSeeder::class,
            PostSeeder::class,
            AnnouncementSeeder::class,
            GallerySeeder::class,
            PpdbSeeder::class,
            DownloadSeeder::class,
            FaqSeeder::class,
            AlumniSeeder::class,
        ]);
    }
}
