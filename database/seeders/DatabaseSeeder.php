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
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Users & Profiles (Slide 23 & 32)
        $admin = User::create([
            'username' => 'admin',
            'name'     => 'Madame Claire de Valois',
            'email'    => 'admin@maisonsole.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
        UserProfile::create([
            'user_id'   => $admin->id,
            'full_name' => 'Madame Claire de Valois',
            'phone'     => '+62 811-9876-543',
            'address'   => 'Plaza Senayan Luxury Arcade No. 4, Jakarta Pusat',
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
            'address'   => 'Pacific Place Grand Gallery Level 2, Jakarta Selatan',
        ]);

        // 2. Seed Categories (Koleksi Heels Ternama)
        $cat1 = Category::create([
            'name'        => 'Stiletto & Court Pumps',
            'description' => 'Heels berhak runcing klasik ikonik berkarakter elegan dan sensual',
        ]);
        $cat2 = Category::create([
            'name'        => 'Evening Strappy Sandals',
            'description' => 'Sandal pesta bertali halus dengan hiasan kristal dan aksen metalik mewah',
        ]);
        $cat3 = Category::create([
            'name'        => 'Haute Bridal & Couture',
            'description' => 'Koleksi mahakarya bertabur kristal Swarovski khusus pernikahan & gala premier',
        ]);
        $cat4 = Category::create([
            'name'        => 'Sculptural & Platform Heels',
            'description' => 'Hak bentuk artistik arsitektural dan sol platform untuk siluet kontemporer',
        ]);
        $cat5 = Category::create([
            'name'        => 'Luxury Mules & Slingbacks',
            'description' => 'Selop terbuka belakang bergaya French chic serta slingback bertali anggun',
        ]);

        // 3. Seed Suppliers (Maisons & Luxury Ateliers)
        $sup1 = Supplier::create([
            'name'           => 'Maison Christian Louboutin S.A.S.',
            'contact_person' => 'Éléonore Dubois',
            'phone'          => '+33 1 42 36 53 66',
            'address'        => '19 Rue Jean-Jacques Rousseau, 75001 Paris, France',
        ]);
        $sup2 = Supplier::create([
            'name'           => 'Cesare Paciotti S.p.A. Milano',
            'contact_person' => 'Marco Paciotti',
            'phone'          => '+39 0733 82921',
            'address'        => 'Via Santa Maria a Monte, Civitanova Marche, Italy',
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

        // 4. Seed Products (Iconic Designer Heels)
        $p1 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'LOUB-SO-KATE-120',
            'name'          => 'Christian Louboutin So Kate 120mm Patent Rouge Noir',
            'price'         => 14850000.00,
            'stock'         => 18,
            'minimum_stock' => 5,
        ]);
        $p1->suppliers()->attach([
            $sup1->id => ['supplier_price' => 10500000.00],
            $sup4->id => ['supplier_price' => 11200000.00],
        ]);

        $p2 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'PACI-DAG-STIL-105',
            'name'          => 'Cesare Paciotti Dagger Stiletto 105mm Black Suede',
            'price'         => 12500000.00,
            'stock'         => 14,
            'minimum_stock' => 4,
        ]);
        $p2->suppliers()->attach([
            $sup2->id => ['supplier_price' => 8800000.00],
        ]);

        $p3 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'MANO-HANG-EMRD-105',
            'name'          => 'Manolo Blahnik Hangisi 105 Emerald Jewel Satin Pump',
            'price'         => 18250000.00,
            'stock'         => 8,
            'minimum_stock' => 4,
        ]);
        $p3->suppliers()->attach([
            $sup3->id => ['supplier_price' => 13200000.00],
        ]);

        $p4 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'CHOO-CIND-CRYST-110',
            'name'          => 'Jimmy Choo Cinderella Swarovski Crystal Stiletto',
            'price'         => 58000000.00,
            'stock'         => 4,
            'minimum_stock' => 3,
        ]);
        $p4->suppliers()->attach([
            $sup4->id => ['supplier_price' => 42000000.00],
        ]);

        $p5 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'MUAD-BEG-GLASS-95',
            'name'          => 'Amina Muaddi Begum Glass Slingback Sculpted Heel',
            'price'         => 16900000.00,
            'stock'         => 12,
            'minimum_stock' => 5,
        ]);
        $p5->suppliers()->attach([
            $sup5->id => ['supplier_price' => 12000000.00],
        ]);

        $p6 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'MACH-DBL-BOW-100',
            'name'          => 'Mach & Mach Double Bow Crystal Silk-Satin Pump',
            'price'         => 17500000.00,
            'stock'         => 9,
            'minimum_stock' => 4,
        ]);
        $p6->suppliers()->attach([
            $sup6->id => ['supplier_price' => 12800000.00],
            $sup5->id => ['supplier_price' => 13000000.00],
        ]);

        $p7 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'LOUB-HOT-CHIC-100',
            'name'          => 'Christian Louboutin Hot Chick 100mm Scalloped Rouge',
            'price'         => 15200000.00,
            'stock'         => 15,
            'minimum_stock' => 5,
        ]);
        $p7->suppliers()->attach([
            $sup1->id => ['supplier_price' => 11000000.00],
        ]);

        $p8 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'PACI-GLD-CHAIN-110',
            'name'          => 'Cesare Paciotti Metallic Gold Chain Strap Sandal',
            'price'         => 13800000.00,
            'stock'         => 7,
            'minimum_stock' => 4,
        ]);
        $p8->suppliers()->attach([
            $sup2->id => ['supplier_price' => 9800000.00],
        ]);

        $p9 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'CHOO-AVEL-BOW-100',
            'name'          => 'Jimmy Choo Aveline 100 Asymmetric Grosgrain Bow',
            'price'         => 19500000.00,
            'stock'         => 6,
            'minimum_stock' => 3,
        ]);
        $p9->suppliers()->attach([
            $sup4->id => ['supplier_price' => 14000000.00],
        ]);

        $p10 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'MUAD-LUPITA-SLD-95',
            'name'          => 'Amina Muaddi Lupita Mules Glass Emerald Heel',
            'price'         => 14200000.00,
            'stock'         => 11,
            'minimum_stock' => 4,
        ]);
        $p10->suppliers()->attach([
            $sup5->id => ['supplier_price' => 10200000.00],
        ]);

        $p11 = Product::create([
            'category_id'   => $cat4->id,
            'sku'           => 'LOUB-LIPSTICK-100',
            'name'          => 'Christian Louboutin Lipbootie Metallic Heel',
            'price'         => 22000000.00,
            'stock'         => 3,
            'minimum_stock' => 4,
        ]);
        $p11->suppliers()->attach([
            $sup1->id => ['supplier_price' => 16000000.00],
        ]);

        $p12 = Product::create([
            'category_id'   => $cat5->id,
            'sku'           => 'MANO-LURUM-90',
            'name'          => 'Manolo Blahnik Lurum 90 Jewel Embellished Velvet Mule',
            'price'         => 19800000.00,
            'stock'         => 5,
            'minimum_stock' => 4,
        ]);
        $p12->suppliers()->attach([
            $sup3->id => ['supplier_price' => 14500000.00],
        ]);

        // 5. Seed Stock Movements (Restock & Real Boutique Sales)
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 25,
            'notes'      => 'Pengiriman konsinyasi langsung dari Paris Atelier',
            'created_at' => Carbon::now()->subDays(14),
        ]);
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 4,
            'notes'      => 'Penjualan VIP Suite - Faktur #MAI-7701',
            'created_at' => Carbon::now()->subDays(12),
        ]);
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 3,
            'notes'      => 'Penjualan Butik Plaza Senayan - Faktur #MAI-7740',
            'created_at' => Carbon::now()->subDays(8),
        ]);

        StockMovement::create([
            'product_id' => $p2->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 20,
            'notes'      => 'Import musiman Cesare Paciotti Milano',
            'created_at' => Carbon::now()->subDays(13),
        ]);
        StockMovement::create([
            'product_id' => $p2->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 6,
            'notes'      => 'Penjualan Private Trunk Show - Faktur #MAI-7755',
            'created_at' => Carbon::now()->subDays(6),
        ]);

        StockMovement::create([
            'product_id' => $p3->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 12,
            'notes'      => 'Restock Manolo Blahnik Hangisi Royal Edition',
            'created_at' => Carbon::now()->subDays(11),
        ]);
        StockMovement::create([
            'product_id' => $p3->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 4,
            'notes'      => 'Penjualan Gaun Pengantin Couture - Faktur #MAI-7790',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        StockMovement::create([
            'product_id' => $p4->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 5,
            'notes'      => 'Koleksi Terbatas Jimmy Choo Cinderella Crystal',
            'created_at' => Carbon::now()->subDays(10),
        ]);
        StockMovement::create([
            'product_id' => $p4->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 1,
            'notes'      => 'Penjualan Gala Charity Red Carpet - Faktur #MAI-7810',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        StockMovement::create([
            'product_id' => $p5->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 16,
            'notes'      => 'Restock Amina Muaddi Glass Heel Batch I',
            'created_at' => Carbon::now()->subDays(9),
        ]);
        StockMovement::create([
            'product_id' => $p5->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 4,
            'notes'      => 'Penjualan Butik Pacific Place - Faktur #MAI-7835',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        StockMovement::create([
            'product_id' => $p6->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 12,
            'notes'      => 'Konsinyasi Mach & Mach Double Bow Tbilisi',
            'created_at' => Carbon::now()->subDays(7),
        ]);
        StockMovement::create([
            'product_id' => $p6->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 3,
            'notes'      => 'Penjualan Festive Holiday Event - Faktur #MAI-7860',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        StockMovement::create([
            'product_id' => $p7->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 18,
            'notes'      => 'Penerimaan batch Louboutin Scalloped Rouge',
            'created_at' => Carbon::now()->subDays(5),
        ]);
        StockMovement::create([
            'product_id' => $p7->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 3,
            'notes'      => 'Penjualan Walk-in VIP Client - Faktur #MAI-7882',
            'created_at' => Carbon::now(),
        ]);

        StockMovement::create([
            'product_id' => $p11->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 5,
            'notes'      => 'Koleksi Runway Lipbootie Limited',
            'created_at' => Carbon::now()->subDays(4),
        ]);
        StockMovement::create([
            'product_id' => $p11->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 2,
            'notes'      => 'Penjualan Kolektor Footwear - Faktur #MAI-7890',
            'created_at' => Carbon::now(),
        ]);
    }
}
