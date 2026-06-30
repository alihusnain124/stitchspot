<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder
{
    /**
     * Seed common tax slabs.
     */
    public function run(): void
    {
        $taxes = [
            ['tax_desc' => 'No Tax (0%)',        'tax_value' => 0,  'status' => 1],
            ['tax_desc' => 'Standard GST (5%)',   'tax_value' => 5,  'status' => 1],
            ['tax_desc' => 'Reduced Rate (10%)',  'tax_value' => 10, 'status' => 1],
            ['tax_desc' => 'Standard Rate (17%)', 'tax_value' => 17, 'status' => 1],
            ['tax_desc' => 'Premium Rate (20%)',  'tax_value' => 20, 'status' => 0],
        ];

        foreach ($taxes as $tax) {
            DB::table('taxes')->insertOrIgnore(array_merge($tax, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Taxes seeded.');
    }
}
