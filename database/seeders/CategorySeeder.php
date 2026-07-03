<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed parent and child categories used in a fashion/stitching store.
     */
    public function run(): void
    {
        // ── Parent categories (parent_category_id = 0) ───────────────────────
        $parents = [
            ['name' => 'Men\'s Wear',      'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Women\'s Wear',    'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Kids Wear',        'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Formal Wear',      'image' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Casual Wear',      'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Bridal Collection','image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Sports & Active',  'image' => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Winter Collection','image' => 'https://images.unsplash.com/photo-1548126032-079a0fb0099d?w=700&q=80&auto=format&fit=crop'],
        ];

        foreach ($parents as $parent) {
            DB::table('categories')->insertOrIgnore([
                'category_name'     => $parent['name'],
                'category_slug'     => Str::slug($parent['name']),
                'category_image'    => $parent['image'],
                'parent_category_id'=> 0,
                'is_home'           => 1,
                'status'            => 1,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // ── Fetch inserted parent IDs ─────────────────────────────────────────
        $parentIds = DB::table('categories')
            ->where('parent_category_id', 0)
            ->pluck('id', 'category_name');

        // ── Sub-categories ────────────────────────────────────────────────────
        $children = [
            // Men's Wear
            ['Shirts',        $parentIds["Men's Wear"], '1602810318383-e386cc2a3ccf'],
            ['Trousers',      $parentIds["Men's Wear"], '1624378439575-d8705ad7ae80'],
            ['Suits',         $parentIds["Men's Wear"], '1507679799987-c73779587ccf'],
            ['Kurta Shalwar', $parentIds["Men's Wear"], '1612336307429-8a898d10e223'],
            ['Jackets',       $parentIds["Men's Wear"], '1551028719-00167b16eac5'],

            // Women's Wear
            ['Shalwar Kameez',  $parentIds["Women's Wear"], '1612336307429-8a898d10e223'],
            ['Sarees',          $parentIds["Women's Wear"], '1517841905240-472988babdf9'],
            ['Lehengas',        $parentIds["Women's Wear"], '1517841905240-472988babdf9'],
            ['Tops & Blouses',  $parentIds["Women's Wear"], '1490481651871-ab68de25d43d'],
            ['Abayas',          $parentIds["Women's Wear"], '1612336307429-8a898d10e223'],

            // Kids Wear
            ['Boys Clothing',   $parentIds['Kids Wear'], '1603126857149-08ea5c9b44e8'],
            ['Girls Clothing',  $parentIds['Kids Wear'], '1519238263530-99bdd11df2ea'],
            ['Baby Clothing',   $parentIds['Kids Wear'], '1519238263530-99bdd11df2ea'],

            // Formal Wear
            ['Wedding Suits',   $parentIds['Formal Wear'], '1517841905240-472988babdf9'],
            ['Office Wear',     $parentIds['Formal Wear'], '1602810318383-e386cc2a3ccf'],
            ['Tuxedos',         $parentIds['Formal Wear'], '1507679799987-c73779587ccf'],

            // Casual Wear
            ['Jeans',           $parentIds['Casual Wear'], '1542272604-787c3835535d'],
            ['T-Shirts',        $parentIds['Casual Wear'], '1576566588028-4147f3842f27'],
            ['Hoodies',         $parentIds['Casual Wear'], '1551028719-00167b16eac5'],
            ['Shorts',          $parentIds['Casual Wear'], '1506629082955-511b1aa562c8'],

            // Bridal Collection
            ['Bridal Lehenga',  $parentIds['Bridal Collection'], '1517841905240-472988babdf9'],
            ['Mehndi Dresses',  $parentIds['Bridal Collection'], '1612336307429-8a898d10e223'],
            ['Bridal Gowns',    $parentIds['Bridal Collection'], '1517841905240-472988babdf9'],

            // Sports & Active
            ['Tracksuits',      $parentIds['Sports & Active'], '1506629082955-511b1aa562c8'],
            ['Sports Shorts',   $parentIds['Sports & Active'], '1506629082955-511b1aa562c8'],
            ['Gym Wear',        $parentIds['Sports & Active'], '1506629082955-511b1aa562c8'],

            // Winter Collection
            ['Sweaters',        $parentIds['Winter Collection'], '1608234808654-2a8875faa7fd'],
            ['Coats',           $parentIds['Winter Collection'], '1548126032-079a0fb0099d'],
            ['Shawls',          $parentIds['Winter Collection'], '1614786269829-d24616faf56d'],
            ['Sweatshirts',     $parentIds['Winter Collection'], '1608234808654-2a8875faa7fd'],
        ];

        foreach ($children as $i => [$name, $parentId, $photoId]) {
            DB::table('categories')->insertOrIgnore([
                'category_name'      => $name,
                'category_slug'      => Str::slug($name),
                'category_image'     => "https://images.unsplash.com/photo-{$photoId}?w=700&q=80&auto=format&fit=crop&sig={$i}",
                'parent_category_id' => $parentId,
                'is_home'            => rand(0, 1),
                'status'             => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        $this->command->info('✅ Categories seeded (8 parent + sub-categories).');
    }
}
