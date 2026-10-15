<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Sesuai dengan data pengujian Mini Project 3 (Maison Sole)
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Users & Profiles (Claire de Valois & Aurelia Sastrawinata)
        $admin = User::create([
            'username' => 'admin',
            'name'     => 'Madame Claire de Valois',
            'email'    => 'admin@maisonsole.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
        UserProfile::create([
            'user_id'   => $admin->id,
            'full_name' => 'Claire de Valois',
            'phone'     => '+62 811-9876-543',
            'address'   => 'Plaza Senayan Luxury Suite Level 3, Jakarta',
        ]);

        $staff = User::create([
            'username' => 'staff',
            'name'     => 'Aurelia Sastrawinata',
            'email'    => 'staff@maisonsole.com',
            'password' => Hash::make('password123'),
            'role'     => 'staff',
        ]);
        UserProfile::create([
            'user_id'   => $staff->id,
            'full_name' => 'Aurelia Sastrawinata',
            'phone'     => '+62 812-4567-890',
            'address'   => 'Pacific Place Grand Gallery Level 2, Jakarta',
        ]);

        // 2. Seed 5 Kategori Siluet Heels
        $cat1 = Category::create([
            'name'        => 'Stiletto & Pointed Pumps',
            'description' => 'Heels berhak runcing klasik ikonik berkarakter anggun, tajam, dan percaya diri.',
        ]);
        $cat2 = Category::create([
            'name'        => 'Haute Bridal & Crystal Gala',
            'description' => 'Koleksi mahakarya bertabur kristal Swarovski untuk pesta pernikahan & karpet merah.',
        ]);
        $cat3 = Category::create([
            'name'        => 'Evening Strappy & Chain Sandals',
            'description' => 'Sandal pesta bertali halus dengan aksen rantai metalik dan tali pergelangan kaki mewah.',
        ]);
        $cat4 = Category::create([
            'name'        => 'Sculptural & Glass Heels',
            'description' => 'Siluet kontemporer dengan hak kaca piramida artistik berarsitektur tinggi.',
        ]);
        $cat5 = Category::create([
            'name'        => 'Luxury Mules & Slingbacks',
            'description' => 'Selop terbuka belakang bergaya French chic serta slingback bertali satin permata.',
        ]);

        // 3. Seed 6 Luxury Maisons & Distributors (Pemasok Resmi)
        $sup1 = Supplier::create([
            'name'           => 'Cesare Paciotti S.p.A. Milano',
            'contact_person' => 'Marco Paciotti',
            'phone'          => '+39 0733 82921',
            'address'        => 'Via Santa Maria a Monte, Civitanova Marche, Milano, Italy',
        ]);
        $sup2 = Supplier::create([
            'name'           => 'Maison Christian Louboutin S.A.S.',
            'contact_person' => 'Éléonore Dubois',
            'phone'          => '+33 1 42 36 53 66',
            'address'        => '19 Rue Jean-Jacques Rousseau, 75001 Paris, France',
        ]);
        $sup3 = Supplier::create([
            'name'           => 'Manolo Blahnik International Ltd.',
            'contact_person' => 'Isabella Wright',
            'phone'          => '+44 20 7352 8622',
            'address'        => '49 Old Church Street, Chelsea, London, UK',
        ]);
        $sup4 = Supplier::create([
            'name'           => 'Jimmy Choo Flagship Atelier',
            'contact_person' => 'Victoria Kensington',
            'phone'          => '+44 20 7493 5858',
            'address'        => '27 New Bond Street, Mayfair, London, UK',
        ]);
        $sup5 = Supplier::create([
            'name'           => 'Amina Muaddi Studio Milano',
            'contact_person' => 'Chiara Bertolini',
            'phone'          => '+39 02 8905 4410',
            'address'        => 'Via Montenapoleone 18, 20121 Milano, Italy',
        ]);
        $sup6 = Supplier::create([
            'name'           => 'Mach & Mach Haute Couture Atelier',
            'contact_person' => 'Nina Macharashvili',
            'phone'          => '+39 02 7600 3211',
            'address'        => 'Via della Spiga 9, 20121 Milano, Italy',
        ]);

        // 4. Seed 16 Produk Koleksi Heels Ternama (Sinkron 100% dengan Web 3)
        $p1 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'LOUB-SO-KATE-120',
            'name'          => 'Christian Louboutin So Kate 120mm Patent Rouge Noir',
            'price'         => 15500000.00,
            'stock'         => 18,
            'minimum_stock' => 5,
        ]);
        $p1->suppliers()->attach([
            $sup2->id => ['supplier_price' => 11000000.00],
        ]);

        $p2 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'PACI-DAG-STIL-105',
            'name'          => 'Cesare Paciotti Blade Dagger Stiletto 105mm Black Suede',
            'price'         => 13800000.00,
            'stock'         => 14,
            'minimum_stock' => 4,
        ]);
        $p2->suppliers()->attach([
            $sup1->id => ['supplier_price' => 9500000.00],
            $sup2->id => ['supplier_price' => 9800000.00],
        ]);

        $p3 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'MANO-HANG-EMRD-105',
            'name'          => 'Manolo Blahnik Hangisi 105 Emerald Jewel Satin Pump',
            'price'         => 19500000.00,
            'stock'         => 8,
            'minimum_stock' => 4,
        ]);
        $p3->suppliers()->attach([
            $sup3->id => ['supplier_price' => 14000000.00],
        ]);

        $p4 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'MANO-HANG-BLUE-105',
            'name'          => 'Manolo Blahnik Hangisi 105 Royal Blue Crystal Buckle',
            'price'         => 19500000.00,
            'stock'         => 11,
            'minimum_stock' => 4,
        ]);
        $p4->suppliers()->attach([
            $sup3->id => ['supplier_price' => 14000000.00],
        ]);

        $p5 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'CHOO-CIND-CRYST-110',
            'name'          => 'Jimmy Choo Cinderella Swarovski Crystal Stiletto',
            'price'         => 62000000.00,
            'stock'         => 3,
            'minimum_stock' => 3,
        ]);
        $p5->suppliers()->attach([
            $sup4->id => ['supplier_price' => 45000000.00],
        ]);

        $p6 = Product::create([
            'category_id'   => $cat4->id,
            'sku'           => 'MUAD-BEG-GLASS-95',
            'name'          => 'Amina Muaddi Begum Glass Slingback Sculpted Heel',
            'price'         => 17500000.00,
            'stock'         => 12,
            'minimum_stock' => 5,
        ]);
        $p6->suppliers()->attach([
            $sup1->id => ['supplier_price' => 12800000.00],
            $sup5->id => ['supplier_price' => 12500000.00],
        ]);

        $p7 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'MACH-DBL-BOW-100',
            'name'          => 'Mach & Mach Double Bow Crystal Silk-Satin Pump',
            'price'         => 18200000.00,
            'stock'         => 9,
            'minimum_stock' => 4,
        ]);
        $p7->suppliers()->attach([
            $sup6->id => ['supplier_price' => 13200000.00],
        ]);

        $p8 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'LOUB-HOT-CHIC-100',
            'name'          => 'Christian Louboutin Hot Chick 100mm Scalloped Rouge',
            'price'         => 15800000.00,
            'stock'         => 15,
            'minimum_stock' => 5,
        ]);
        $p8->suppliers()->attach([
            $sup2->id => ['supplier_price' => 11200000.00],
        ]);

        $p9 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'PACI-GLD-CHAIN-110',
            'name'          => 'Cesare Paciotti Metallic Gold Chain Strap Sandal',
            'price'         => 14500000.00,
            'stock'         => 6,
            'minimum_stock' => 4,
        ]);
        $p9->suppliers()->attach([
            $sup1->id => ['supplier_price' => 10200000.00],
        ]);

        $p10 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'CHOO-AVEL-BOW-100',
            'name'          => 'Jimmy Choo Aveline 100 Asymmetric Grosgrain Bow Sandal',
            'price'         => 21000000.00,
            'stock'         => 7,
            'minimum_stock' => 3,
        ]);
        $p10->suppliers()->attach([
            $sup4->id => ['supplier_price' => 15000000.00],
        ]);

        $p11 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'CHOO-BING-MULE-100',
            'name'          => 'Jimmy Choo Bing 100 Crystal Embellished Patent Mule',
            'price'         => 16800000.00,
            'stock'         => 10,
            'minimum_stock' => 4,
        ]);
        $p11->suppliers()->attach([
            $sup4->id => ['supplier_price' => 12000000.00],
        ]);

        $p12 = Product::create([
            'category_id'   => $cat4->id,
            'sku'           => 'MUAD-LUPITA-SLD-95',
            'name'          => 'Amina Muaddi Lupita Mules Glass Emerald Heel',
            'price'         => 14800000.00,
            'stock'         => 11,
            'minimum_stock' => 4,
        ]);
        $p12->suppliers()->attach([
            $sup5->id => ['supplier_price' => 10500000.00],
        ]);

        $p13 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'MUAD-ROSIE-BOW-95',
            'name'          => 'Amina Muaddi Rosie Crystal Bow Satin Slingback',
            'price'         => 17200000.00,
            'stock'         => 5,
            'minimum_stock' => 4,
        ]);
        $p13->suppliers()->attach([
            $sup5->id => ['supplier_price' => 12200000.00],
        ]);

        $p14 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'MANO-LURUM-90',
            'name'          => 'Manolo Blahnik Lurum 90 Jewel Embellished Velvet Mule',
            'price'         => 20500000.00,
            'stock'         => 4,
            'minimum_stock' => 4,
        ]);
        $p14->suppliers()->attach([
            $sup3->id => ['supplier_price' => 14800000.00],
        ]);

        $p15 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'MACH-DIAM-ELIZ-100',
            'name'          => 'Mach & Mach Diamond of Elizabeth Pointed Toe Pump',
            'price'         => 19800000.00,
            'stock'         => 6,
            'minimum_stock' => 3,
        ]);
        $p15->suppliers()->attach([
            $sup6->id => ['supplier_price' => 14200000.00],
        ]);

        $p16 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'LOUB-PIG-FOL-100',
            'name'          => 'Christian Louboutin Pigalle Follies 100mm Nude Calfskin',
            'price'         => 14200000.00,
            'stock'         => 16,
            'minimum_stock' => 5,
        ]);
        $p16->suppliers()->attach([
            $sup2->id => ['supplier_price' => 10100000.00],
        ]);

        // 5. Seed 21 Histori Mutasi Stok (IN & OUT)
        $movements = [
            ['p' => $p1, 'u' => $admin, 'type' => 'IN',  'qty' => 25, 'notes' => 'Pengiriman batch perdana dari Paris Atelier', 'days' => 14],
            ['p' => $p1, 'u' => $staff, 'type' => 'OUT', 'qty' => 4,  'notes' => 'Penjualan VIP Suite Plaza Senayan - Faktur #MAI-8801', 'days' => 12],
            ['p' => $p1, 'u' => $staff, 'type' => 'OUT', 'qty' => 3,  'notes' => 'Penjualan Butik Plaza Senayan - Faktur #MAI-8815', 'days' => 9],
            ['p' => $p2, 'u' => $admin, 'type' => 'IN',  'qty' => 20, 'notes' => 'Import musiman Cesare Paciotti Milano', 'days' => 13],
            ['p' => $p2, 'u' => $staff, 'type' => 'OUT', 'qty' => 6,  'notes' => 'Penjualan Private Trunk Show - Faktur #MAI-8822', 'days' => 8],
            ['p' => $p3, 'u' => $admin, 'type' => 'IN',  'qty' => 12, 'notes' => 'Restock Manolo Blahnik Hangisi Royal Edition', 'days' => 11],
            ['p' => $p3, 'u' => $staff, 'type' => 'OUT', 'qty' => 4,  'notes' => 'Penjualan Gaun Pengantin Couture - Faktur #MAI-8835', 'days' => 7],
            ['p' => $p4, 'u' => $admin, 'type' => 'IN',  'qty' => 15, 'notes' => 'Restock Manolo Blahnik Hangisi Blue Satin', 'days' => 10],
            ['p' => $p4, 'u' => $staff, 'type' => 'OUT', 'qty' => 4,  'notes' => 'Penjualan VIP Bridal Suite - Faktur #MAI-8840', 'days' => 6],
            ['p' => $p5, 'u' => $admin, 'type' => 'IN',  'qty' => 5,  'notes' => 'Koleksi Terbatas Jimmy Choo Cinderella Crystal', 'days' => 9],
            ['p' => $p5, 'u' => $staff, 'type' => 'OUT', 'qty' => 2,  'notes' => 'Penjualan Red Carpet Gala - Faktur #MAI-8850', 'days' => 4],
            ['p' => $p6, 'u' => $admin, 'type' => 'IN',  'qty' => 16, 'notes' => 'Restock Amina Muaddi Glass Heel Batch I', 'days' => 8],
            ['p' => $p6, 'u' => $staff, 'type' => 'OUT', 'qty' => 4,  'notes' => 'Penjualan Butik Pacific Place - Faktur #MAI-8862', 'days' => 3],
            ['p' => $p7, 'u' => $admin, 'type' => 'IN',  'qty' => 12, 'notes' => 'Konsinyasi Mach & Mach Double Bow Crystal Silk', 'days' => 7],
            ['p' => $p7, 'u' => $staff, 'type' => 'OUT', 'qty' => 3,  'notes' => 'Penjualan Festive Season VIP - Faktur #MAI-8870', 'days' => 2],
            ['p' => $p8, 'u' => $admin, 'type' => 'IN',  'qty' => 18, 'notes' => 'Penerimaan batch Christian Louboutin Hot Chick', 'days' => 6],
            ['p' => $p8, 'u' => $staff, 'type' => 'OUT', 'qty' => 3,  'notes' => 'Penjualan Walk-in VIP Client - Faktur #MAI-8884', 'days' => 1],
            ['p' => $p9, 'u' => $admin, 'type' => 'IN',  'qty' => 10, 'notes' => 'Restock Cesare Paciotti Gold Chain Sandal', 'days' => 5],
            ['p' => $p9, 'u' => $staff, 'type' => 'OUT', 'qty' => 4,  'notes' => 'Penjualan Fashion Week Private Client - Faktur #MAI-8891', 'days' => 0],
            ['p' => $p14, 'u' => $admin, 'type' => 'IN', 'qty' => 6,  'notes' => 'Restock Manolo Blahnik Lurum Velvet', 'days' => 4],
            ['p' => $p14, 'u' => $staff, 'type' => 'OUT', 'qty' => 2,  'notes' => 'Penjualan Kolektor Footwear - Faktur #MAI-8898', 'days' => 0],
        ];

        foreach ($movements as $m) {
            StockMovement::create([
                'product_id' => $m['p']->id,
                'user_id'    => $m['u']->id,
                'type'       => $m['type'],
                'quantity'   => $m['qty'],
                'notes'      => $m['notes'],
                'created_at' => Carbon::now()->subDays($m['days']),
            ]);
        }
    }
}
