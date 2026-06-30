<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters — Products depend on Brands, Categories, Colors & Sizes.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,     // 1. Admin user first
            BrandSeeder::class,     // 2. 100 Brands
            ColorSeeder::class,     // 3. 100 Colors
            SizeSeeder::class,      // 4. Sizes
            TaxSeeder::class,       // 5. Tax slabs
            CouponSeeder::class,    // 6. Discount coupons
            CategorySeeder::class,  // 7. Categories (parent + sub)
            ProductSeeder::class,   // 8. 100 Products with variants (needs above)
        ]);
    }
}
