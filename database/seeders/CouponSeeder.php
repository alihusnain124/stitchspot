<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Seed some sample discount coupons.
     */
    public function run(): void
    {
        $coupons = [
            [
                'title'         => 'Welcome Discount',
                'code'          => 'WELCOME10',
                'value'         => '10',
                'min_order_amt' => '500',
                'is_one_time'   => 1,
            ],
            [
                'title'         => 'Summer Sale',
                'code'          => 'SUMMER20',
                'value'         => '20',
                'min_order_amt' => '1000',
                'is_one_time'   => 0,
            ],
            [
                'title'         => 'Flat 15% Off',
                'code'          => 'FLAT15',
                'value'         => '15',
                'min_order_amt' => '750',
                'is_one_time'   => 0,
            ],
            [
                'title'         => 'VIP Member',
                'code'          => 'VIP25',
                'value'         => '25',
                'min_order_amt' => '2000',
                'is_one_time'   => 1,
            ],
            [
                'title'         => 'Eid Special',
                'code'          => 'EID30',
                'value'         => '30',
                'min_order_amt' => '1500',
                'is_one_time'   => 0,
            ],
        ];

        foreach ($coupons as $coupon) {
            DB::table('coupons')->insertOrIgnore(array_merge($coupon, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Coupons seeded.');
    }
}
