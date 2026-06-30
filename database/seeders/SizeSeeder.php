<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Seed common clothing sizes.
     */
    public function run(): void
    {
        $sizes = [
            'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL',
            '28', '30', '32', '34', '36', '38', '40', '42', '44',
            '6', '8', '10', '12', '14', '16', '18',
            'Free Size', 'Custom',
        ];

        $rows = array_map(fn ($size) => [
            'size'       => $size,
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ], $sizes);

        DB::table('sizes')->insertOrIgnore($rows);

        $this->command->info('✅ Sizes seeded.');
    }
}
