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
            'name'     => 'Administrator Gudang',
            'email'    => 'admin@inventory.local',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
        UserProfile::create([
            'user_id'   => $admin->id,
            'full_name' => 'Administrator Gudang Utama',
            'phone'     => '081234567890',
            'address'   => 'Jl. Merdeka No. 1, Jakarta Pusat',
        ]);

        $staff = User::create([
            'username' => 'staff',
            'name'     => 'Staff Operasional',
            'email'    => 'staff@inventory.local',
            'password' => Hash::make('password123'),
            'role'     => 'staff',
        ]);
        UserProfile::create([
            'user_id'   => $staff->id,
            'full_name' => 'Staff Petugas Lapangan',
            'phone'     => '081987654321',
            'address'   => 'Jl. Sudirman No. 20, Jakarta Selatan',
        ]);

        // 2. Seed Categories
        $cat1 = Category::create([
            'name'        => 'Perangkat Komputer',
            'description' => 'Komponen PC, laptop, dan peripheral hardware',
        ]);
        $cat2 = Category::create([
            'name'        => 'Aksesoris & Gadget',
            'description' => 'Kabel data, mouse, keyboard, headset, dan aksesoris',
        ]);
        $cat3 = Category::create([
            'name'        => 'Peralatan Jaringan',
            'description' => 'Router, switch, access point, dan kabel LAN',
        ]);
        $cat4 = Category::create([
            'name'        => 'Alat Tulis Kantor',
            'description' => 'Kebutuhan administrasi dan perlengkapan inventaris kantor',
        ]);

        // 3. Seed Suppliers
        $sup1 = Supplier::create([
            'name'           => 'PT Mitra Teknologi Mandiri',
            'contact_person' => 'Budi Santoso',
            'phone'          => '021-5550123',
            'address'        => 'Kawasan Industri Pulogadung, Jakarta Timur',
        ]);
        $sup2 = Supplier::create([
            'name'           => 'CV Sinar Logistik Elektronik',
            'contact_person' => 'Siti Rahma',
            'phone'          => '021-7770456',
            'address'        => 'Mangga Dua Square Blok B-12, Jakarta Utara',
        ]);
        $sup3 = Supplier::create([
            'name'           => 'PT Sumber Berkah Hardware',
            'contact_person' => 'Hendro Wijaya',
            'phone'          => '031-8880789',
            'address'        => 'Jl. Rungkut Industri III, Surabaya',
        ]);

        // 4. Seed Products
        $p1 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'SKU-LOGI-K120',
            'name'          => 'Logitech K120 USB Keyboard',
            'price'         => 145000.00,
            'stock'         => 35,
            'minimum_stock' => 10,
        ]);
        $p1->suppliers()->attach([
            $sup1->id => ['supplier_price' => 125000.00],
            $sup2->id => ['supplier_price' => 128000.00],
        ]);

        $p2 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'SKU-LOGI-B100',
            'name'          => 'Logitech B100 Optical Mouse',
            'price'         => 65000.00,
            'stock'         => 42,
            'minimum_stock' => 15,
        ]);
        $p2->suppliers()->attach([
            $sup1->id => ['supplier_price' => 52000.00],
        ]);

        $p3 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'SKU-SAM-SSD500',
            'name'          => 'Samsung 870 EVO SSD 500GB',
            'price'         => 780000.00,
            'stock'         => 8,
            'minimum_stock' => 10,
        ]);
        $p3->suppliers()->attach([
            $sup2->id => ['supplier_price' => 710000.00],
        ]);

        $p4 = Product::create([
            'category_id'   => $cat3->id,
            'sku'           => 'SKU-TPL-WR840',
            'name'          => 'TP-Link TL-WR840N Wireless Router',
            'price'         => 185000.00,
            'stock'         => 4,
            'minimum_stock' => 10,
        ]);
        $p4->suppliers()->attach([
            $sup3->id => ['supplier_price' => 160000.00],
        ]);

        $p5 = Product::create([
            'category_id'   => $cat2->id,
            'sku'           => 'SKU-VGR-CAT6',
            'name'          => 'Vention Kabel LAN Cat6 UTP 5M',
            'price'         => 45000.00,
            'stock'         => 20,
            'minimum_stock' => 10,
        ]);
        $p5->suppliers()->attach([
            $sup2->id => ['supplier_price' => 35000.00],
        ]);

        $p6 = Product::create([
            'category_id'   => $cat4->id,
            'sku'           => 'SKU-SID-A475',
            'name'          => 'Kertas HVS Sinar Dunia A4 75gr',
            'price'         => 52000.00,
            'stock'         => 3,
            'minimum_stock' => 10,
        ]);
        $p6->suppliers()->attach([
            $sup3->id => ['supplier_price' => 44000.00],
        ]);

        $p7 = Product::create([
            'category_id'   => $cat1->id,
            'sku'           => 'SKU-MON-LG24',
            'name'          => 'Monitor LG 24MP400-B 24 Inch IPS',
            'price'         => 1420000.00,
            'stock'         => 12,
            'minimum_stock' => 5,
        ]);
        $p7->suppliers()->attach([
            $sup1->id => ['supplier_price' => 1290000.00],
        ]);

        // 5. Seed Initial Stock Movements (Slide 25 & 26)
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 40,
            'notes'      => 'Penerimaan stok batch awal (Laravel)',
        ]);
        StockMovement::create([
            'product_id' => $p1->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 5,
            'notes'      => 'Pengeluaran untuk workstation finance',
        ]);
        StockMovement::create([
            'product_id' => $p3->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 10,
            'notes'      => 'Stok awal SSD server lokal',
        ]);
        StockMovement::create([
            'product_id' => $p3->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 2,
            'notes'      => 'Pengeluaran untuk unit divisi desain',
        ]);
        StockMovement::create([
            'product_id' => $p4->id,
            'user_id'    => $admin->id,
            'type'       => 'IN',
            'quantity'   => 10,
            'notes'      => 'Restock awal router jaringan',
        ]);
        StockMovement::create([
            'product_id' => $p4->id,
            'user_id'    => $staff->id,
            'type'       => 'OUT',
            'quantity'   => 6,
            'notes'      => 'Instalasi router gedung lantai 2',
        ]);
    }
}
