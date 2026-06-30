<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed one admin user into the admins table.
     */
    public function run(): void
    {
        DB::table('admins')->insertOrIgnore([
            [
                'email'      => 'admin@stitchspot.com',
                'password'   => Hash::make('Admin@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Admin user seeded  →  admin@stitchspot.com  /  Admin@123');
    }
}
