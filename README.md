# Mini Project 4 — Maison Sole (Laravel Haute Couture Heels Inventory Management)
> **Mata Kuliah:** Pemrograman Web  
> **Pertemuan 5:** Laravel Fundamental (Refactoring & Migrasi P4 ke Laravel)  
> **Teknologi:** Laravel 8.x + MySQL + Blade Template Engine + Chart.js + Haute Couture Luxury UI/UX  
> **Tema Inventori:** Koleksi Sepatu Heels Mewah & Ternama (Christian Louboutin, Cesare Paciotti, Manolo Blahnik, Jimmy Choo, Amina Muaddi, Mach & Mach)

---

## 👠 Deskripsi Proyek
**Maison Sole (Mini Project 4)** adalah hasil transformasi dan refactoring arsitektural menyeluruh dari aplikasi inventori PHP Native (Pertemuan 4) menjadi aplikasi modern berbasis **Laravel MVC Framework**. Mengusung tema butik mewah sepatu heels ternama dunia, proyek ini menggabungkan keanggunan estetika visual *haute couture* (Velvet Rouge `#8B1538`, Champagne Gold `#C5A059`, Obsidian `#1A1A1A`, tipografi *Playfair Display* & *Plus Jakarta Sans*) dengan disiplin rekayasa perangkat lunak standar industri.

Aplikasi ini dilengkapi **fitur otomatisasi penjualan real-time** yang menjawab kebutuhan admin agar tidak perlu repot melakukan input manual transaksi yang terjual:
1. **Simulasi Terjual Otomatis (Real-Time Auto-Sales Bot via Eloquent & DB::transaction):** Tombol 1-klik di dashboard admin yang mengeksekusi route `POST /auto-sale`, secara acak memilih koleksi heels yang sedang memiliki stok fisik, mencetak nomor faktur VIP (`MAI-VIP-XXXX`), memotong kuantitas stok secara atomik, dan langsung meng-update grafik analitik serta mutasi ledger secara instan.
2. **Quick VIP Checkout Modal:** Modal kasir cepat di navbar untuk memilih produk dan mencatat penjualan instan tanpa berpindah halaman.
3. **Interactive Visual Analytics (Chart.js):** Grafik tren mutasi restock vs penjualan 7 hari terakhir serta diagram distribusi siluet heels.

---

## 🔄 Pemetaan Migrasi P4 (Native) ke P5 (Laravel) — Sesuai Slide 35
| Fitur / Komponen | P4 (PHP Native) | P5 (Laravel Framework) |
|---|---|---|
| **Struktur Database** | `database/schema.sql` manual | `database/migrations/` (Version-controlled schema) |
| **Data Pengujian** | SQL INSERT manual | `database/seeders/DatabaseSeeder.php` (Koleksi Heels Mewah) |
| **Akses Database** | PDO Prepared Statements manual | **Eloquent ORM** & Query Builder dinamis |
| **CRUD Handler** | File `.php` terpisah di subfolder | **Resource Controllers** (`ProductController`, dll.) |
| **Routing** | File-based direct URL | Centralized Routes di `routes/web.php` (Named Routes) |
| **Templating UI** | `include 'header.php'` / `footer.php` | **Blade Layouts** (`@extends`, `@section`, `@yield`) & Components |
| **Form & Keamanan** | Validasi manual + escaping XSS | Form validation, `@csrf`, `@error`, dan auto escaping `{{ }}` |
| **Autentikasi** | `$_SESSION` & `password_verify` manual | Laravel Auth Guard, middleware `auth` & `guest` |
| **Business Logic** | PDO Transaction `beginTransaction()` | `DB::transaction()` & validasi integritas data |

---

## 🏛️ Arsitektur MVC & Alur Request (Slide 10–11)
```text
Request (Browser)
   │
   ▼
Route (routes/web.php)
   │
   ▼
Controller (app/Http/Controllers/ProductController.php / DashboardController.php)
   │
   ├── Validasi Form & Otorisasi ($request->validate())
   ├── Eksekusi DB::transaction() & Eloquent ORM (app/Models/Product.php)
   │       │
   │       ▼
   │   Database MySQL (inventory_db)
   │
   ▼
Response / View (resources/views/dashboard.blade.php / products/index.blade.php)
```

---

## 🚀 Fitur Utama & Kepatuhan PPT Web 5
1. **Resource Controller & Routing (Slide 12–18):**
   - Menggunakan `Route::resource('products', ProductController::class)`.
   - Menggunakan named routes (`route('products.index')`, `route('stock.out')`, `route('stock.autoSale')`, dll.).
2. **Eloquent Relationship (Slide 33–34):**
   - **One-to-One:** `User` hasOne `UserProfile` (`$user->profile`).
   - **One-to-Many:** `Category` hasMany `Product` (`$category->products`) dan `Product` belongsTo `Category` (`$product->category`).
   - **Many-to-Many:** `Product` belongsToMany `Supplier` via pivot table `product_suppliers` dengan eager loading `with(['category', 'suppliers'])`.
3. **Database Migrations & Seeders (Slide 26–30):**
   - 7 file migration terstruktur dengan foreign key constraint dan referential integrity (`restrictOnDelete`, `cascadeOnDelete`).
   - Seeder otomatis (`DatabaseSeeder`) dengan 12 heels ikonik dunia (Louboutin So Kate, Cesare Paciotti Blade, Manolo Blahnik Hangisi, Jimmy Choo Bing, Amina Muaddi Begum, Mach & Mach Double Bow), kategori siluet, maison partner, dan transaksi mutasi historis berjenjang.
4. **Transaksi Stok Atomik (Slide 24–25):**
   - **Restock Masuk (IN):** Penambahan kuantitas heels dengan proteksi `DB::transaction()`.
   - **Penjualan Keluar (OUT):** Pengecekan stok fisik terkini sebelum dipotong, mencegah stok negatif.
   - **Auto-Sales Bot (`POST /auto-sale`):** Simulasi transaksi instan bebas input manual untuk mendemonstrasikan perubahan data real-time.
5. **Dashboard & Analitik Visual (Slide 31 + Chart.js):**
   - 4 Kartu Metrik: Total Koleksi (`COUNT`), Valuasi Nilai Butik (`SUM(stock * price)`), Total Restock & Penjualan (`SUM(quantity)`), Alert Stok Kritis (`stock <= minimum_stock`).
   - Line chart pergerakan 7 hari terakhir (Restock vs Terjual).
   - Doughnut chart persebaran siluet heels (Stiletto, Bridal, Mules, Sculptural, Block).

---

## 📁 Struktur Folder (Sesuai Slide 36 PPT Web 5)
```text
mini_project_4/ (inventory-laravel)
├── app/
│   ├── Http/
│   │   ├── Controllers/      # DashboardController, ProductController, StockController, AuthController, dll.
│   │   └── Middleware/       # Authenticate, RedirectIfAuthenticated, CheckRole
│   └── Models/               # Product, Category, Supplier, StockMovement, User, UserProfile
├── config/                   # Konfigurasi app, database, session, auth
├── database/
│   ├── migrations/           # 7 file migrasi skema tabel relasional
│   └── seeders/              # DatabaseSeeder (koleksi heels, kategori, supplier, mutasi)
├── public/                   # Entry point index.php, assets, .htaccess
├── resources/
│   └── views/                # Blade layouts & template views (dashboard, products, stock, auth, dll.)
├── routes/
│   └── web.php               # Centralized named routes & auto-sale endpoint
├── storage/                  # Logs, framework cache, compiled views
├── .env.example & .env       # Konfigurasi environment (DB_DATABASE=inventory_db)
├── artisan                   # CLI tool Laravel
├── composer.json
├── index.php                 # Direct redirector ke public/ untuk kemudahan akses Apache
└── README.md
```

---

## 🛠️ Panduan Instalasi & Penggunaan

### 1. Prasyarat
- PHP versi 7.4 / 8.x
- Composer
- Web Server Apache & Database MySQL (via **XAMPP**)

### 2. Setup Database & Migrasi
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) atau MySQL CLI.
2. Buat database baru bernama `inventory_db`:
   ```sql
   CREATE DATABASE inventory_db;
   ```
3. Buka terminal di folder proyek (`mini_project_4`), lalu jalankan migrasi & seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Perintah ini akan membuat seluruh 7 tabel relasional dan mengisi data dummy koleksi heels ternama, akun admin & staff, serta riwayat mutasi).*

### 3. Menjalankan Aplikasi
Aplikasi dapat dibuka dengan dua cara:
1. **Via XAMPP / Apache:**
   - Buka browser di: **`http://localhost/mini_project_4/public/`**  
   - atau via alias folder: **`http://localhost/inventory-laravel/public/`**
2. **Via Built-in Server Artisan:**
   ```bash
   php artisan serve
   ```
   Buka di **`http://127.0.0.1:8000`**

---

## 🔑 Akun Login Pengujian (Default)
| Role | Username | Password | Hak Akses |
|---|---|---|---|
| **Admin** | `admin` | `password123` | Akses penuh (Koleksi, Siluet, Maison, Restock, VIP Checkout, Auto-Sales Bot) |
| **Staff** | `staff` | `password123` | Akses operasional (Katalog Koleksi, Restock, VIP Checkout, Riwayat Ledger) |
