<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Administrator',   'email' => 'admin@smkn8pandeglang.sch.id',  'role' => User::ROLE_SUPER_ADMIN],
            ['name' => 'Siti Aminah',     'email' => 'berita@smkn8pandeglang.sch.id', 'role' => User::ROLE_ADMIN_BERITA],
            ['name' => 'Ahmad Sulaiman',  'email' => 'alumni@smkn8pandeglang.sch.id', 'role' => User::ROLE_ADMIN_ALUMNI],
            ['name' => 'Dwi Hendriko',    'email' => 'dwi.hendriko@alumni.sch.id',    'role' => User::ROLE_ALUMNI],
            ['name' => 'Nurul Safitri',   'email' => 'nurul.s@alumni.sch.id',         'role' => User::ROLE_ALUMNI],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'              => $u['name'],
                    'password'          => Hash::make('password'),
                    'role'              => $u['role'],
                    'status'            => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
