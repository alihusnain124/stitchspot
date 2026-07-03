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
            ['Classic Oxford Shirt', '1441984904996-e0b6ba687e04', 'shirt'],
            ['Slim Fit Chinos', '1441986300917-64674bd600d8', 'chinos'],
            ['Formal Suit Set', '1445205170230-053b83016050', 'suit'],
            ['Kurta Shalwar Combo', '1470309864661-68328b2cd0a5', 'kurta'],
            ['Denim Jacket', '1476234251651-f353703a034d', 'denim jacket'],
            ['Embroidered Lawn Dress', '1483985988355-763728e1935b', 'lawn dress'],
            ['Silk Shalwar Kameez', '1485230895905-ec40ba36b9bc', 'silk dress'],
            ['Bridal Lehenga Choli', '1485968579580-b6d095142e6e', 'bridal'],
            ['Sports Tracksuit', '1487222477894-8943e31ef7b2', 'tracksuit'],
            ['Hoodie Sweatshirt', '1487412947147-5cebf100ffc2', 'hoodie'],
            ['Cargo Pants', '1489424731084-a5d8b219a5bb', 'cargo pants'],
            ['Polo Shirt', '1489987707025-afc232f7ea0f', 'polo shirt'],
            ['Printed T-Shirt', '1490481651871-ab68de25d43d', 'tshirt'],
            ['Linen Trousers', '1490578474895-699cd4e2cf59', 'trousers'],
            ['Wedding Sherwani', '1494178270175-e96de2971df9', 'sherwani'],
            ['Peplum Top', '1495385794356-15371f348c31', 'top fashion'],
            ['Palazzo Pants', '1496747611176-843222e1e57c', 'palazzo'],
            ['Cold Shoulder Dress', '1503341455253-b2e723bb3dbb', 'dress'],
            ['Wrap Dress', '1503342217505-b0a15ec3261c', 'wrap dress'],
            ['Midi Skirt', '1506629082955-511b1aa562c8', 'skirt'],
            ['Floral Maxi Dress', '1507003211169-0a1dd7228f2d', 'floral dress'],
            ['Off-Shoulder Top', '1507679799987-c73779587ccf', 'off shoulder top'],
            ['Jumpsuit', '1509319117193-57bab727e09d', 'jumpsuit'],
            ['Romper', '1509631179647-0177331693ae', 'romper'],
            ['Blazer Coat', '1512436991641-6745cdb1723f', 'blazer'],
            ['Peacoat', '1515886657613-9f3515b0c78f', 'peacoat'],
            ['Trench Coat', '1516450360452-9312f5e86fc7', 'trench coat'],
            ['Wool Sweater', '1516762689617-e1cffcef479d', 'sweater'],
            ['Knit Cardigan', '1516763296043-f676c1105999', 'cardigan'],
            ['Turtleneck Pullover', '1517841905240-472988babdf9', 'turtleneck'],
            ['Fleece Jacket', '1518049362265-d5b2a6467637', 'fleece jacket'],
            ['Windbreaker', '1519238263530-99bdd11df2ea', 'windbreaker'],
            ['Athletic Shorts', '1519741497674-611481863552', 'athletic shorts'],
            ['Yoga Pants', '1520975954732-35dd22299614', 'yoga pants'],
            ['Compression Tights', '1521310192545-4ac7951413f0', 'tights'],
            ['Tank Top', '1521572163474-6864f9cf17ab', 'tank top'],
            ['Sports Bra', '1521577352947-9bb58764b69a', 'sports bra'],
            ['Running Jacket', '1522335789203-aabd1fc54bc9', 'running jacket'],
            ['Gym Vest', '1523381294911-8d3cead13475', 'gym vest'],
            ['Cricket Whites', '1523398002811-999ca8dec234', 'cricket whites'],
            ['Boys School Uniform', '1524250502761-1ac6f2e30d43', 'school uniform'],
            ['Girls Frock', '1524638431109-93d95c968f03', 'girls dress'],
            ['Baby Romper', '1525966222134-fcfa99b8ae77', 'baby clothes'],
            ['Kids Kurta', '1526178613552-2b45c6c302f0', 'kids kurta'],
            ['Toddler Jeans', '1539109136881-3be0616acf4b', 'toddler jeans'],
            ['Children\'s Hoodie', '1539185441755-769473a23570', 'kids hoodie'],
            ['Girls Lehenga', '1542272604-787c3835535d', 'girls lehenga'],
            ['Boys Sherwani', '1542291026-7eec264c27ff', 'boys sherwani'],
            ['Newborn Set', '1543076447-215ad9ba6923', 'newborn clothes'],
            ['Kids Track Pants', '1544022613-e87ca75a784a', 'kids track pants'],
            ['Abayas', '1548036328-c9fa89d128fa', 'abaya'],
            ['Hijab Scarf', '1548126032-079a0fb0099d', 'hijab scarf'],
            ['Kaftan Dress', '1550246140-29f40b909e5a', 'kaftan'],
            ['Jalabiya', '1551028719-00167b16eac5', 'jalabiya'],
            ['Printed Lawn Suit', '1552346154-21d32810aba3', 'lawn suit'],
            ['Chiffon Dupatta', '1552374196-c4e7ffc6e126', 'chiffon scarf'],
            ['Net Embroidered Dupatta', '1553062407-98eeb64c6a62', 'dupatta'],
            ['Raw Silk Suit', '1554568218-0f1715e72254', 'silk suit'],
            ['Velvet Shawl', '1556905055-8f358a7a47b2', 'velvet shawl'],
            ['Pashmina Wrap', '1558618666-fcd25c85cd64', 'pashmina'],
            ['Formal Trousers', '1558769132-cb1aea458c5e', 'formal trousers'],
            ['Business Shirt', '1560243563-062bfc001d68', 'business shirt'],
            ['Waistcoat', '1565084888279-aca607ecce0c', 'waistcoat'],
            ['Double Breasted Blazer', '1566206091558-7f218b696731', 'double breasted blazer'],
            ['Nehru Jacket', '1567401893414-76b7b1e5a7a5', 'nehru jacket'],
            ['Mandarin Collar Shirt', '1572635196237-14b3f281503f', 'mandarin collar'],
            ['Linen Kurta', '1576566588028-4147f3842f27', 'linen kurta'],
            ['Pathani Suit', '1583744946564-b52ac1c389c8', 'pathani suit'],
            ['Shalwar Kameez Set', '1584917865442-de89df76afd3', 'shalwar kameez'],
            ['Dhoti Kurta', '1586790170083-2f9ceadc732d', 'dhoti kurta'],
            ['Indo-Western Outfit', '1591085686350-798c0f9faa7f', 'indo western'],
            ['Anarkali Suit', '1598300042247-d088f8ab3a91', 'anarkali'],
            ['Churidar Set', '1602810318383-e386cc2a3ccf', 'churidar'],
            ['Sharara Set', '1604176354204-9268737828e4', 'sharara'],
            ['Gharara Set', '1606107557195-0e29a4b5b4aa', 'gharara'],
            ['Designer Saree Blouse', '1607082348824-0a96f2a4b9da', 'saree blouse'],
            ['Pre-stitched Saree', '1608234808654-2a8875faa7fd', 'saree'],
            ['Net Saree', '1612336307429-8a898d10e223', 'net saree'],
            ['Banarasi Silk Saree', '1614786269829-d24616faf56d', 'banarasi saree'],
            ['Zari Work Lehenga', '1624378439575-d8705ad7ae80', 'lehenga'],
            ['Mirror Work Blouse', '1441984904996-e0b6ba687e04', 'mirror work'],
            ['Block Print Kurti', '1441986300917-64674bd600d8', 'kurti'],
            ['Tie-Dye Dress', '1445205170230-053b83016050', 'tie dye dress'],
            ['Batik Print Top', '1470309864661-68328b2cd0a5', 'batik top'],
            ['Sequin Evening Gown', '1476234251651-f353703a034d', 'evening gown'],
            ['Cocktail Dress', '1483985988355-763728e1935b', 'cocktail dress'],
            ['Party Wear Suit', '1485230895905-ec40ba36b9bc', 'party wear'],
            ['Reception Gown', '1485968579580-b6d095142e6e', 'reception gown'],
            ['Nikah Dress', '1487222477894-8943e31ef7b2', 'bridal dress'],
            ['Valima Outfit', '1487412947147-5cebf100ffc2', 'valima outfit'],
            ['Mehndi Lehnga', '1489424731084-a5d8b219a5bb', 'mehndi dress'],
            ['Barat Dress', '1489987707025-afc232f7ea0f', 'barat dress'],
            ['Puffer Jacket', '1490481651871-ab68de25d43d', 'puffer jacket'],
            ['Sherpa Hoodie', '1490578474895-699cd4e2cf59', 'sherpa hoodie'],
            ['Thermal Inner Suit', '1494178270175-e96de2971df9', 'thermal suit'],
            ['Cable Knit Sweater', '1495385794356-15371f348c31', 'cable knit sweater'],
            ['Quilted Vest', '1496747611176-843222e1e57c', 'quilted vest'],
            ['Shearling Coat', '1503341455253-b2e723bb3dbb', 'shearling coat'],
            ['Flannel Shirt', '1503342217505-b0a15ec3261c', 'flannel shirt'],
            ['Corduroy Jacket', '1506629082955-511b1aa562c8', 'corduroy jacket'],
            ['Satin Slip Dress', '1507003211169-0a1dd7228f2d', 'satin slip dress'],
            ['Velvet Blazer', '1507679799987-c73779587ccf', 'velvet blazer'],
        ];

        foreach ($products as $i => [$name, $photoId, $hint]) {
            $mrp    = rand(500, 8000);
            $isDisc = rand(0, 1);
            $price  = $isDisc ? max(100, $mrp - rand(100, 2000)) : $mrp;
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
                    'attr_image'  => $image,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $this->command->info('100 products seeded with Unsplash images.');
    }
}
