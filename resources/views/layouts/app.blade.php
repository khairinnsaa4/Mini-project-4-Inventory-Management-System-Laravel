<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Maison Sole Atelier</title>
    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart.js for Executive Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --rouge-primary: #8B1538;
            --rouge-hover: #720E2C;
            --rouge-light: #FDF2F4;
            --gold-accent: #C5A059;
            --gold-light: #FAF4E8;
            --obsidian: #18181B;
            --charcoal: #27272A;
            --bg-lux: #FBF9F7;
            --card-border: #EFE7E2;
            --text-heading: #1C1917;
            --text-body: #44403C;
            --text-muted: #78716C;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-lux);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            letter-spacing: -0.01em;
            margin: 0;
        }

        h1, h2, h3, h4, h5, .font-serif, .navbar-brand-title {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Navbar Layout */
        .navbar-main {
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 2px 14px rgba(28, 25, 23, 0.03);
            padding: 0.75rem 0;
        }

        .brand-badge {
            background: linear-gradient(135deg, var(--rouge-primary), #B31B47);
            color: #FFFFFF;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(139, 21, 56, 0.2);
        }

        .navbar-brand-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-heading);
            letter-spacing: -0.01em;
            line-height: 1.1;
        }

        .navbar-brand-sub {
            font-size: 0.65rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.88rem;
            color: #57534E !important;
            padding: 0.5rem 0.85rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-link:hover {
            color: var(--rouge-primary) !important;
            background-color: var(--rouge-light);
        }

        .nav-link.active {
            color: var(--rouge-primary) !important;
            background-color: var(--rouge-light);
            font-weight: 600;
        }

        /* Luxury Cards & Elements */
        .card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(28, 25, 23, 0.02);
            transition: box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 6px 18px rgba(139, 21, 56, 0.05);
        }

        .card-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            padding: 1.1rem 1.4rem;
            font-weight: 600;
            color: var(--text-heading);
        }

        /* Custom Table */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: #FAF6F3;
            color: #78716C;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            border-bottom: 1px solid var(--card-border);
            padding: 0.85rem 1.1rem;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 0.9rem 1.1rem;
            border-bottom: 1px solid #F5EFEB;
            vertical-align: middle;
            font-size: 0.88rem;
        }

        .table-custom tbody tr:hover {
            background-color: #FDFBF9;
        }

        /* Buttons Styling */
        .btn-primary {
            background-color: var(--rouge-primary);
            border-color: var(--rouge-primary);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.55rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--rouge-hover);
            border-color: var(--rouge-hover);
            box-shadow: 0 4px 12px rgba(139, 21, 56, 0.25);
            color: #FFFFFF;
        }

        .btn-gold {
            background: linear-gradient(135deg, #C5A059, #DFBD78);
            border: none;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5rem 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #B58F47, #CFA863);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(197, 160, 89, 0.3);
        }

        .btn-outline-primary {
            color: var(--rouge-primary);
            border-color: var(--rouge-primary);
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--rouge-primary);
            border-color: var(--rouge-primary);
            color: #FFFFFF;
        }

        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            padding: 2rem 1.25rem;
            flex: 1;
        }

        .stat-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .dropdown-menu {
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            padding: 0.4rem;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: var(--rouge-light);
            color: var(--rouge-primary);
        }
    </style>
</head>
<body>

@auth
<nav class="navbar navbar-expand-lg navbar-main sticky-top">
    <div class="container-fluid px-3" style="max-width: 1280px;">
        <!-- Logo & Brand Name -->
        <a class="navbar-brand d-flex align-items-center gap-2 me-3" href="{{ route('dashboard') }}">
            <span class="brand-badge">
                <i class="bi bi-gem"></i>
            </span>
            <span class="d-flex flex-column">
                <span class="navbar-brand-title">Maison Sole</span>
                <span class="navbar-brand-sub">Haute Heels Atelier</span>
            </span>
        </a>

        <!-- Responsive Hamburger Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-2 gap-1">
                @if(Auth::user()->role === 'admin')
                    <!-- MENU KHUSUS ADMIN (FULL MASTER DATA MANAGEMENT) -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-handbag"></i> Koleksi Heels
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i> Kategori Siluet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                            <i class="bi bi-buildings"></i> Maison & Pemasok
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('stock.*') ? 'active' : '' }}" href="#" id="adminStockDrop" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-arrow-left-right"></i> Mutasi Stok
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('stock.in') }}"><i class="bi bi-box-arrow-in-down text-success me-2"></i> Restock Butik (IN)</a></li>
                            <li><a class="dropdown-item" href="{{ route('stock.out') }}"><i class="bi bi-bag-check text-danger me-2"></i> Penjualan Heels (OUT)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('stock.history') }}"><i class="bi bi-journal-text text-secondary me-2"></i> Buku Besar Mutasi</a></li>
                        </ul>
                    </li>
                @else
                    <!-- MENU KHUSUS STAFF (OPERASIONAL KASIR & FRONT-DESK) -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard Kasir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-search"></i> Katalog Koleksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stock.out') ? 'active' : '' }}" href="{{ route('stock.out') }}">
                            <i class="bi bi-bag-check text-danger"></i> Kasir Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stock.in') ? 'active' : '' }}" href="{{ route('stock.in') }}">
                            <i class="bi bi-box-arrow-in-down text-success"></i> Restock Butik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stock.history') ? 'active' : '' }}" href="{{ route('stock.history') }}">
                            <i class="bi bi-journal-text"></i> Riwayat Kasir
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Tombol Aksi Kanan & Profile Pill -->
            <div class="d-flex align-items-center gap-2">
                <!-- Tombol Kasir Cepat (Quick VIP Checkout Modal) -->
                <button type="button" class="btn btn-sm btn-gold d-flex align-items-center gap-1 shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#quickSaleModal">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>Kasir Cepat</span>
                </button>

                <!-- Profile Info Pill -->
                <div class="d-flex align-items-center gap-2 ps-2 border-start ms-1">
                    <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; font-weight: 700; font-size: 0.85rem; border: 1px solid var(--card-border);">
                        {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
                    </div>
                    <div class="d-none d-sm-block lh-1 text-start">
                        <div class="fw-semibold text-dark small mb-1">{{ Auth::user()->profile->full_name ?? Auth::user()->name ?? Auth::user()->username }}</div>
                        @if(Auth::user()->role === 'admin')
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle py-1" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">
                                <i class="bi bi-shield-lock-fill me-1"></i>ADMIN
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle py-1" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">
                                <i class="bi bi-person-badge-fill me-1"></i>STAFF KASIR
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Logout Form Button -->
                <form method="POST" action="{{ route('logout') }}" class="d-inline ms-1">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm px-2 py-1 rounded-2" title="Keluar Sesi" onclick="return confirm('Keluar dari sistem Maison Sole?')">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Modal Kasir Cepat (Real-time Quick Checkout VIP) -->
<div class="modal fade" id="quickSaleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white p-3" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bag-heart-fill text-danger fs-5"></i>
                    <h6 class="modal-title mb-0 font-serif">Kasir Cepat VIP (Penjualan Instan)</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('stock.storeOut') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Pilih koleksi heels yang dibeli pelanggan VIP. Stok akan langsung terpotong secara atomik.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilih Koleksi Heels</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih Model Heels Berstok --</option>
                            @php
                                $modalItems = \App\Models\Product::where('stock', '>', 0)->orderBy('name')->get();
                            @endphp
                            @foreach($modalItems as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }} (Sisa: {{ $item->stock }} psg) - Rp {{ number_format($item->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Jumlah (Pasang)</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-8">
                            <label class="form-label small fw-semibold">Catatan / Faktur VIP</label>
                            <input type="text" name="notes" class="form-control" value="Penjualan VIP Butik - Faktur #MAI-{{ date('md') . rand(10,99) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-check2-circle me-1"></i> Konfirmasi Terjual
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<main class="main-container">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4 rounded-3" role="alert" style="background-color: #ECFDF5; color: #065F46;">
            <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4 rounded-3" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-white border-top py-3 mt-auto text-center text-muted small" style="border-color: #EFE7E2 !important; font-size: 0.78rem;">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
        <span>&copy; {{ date('Y') }} <strong class="text-dark">Maison Sole</strong> — Haute Couture Heels Boutique. All rights reserved.</span>
        <span class="text-secondary">Sistem Manajemen Persediaan &bull; Mini Project 4 (Laravel Edition)</span>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
