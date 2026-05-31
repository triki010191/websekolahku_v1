<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => 'google_maps_url'],
            [
                'value' => 'https://www.google.com/maps/place/SMKN+8+Pandeglang/@-6.3127483,105.9983479,17z/data=!4m14!1m7!3m6!1s0x2e42253a4c8313ab:0xe7feefa55f6c6cd1!2sSMKN+8+Pandeglang!8m2!3d-6.3127483!4d106.0009228!16s%2Fg%2F1q5bl88qp!3m5!1s0x2e42253a4c8313ab:0xe7feefa55f6c6cd1!8m2!3d-6.3127483!4d106.0009228!16s%2Fg%2F1q5bl88qp?entry=ttu',
                'group' => 'contact',
                'type' => 'text',
            ]
        );

        Setting::query()->where('key', 'contact_latitude')->update(['value' => '-6.3127483']);
        Setting::query()->where('key', 'contact_longitude')->update(['value' => '106.0009228']);
    }

    public function down(): void
    {
        Setting::query()->where('key', 'google_maps_url')->delete();
    }
};
