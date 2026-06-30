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
            ['name' => 'Casual Wear',      'image' => 'https://images.unsplash.com/photo-1556821840-3a63f15732ce?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Bridal Collection','image' => 'https://images.unsplash.com/photo-1519657742521-4d683b746af9?w=700&q=80&auto=format&fit=crop'],
            ['name' => 'Sports & Active',  'image' => 'https://images.unsplash.com/photo-1571731877695-6e95d2a5c3ef?w=700&q=80&auto=format&fit=crop'],
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
            ['Shirts',        $parentIds["Men's Wear"]],
            ['Trousers',      $parentIds["Men's Wear"]],
            ['Suits',         $parentIds["Men's Wear"]],
            ['Kurta Shalwar', $parentIds["Men's Wear"]],
            ['Jackets',       $parentIds["Men's Wear"]],

            // Women's Wear
            ['Shalwar Kameez',  $parentIds["Women's Wear"]],
            ['Sarees',          $parentIds["Women's Wear"]],
            ['Lehengas',        $parentIds["Women's Wear"]],
            ['Tops & Blouses',  $parentIds["Women's Wear"]],
            ['Abayas',          $parentIds["Women's Wear"]],

            // Kids Wear
            ['Boys Clothing',   $parentIds['Kids Wear']],
            ['Girls Clothing',  $parentIds['Kids Wear']],
            ['Baby Clothing',   $parentIds['Kids Wear']],

            // Formal Wear
            ['Wedding Suits',   $parentIds['Formal Wear']],
            ['Office Wear',     $parentIds['Formal Wear']],
            ['Tuxedos',         $parentIds['Formal Wear']],

            // Casual Wear
            ['Jeans',           $parentIds['Casual Wear']],
            ['T-Shirts',        $parentIds['Casual Wear']],
            ['Hoodies',         $parentIds['Casual Wear']],
            ['Shorts',          $parentIds['Casual Wear']],

            // Bridal Collection
            ['Bridal Lehenga',  $parentIds['Bridal Collection']],
            ['Mehndi Dresses',  $parentIds['Bridal Collection']],
            ['Bridal Gowns',    $parentIds['Bridal Collection']],

            // Sports & Active
            ['Tracksuits',      $parentIds['Sports & Active']],
            ['Sports Shorts',   $parentIds['Sports & Active']],
            ['Gym Wear',        $parentIds['Sports & Active']],

            // Winter Collection
            ['Sweaters',        $parentIds['Winter Collection']],
            ['Coats',           $parentIds['Winter Collection']],
            ['Shawls',          $parentIds['Winter Collection']],
            ['Sweatshirts',     $parentIds['Winter Collection']],
        ];

        foreach ($children as [$name, $parentId]) {
            DB::table('categories')->insertOrIgnore([
                'category_name'      => $name,
                'category_slug'      => Str::slug($name),
                'category_image'     => 'default-category.png',
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
