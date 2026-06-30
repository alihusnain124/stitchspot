<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Seed 100 colours into the colors table.
     */
    public function run(): void
    {
        $colors = [
            'Red', 'Crimson', 'Scarlet', 'Ruby', 'Maroon',
            'Rose', 'Coral', 'Salmon', 'Pink', 'Hot Pink',
            'Orange', 'Amber', 'Peach', 'Apricot', 'Tangerine',
            'Yellow', 'Gold', 'Lemon', 'Khaki', 'Cream',
            'Green', 'Olive', 'Lime', 'Mint', 'Sage',
            'Emerald', 'Forest Green', 'Teal', 'Turquoise', 'Aqua',
            'Cyan', 'Sky Blue', 'Baby Blue', 'Powder Blue', 'Cerulean',
            'Blue', 'Royal Blue', 'Navy', 'Cobalt', 'Indigo',
            'Periwinkle', 'Cornflower Blue', 'Slate Blue', 'Steel Blue', 'Denim',
            'Violet', 'Purple', 'Lavender', 'Plum', 'Mauve',
            'Lilac', 'Orchid', 'Fuchsia', 'Magenta', 'Raspberry',
            'Brown', 'Chocolate', 'Caramel', 'Tan', 'Beige',
            'Sand', 'Taupe', 'Sienna', 'Rust', 'Copper',
            'Black', 'Charcoal', 'Graphite', 'Onyx', 'Jet Black',
            'White', 'Off-White', 'Ivory', 'Pearl', 'Snow',
            'Gray', 'Light Gray', 'Silver', 'Ash', 'Smoke',
            'Champagne', 'Nude', 'Blush', 'Dusty Rose', 'Old Rose',
            'Mustard', 'Burnt Orange', 'Brick Red', 'Burgundy', 'Wine',
            'Jade', 'Sea Green', 'Pistachio', 'Moss', 'Pine Green',
            'Electric Blue', 'Neon Green', 'Hot Orange', 'Neon Pink', 'Bright Yellow',
        ];

        $rows = array_map(function ($color) {
            return [
                'color'      => $color,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $colors);

        DB::table('colors')->insertOrIgnore($rows);

        $this->command->info('✅ 100 colors seeded.');
    }
}
