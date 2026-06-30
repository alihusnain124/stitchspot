<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $brandIds    = DB::table('brands')->pluck('id')->toArray();
        $colorIds    = DB::table('colors')->pluck('id')->toArray();
        $sizeIds     = DB::table('sizes')->pluck('id')->toArray();

        if (empty($categoryIds) || empty($brandIds)) {
            $this->command->warn('No categories or brands found. Run CategorySeeder and BrandSeeder first.');
            return;
        }

        // Each entry: [name, unsplash_photo_id, keyword_hint]
        $products = [
            ['Classic Oxford Shirt',       '1602810318383-e386cc2a3ccf', 'shirt'],
            ['Slim Fit Chinos',            '1624378439575-d8705ad7ae80', 'chinos'],
            ['Formal Suit Set',            '1507679799987-c73779587ccf', 'suit'],
            ['Kurta Shalwar Combo',        '1583391099995-7f21a3506a33', 'kurta'],
            ['Denim Jacket',               '1551028719-00167b16eac5', 'denim jacket'],
            ['Embroidered Lawn Dress',     '1612336307429-8a898d10e223', 'lawn dress'],
            ['Silk Shalwar Kameez',        '1583391099995-7f21a3506a33', 'silk dress'],
            ['Bridal Lehenga Choli',       '1519657742521-4d683b746af9', 'bridal'],
            ['Sports Tracksuit',           '1571731877695-6e95d2a5c3ef', 'tracksuit'],
            ['Hoodie Sweatshirt',          '1556821840-3a63f15732ce', 'hoodie'],
            ['Cargo Pants',                '1624378440280-ede5f8c4cbad', 'cargo pants'],
            ['Polo Shirt',                 '1521572163474-6864f9cf17ab', 'polo shirt'],
            ['Printed T-Shirt',            '1576566588028-4147f3842f27', 'tshirt'],
            ['Linen Trousers',             '1473966968600-fa4ccd318cd1', 'trousers'],
            ['Wedding Sherwani',           '1583391099995-7f21a3506a33', 'sherwani'],
            ['Peplum Top',                 '1490481651871-ab68de25d43d', 'top fashion'],
            ['Palazzo Pants',              '1515886657613-9f3515b0c78f', 'palazzo'],
            ['Cold Shoulder Dress',        '1539109136881-3be0616acf4b', 'dress'],
            ['Wrap Dress',                 '1496747611176-843222e1e57c', 'wrap dress'],
            ['Midi Skirt',                 '1572635196237-14b3f281503f', 'skirt'],
            ['Floral Maxi Dress',          '1558618666-fcd25c85cd64', 'floral dress'],
            ['Off-Shoulder Top',           '1622719408785-4b5e5e5e5e5e', 'off shoulder top'],
            ['Jumpsuit',                   '1515372392018-e5b63f5d0ab5', 'jumpsuit'],
            ['Romper',                     '1485230895905-ec40ba36b9bc', 'romper'],
            ['Blazer Coat',                '1598300042247-d088f8ab3a91', 'blazer'],
            ['Peacoat',                    '1548126032-079a0fb0099d', 'peacoat'],
            ['Trench Coat',                '1539109136881-3be0616acf4b', 'trench coat'],
            ['Wool Sweater',               '1434389677669-e08b4cec1105', 'sweater'],
            ['Knit Cardigan',              '1511511934814-5f4dd56a4b3e', 'cardigan'],
            ['Turtleneck Pullover',        '1608234808654-2a8875faa7fd', 'turtleneck'],
            ['Fleece Jacket',              '1543076447-215ad9ba6923', 'fleece jacket'],
            ['Windbreaker',                '1542291026-7eec264c27ff', 'windbreaker'],
            ['Athletic Shorts',            '1571731877695-6e95d2a5c3ef', 'athletic shorts'],
            ['Yoga Pants',                 '1506629082955-511b1aa562c8', 'yoga pants'],
            ['Compression Tights',         '1506629082955-511b1aa562c8', 'tights'],
            ['Tank Top',                   '1554568218-0f1715e72254', 'tank top'],
            ['Sports Bra',                 '1571731877695-6e95d2a5c3ef', 'sports bra'],
            ['Running Jacket',             '1542291026-7eec264c27ff', 'running jacket'],
            ['Gym Vest',                   '1571731877695-6e95d2a5c3ef', 'gym vest'],
            ['Cricket Whites',             '1521572163474-6864f9cf17ab', 'cricket whites'],
            ['Boys School Uniform',        '1603126857149-08ea5c9b44e8', 'school uniform'],
            ['Girls Frock',                '1519238263530-99bdd11df2ea', 'girls dress'],
            ['Baby Romper',                '1519238263530-99bdd11df2ea', 'baby clothes'],
            ['Kids Kurta',                 '1603126857149-08ea5c9b44e8', 'kids kurta'],
            ['Toddler Jeans',              '1603126857149-08ea5c9b44e8', 'toddler jeans'],
            ['Children\'s Hoodie',         '1556821840-3a63f15732ce', 'kids hoodie'],
            ['Girls Lehenga',              '1519657742521-4d683b746af9', 'girls lehenga'],
            ['Boys Sherwani',              '1603126857149-08ea5c9b44e8', 'boys sherwani'],
            ['Newborn Set',                '1519238263530-99bdd11df2ea', 'newborn clothes'],
            ['Kids Track Pants',           '1603126857149-08ea5c9b44e8', 'kids track pants'],
            ['Abayas',                     '1583391099995-7f21a3506a33', 'abaya'],
            ['Hijab Scarf',                '1614786269829-d24616faf56d', 'hijab scarf'],
            ['Kaftan Dress',               '1515886657613-9f3515b0c78f', 'kaftan'],
            ['Jalabiya',                   '1583391099995-7f21a3506a33', 'jalabiya'],
            ['Printed Lawn Suit',          '1612336307429-8a898d10e223', 'lawn suit'],
            ['Chiffon Dupatta',            '1614786269829-d24616faf56d', 'chiffon scarf'],
            ['Net Embroidered Dupatta',    '1614786269829-d24616faf56d', 'dupatta'],
            ['Raw Silk Suit',              '1583391099995-7f21a3506a33', 'silk suit'],
            ['Velvet Shawl',               '1614786269829-d24616faf56d', 'velvet shawl'],
            ['Pashmina Wrap',              '1614786269829-d24616faf56d', 'pashmina'],
            ['Formal Trousers',            '1473966968600-fa4ccd318cd1', 'formal trousers'],
            ['Business Shirt',             '1602810318383-e386cc2a3ccf', 'business shirt'],
            ['Waistcoat',                  '1507679799987-c73779587ccf', 'waistcoat'],
            ['Double Breasted Blazer',     '1598300042247-d088f8ab3a91', 'double breasted blazer'],
            ['Nehru Jacket',               '1507679799987-c73779587ccf', 'nehru jacket'],
            ['Mandarin Collar Shirt',      '1602810318383-e386cc2a3ccf', 'mandarin collar'],
            ['Linen Kurta',                '1583391099995-7f21a3506a33', 'linen kurta'],
            ['Pathani Suit',               '1583391099995-7f21a3506a33', 'pathani suit'],
            ['Shalwar Kameez Set',         '1583391099995-7f21a3506a33', 'shalwar kameez'],
            ['Dhoti Kurta',                '1583391099995-7f21a3506a33', 'dhoti kurta'],
            ['Indo-Western Outfit',        '1507679799987-c73779587ccf', 'indo western'],
            ['Anarkali Suit',              '1612336307429-8a898d10e223', 'anarkali'],
            ['Churidar Set',               '1612336307429-8a898d10e223', 'churidar'],
            ['Sharara Set',                '1612336307429-8a898d10e223', 'sharara'],
            ['Gharara Set',                '1519657742521-4d683b746af9', 'gharara'],
            ['Designer Saree Blouse',      '1519657742521-4d683b746af9', 'saree blouse'],
            ['Pre-stitched Saree',         '1519657742521-4d683b746af9', 'saree'],
            ['Net Saree',                  '1519657742521-4d683b746af9', 'net saree'],
            ['Banarasi Silk Saree',        '1519657742521-4d683b746af9', 'banarasi saree'],
            ['Zari Work Lehenga',          '1519657742521-4d683b746af9', 'lehenga'],
            ['Mirror Work Blouse',         '1519657742521-4d683b746af9', 'mirror work'],
            ['Block Print Kurti',          '1612336307429-8a898d10e223', 'kurti'],
            ['Tie-Dye Dress',              '1558618666-fcd25c85cd64', 'tie dye dress'],
            ['Batik Print Top',            '1490481651871-ab68de25d43d', 'batik top'],
            ['Sequin Evening Gown',        '1517841905240-472988babdf9', 'evening gown'],
            ['Cocktail Dress',             '1517841905240-472988babdf9', 'cocktail dress'],
            ['Party Wear Suit',            '1517841905240-472988babdf9', 'party wear'],
            ['Reception Gown',             '1517841905240-472988babdf9', 'reception gown'],
            ['Nikah Dress',                '1519657742521-4d683b746af9', 'bridal dress'],
            ['Valima Outfit',              '1519657742521-4d683b746af9', 'valima outfit'],
            ['Mehndi Lehnga',              '1519657742521-4d683b746af9', 'mehndi dress'],
            ['Barat Dress',                '1519657742521-4d683b746af9', 'barat dress'],
            ['Puffer Jacket',              '1542291026-7eec264c27ff', 'puffer jacket'],
            ['Sherpa Hoodie',              '1556821840-3a63f15732ce', 'sherpa hoodie'],
            ['Thermal Inner Suit',         '1521572163474-6864f9cf17ab', 'thermal suit'],
            ['Cable Knit Sweater',         '1434389677669-e08b4cec1105', 'cable knit sweater'],
            ['Quilted Vest',               '1542291026-7eec264c27ff', 'quilted vest'],
            ['Shearling Coat',             '1548126032-079a0fb0099d', 'shearling coat'],
            ['Flannel Shirt',              '1602810318383-e386cc2a3ccf', 'flannel shirt'],
            ['Corduroy Jacket',            '1551028719-00167b16eac5', 'corduroy jacket'],
            ['Satin Slip Dress',           '1517841905240-472988babdf9', 'satin slip dress'],
            ['Velvet Blazer',              '1598300042247-d088f8ab3a91', 'velvet blazer'],
        ];

        foreach ($products as $i => [$name, $photoId, $hint]) {
            $price  = rand(500, 8000);
            $mrp    = $price + rand(100, 2000);
            $isDisc = ($mrp > $price) ? 1 : 0;
            $image  = 'https://images.unsplash.com/photo-' . $photoId . '?w=600&q=80&auto=format&fit=crop&sig=' . $i;

            $productId = DB::table('products')->insertGetId([
                'category_id'   => $categoryIds[array_rand($categoryIds)],
                'name'          => $name,
                'slug'          => Str::slug($name) . '-' . ($i + 1),
                'image'         => $image,
                'brand'         => $brandIds[array_rand($brandIds)],
                'short_desc'    => 'Premium quality ' . strtolower($name) . ' for everyday style.',
                'desc'          => 'Crafted with fine fabric, this ' . strtolower($name) . ' blends comfort with fashion. Available in multiple sizes and colours. Perfect for all occasions.',
                'keyword'       => strtolower($name) . ', fashion, clothing, stitchspot',
                'is_discounted' => $isDisc,
                'status'        => 1,
                'sold_count'    => rand(0, 200),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            $variantCount = rand(2, 3);
            $usedCombos   = [];
            for ($v = 0; $v < $variantCount; $v++) {
                $attempts = 0;
                do {
                    $sizeId  = $sizeIds[array_rand($sizeIds)];
                    $colorId = $colorIds[array_rand($colorIds)];
                    $attempts++;
                } while (in_array("$sizeId-$colorId", $usedCombos) && $attempts < 10);
                $usedCombos[] = "$sizeId-$colorId";

                DB::table('products_attr')->insert([
                    'products_id' => $productId,
                    'sku'         => strtoupper(Str::random(3)) . '-' . $productId . '-' . $v,
                    'mrp'         => $mrp,
                    'price'       => $price,
                    'qty'         => rand(5, 100),
                    'size_id'     => $sizeId,
                    'color_id'    => $colorId,
                    'attr_image'  => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $this->command->info('100 products seeded with Unsplash images.');
    }
}
