# Mini Project 4 — InvenSync (Laravel Inventory Management System)
> **Mata Kuliah:** Pemrograman Web  
> **Pertemuan 5:** Laravel Fundamental (Refactoring & Migrasi P4 ke Laravel)  
> **Teknologi:** Laravel 8.x + MySQL + Blade Template Engine + Bootstrap 5  

---

## 📌 Deskripsi Proyek
**InvenSync (Mini Project 4)** adalah hasil transformasi dan refactoring sistem inventaris dari PHP Native (Pertemuan 4) menjadi aplikasi berbasis framework **Laravel**. Proyek ini menerapkan arsitektur **Model-View-Controller (MVC)**, Eloquent ORM, migrasi database version-controlled, seeder data uji, Blade templating, serta proteksi keamanan bawaan (CSRF protection, input validation, dan session management) tanpa menghilangkan aturan bisnis (*business rules*) persediaan barang yang telah dibangun pada P4.

---

## 🔄 Pemetaan Migrasi P4 (Native) ke P5 (Laravel) — Sesuai Slide 35
| Fitur / Komponen | P4 (PHP Native) | P5 (Laravel Framework) |
|---|---|---|
| **Struktur Database** | `database/schema.sql` manual | `database/migrations/` (Version-controlled schema) |
| **Data Pengujian** | SQL INSERT manual | `database/seeders/DatabaseSeeder.php` |
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
Controller (app/Http/Controllers/ProductController.php)
   │
   ├── Validasi Input ($request->validate())
   ├── Panggil Model & Eloquent ORM (app/Models/Product.php)
   │       │
   │       ▼
   │   Database MySQL (inventory_db)
   │
   ▼
Response / View (resources/views/products/index.blade.php)
```

---

## 🚀 Fitur Utama & Kepatuhan PPT Web 5
1. **Resource Controller & Routing (Slide 12–18):**
   - Menggunakan `Route::resource('products', ProductController::class)`.
   - Menggunakan named routes (`route('products.index')`, dll.) untuk mempermudah pemanggilan URL.
2. **Eloquent Relationship (Slide 33–34):**
   - **One-to-One:** `User` hasOne `UserProfile` (`$user->profile`).
   - **One-to-Many:** `Category` hasMany `Product` (`$category->products`) dan `Product` belongsTo `Category` (`$product->category`).
   - **Many-to-Many:** `Product` belongsToMany `Supplier` via pivot table `product_suppliers` dengan eager loading `with(['category', 'suppliers'])`.
3. **Database Migrations & Seeders (Slide 26–30):**
   - 7 file migration terstruktur dengan foreign key constraint dan referential integrity (`restrictOnDelete`, `cascadeOnDelete`).
   - Seeder otomatis (`DatabaseSeeder`) untuk pengguna (admin & staff), kategori, supplier, produk, relasi junction, dan histori transaksi.
4. **Katalog Produk Canggih (Slide 32 & 38):**
   - Pencarian berdasarkan Nama Produk atau SKU.
   - Filter berdasarkan Kategori.
   - Sorting multi-kolom (`name`, `sku`, `price`, `stock`, `created_at`).
   - Pagination 5 item per halaman dengan mempertahankan query parameter (`->withQueryString()`).
5. **Transaksi Mutasi Stok (Slide 25–26):**
   - Barang Masuk (IN): Menambah stok dan mencatat riwayat transaksi.
   - Barang Keluar (OUT): Mengurangi stok dengan proteksi anti-minus (`DB::transaction`).
   - Riwayat mutasi lengkap dengan filter tipe mutasi (IN / OUT).
6. **Blade Layouts & Form Validation (Slide 21–25):**
   - Menggunakan `@extends('layouts.app')` dan component alert `<x-alert>`.
   - Proteksi `@csrf` di setiap form POST/PUT/DELETE.
   - Menampilkan feedback error validasi dengan `@error` dan mempertahankan isian dengan `old()`.

---

## 📁 Struktur Folder Project (Sesuai Slide 36)
```text
mini_project_4/ (inventory-laravel)
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php        # Otentikasi login & logout
│   │       ├── DashboardController.php   # Agregasi widget & analitik
│   │       ├── ProductController.php     # Resource controller katalog produk
│   │       ├── CategoryController.php    # Resource controller master kategori
│   │       ├── SupplierController.php    # Resource controller master supplier
│   │       └── StockController.php       # Transaksi barang masuk & keluar
│   └── Models/
│       ├── User.php                      # Model user & relasi
│       ├── UserProfile.php               # One-to-one profile user
│       ├── Category.php                  # One-to-many kategori
│       ├── Product.php                   # Model produk & relasi
│       ├── Supplier.php                  # Model supplier
│       └── StockMovement.php             # Model histori mutasi stok
├── database/
│   ├── migrations/                       # 7 migration database
│   └── seeders/
│       └── DatabaseSeeder.php            # Seed data lengkap
├── resources/
│   └── views/
│       ├── auth/login.blade.php          # Tampilan login
│       ├── categories/                   # View CRUD kategori
│       ├── products/                     # View CRUD & listing produk
│       ├── stock/                        # View transaksi in/out & history
│       ├── suppliers/                    # View CRUD supplier
│       ├── components/alert.blade.php    # Blade reusable component
│       ├── layouts/app.blade.php         # Master Blade layout & navigation
│       └── dashboard.blade.php           # Tampilan dashboard
├── routes/
│   └── web.php                           # Definisi seluruh rute aplikasi
├── .env.example                          # Contoh variabel lingkungan
├── .env                                  # Konfigurasi database & environment lokal
├── artisan                               # Laravel Artisan CLI
├── composer.json                         # Dependensi PHP
├── index.php                             # Root redirection ke folder public/
├── .gitignore
└── README.md
```

---

## 🛠️ Panduan Instalasi & Menjalankan

### 1. Prasyarat
- PHP >= 7.3 / 8.x
- Composer
- MySQL Server (XAMPP)

### 2. Konfigurasi Environment
Pastikan file `.env` sudah ada dan dikonfigurasi ke database `inventory_db`:
```ini
APP_NAME="InvenSync Laravel"
APP_ENV=local
APP_KEY=base64:EOZ8bvkeBFoOkfT+W8vHmUlqTW63oCNLrl2zx/LfPbw=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seed Database
Buka terminal di folder project `mini_project_4`, jalankan perintah berikut:
```bash
# Buat database inventory_db jika belum ada di MySQL
# Jalankan migrasi dan seeder awal:
php artisan migrate:fresh --seed
```

### 4. Menjalankan Aplikasi
Aplikasi dapat dijalankan melalui salah satu cara berikut:

**Opsi A (Menggunakan Artisan Serve):**
```bash
php artisan serve
```
Buka browser di: **`http://127.0.0.1:8000`**

**Opsi B (Menggunakan XAMPP Apache):**
Pastikan Apache & MySQL aktif di XAMPP Control Panel, lalu buka:
- **`http://localhost/mini_project_4/public/`**
- atau via alias: **`http://localhost/inventory-laravel/public/`**

---

## 🔑 Akun Login Pengujian (Default)
| Role | Username | Password | Keterangan |
|---|---|---|---|
| **Admin** | `admin` | `password123` | Akses penuh seluruh master data & mutasi stok |
| **Staff** | `staff` | `password123` | Akses operasional katalog produk & pencatatan stok |
