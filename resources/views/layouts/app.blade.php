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
            --bg-lux: #FAF7F5;
            --card-border: #EFE7E2;
            --text-heading: #141416;
            --text-body: #44403C;
            --text-muted: #78716C;
        }

        body {
            background-color: var(--bg-lux);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, .font-serif, .navbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Navbar Luxury Atelier */
        .navbar-main {
            background-color: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 2px 16px rgba(139, 21, 56, 0.04);
            padding: 0.85rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--obsidian) !important;
            letter-spacing: 0.02em;
        }

        .brand-badge {
            background: linear-gradient(135deg, var(--rouge-primary), #B31B47);
            color: #FFFFFF;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(139, 21, 56, 0.25);
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.88rem;
            color: var(--text-muted) !important;
            padding: 0.45rem 0.85rem !important;
            border-radius: 6px;
            transition: all 0.2s ease;
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

        /* Luxury Cards */
        .card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(139, 21, 56, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 6px 20px rgba(139, 21, 56, 0.06);
        }

        .card-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            padding: 1rem 1.35rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--obsidian);
        }

        /* Custom Table */
        .table-custom thead th {
            background-color: #FBF8F6;
            color: var(--text-muted);
            font-size: 0.73rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            border-bottom: 1px solid var(--card-border);
            padding: 0.85rem 1rem;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #F5EFEB;
            vertical-align: middle;
            font-size: 0.88rem;
        }

        .table-custom tbody tr:hover {
            background-color: #FDFAF9;
        }

        /* Buttons Luxury Styling */
        .btn-primary {
            background-color: var(--rouge-primary);
            border-color: var(--rouge-primary);
            color: #FFFFFF;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--rouge-hover);
            border-color: var(--rouge-hover);
            box-shadow: 0 4px 12px rgba(139, 21, 56, 0.25);
        }

        .btn-gold {
            background: linear-gradient(135deg, #C5A059, #DFBD78);
            border: none;
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
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
        }

        .btn-outline-primary:hover {
            background-color: var(--rouge-primary);
            color: #FFFFFF;
        }

        .badge-luxury {
            background-color: var(--rouge-light);
            color: var(--rouge-primary);
            border: 1px solid rgba(139, 21, 56, 0.15);
            font-weight: 600;
            font-size: 0.72rem;
            letter-spacing: 0.4px;
        }

        .badge-gold {
            background-color: var(--gold-light);
            color: #8C6D2B;
            border: 1px solid rgba(197, 160, 89, 0.25);
            font-weight: 600;
            font-size: 0.72rem;
        }

        .main-container {
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
            padding: 1.75rem 1.25rem;
            flex: 1;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .dropdown-menu {
            border: 1px solid var(--card-border);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            padding: 0.4rem;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.5rem 0.85rem;
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
    <div class="container-fluid px-3" style="max-width: 1300px;">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <span class="d-inline-flex align-items-center justify-content-center brand-badge">
                <i class="bi bi-gem fs-6"></i>
            </span>
            <span class="d-flex flex-column lh-1">
                <span class="fw-bold tracking-tight">Maison Sole</span>
                <span class="text-muted fw-normal" style="font-size: 0.65rem; font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: 1px; text-transform: uppercase;">Haute Heels Atelier (Laravel)</span>
            </span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-handbag me-1"></i> Koleksi Heels
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags me-1"></i> Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                        <i class="bi bi-buildings me-1"></i> Maison / Supplier
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('stock.*') ? 'active' : '' }}" href="#" id="stockDrop" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-arrow-left-right me-1"></i> Mutasi Stok
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('stock.in') }}"><i class="bi bi-box-arrow-in-down text-success me-2"></i> Restock Butik (IN)</a></li>
                        <li><a class="dropdown-item" href="{{ route('stock.out') }}"><i class="bi bi-bag-check text-danger me-2"></i> Penjualan Heels (OUT)</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('stock.history') }}"><i class="bi bi-journal-text text-secondary me-2"></i> Buku Besar Mutasi</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <!-- Tombol Kasir Cepat (Modal Quick Sell) -->
                <button type="button" class="btn btn-sm btn-gold d-flex align-items-center gap-1 shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#quickSaleModalLaravel">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>Kasir Cepat</span>
                </button>

                <div class="d-flex align-items-center gap-2 ps-2 border-start">
                    <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; font-weight: 600; font-size: 0.8rem; border: 1px solid var(--card-border);">
                        {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
                    </div>
                    <div class="small lh-sm d-none d-sm-block">
                        <div class="fw-semibold text-dark">{{ Auth::user()->profile->full_name ?? Auth::user()->name ?? Auth::user()->username }}</div>
                        <span class="badge badge-luxury text-uppercase">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm px-2 py-1 rounded-2" title="Keluar Sesi" onclick="return confirm('Keluar dari sistem Maison Sole?')">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Modal Kasir Cepat (Real-time Automatic Sales Checkout) -->
<div class="modal fade" id="quickSaleModalLaravel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white p-3" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bag-heart-fill text-danger fs-5"></i>
                    <h6 class="modal-title mb-0 font-serif">Kasir Cepat VIP (Auto-Sales)</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('stock.storeOut') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Catat penjualan heels secara instan. Stok akan otomatis berkurang dan histori mutasi tercatat langsung di database.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilih Koleksi Heels</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih Model Heels Tersedia --</option>
                            @php
                                $modalProducts = \App\Models\Product::where('stock', '>', 0)->orderBy('name')->get();
                            @endphp
                            @foreach($modalProducts as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Sisa: {{ $item->stock }} pasang) - Rp {{ number_format($item->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Jumlah (Pasang)</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-8">
                            <label class="form-label small fw-semibold">Catatan / No. Faktur</label>
                            <input type="text" name="notes" class="form-control" value="Penjualan Butik - Faktur #MAI-{{ date('md') . rand(10,99) }}">
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

<footer class="mt-auto py-3 bg-white border-top text-center text-muted small" style="border-color: var(--card-border) !important;">
    <div class="container">
        <span class="font-serif fw-bold text-dark">Maison Sole Atelier</span> &copy; {{ date('Y') }} &bull; Haute Luxury Footwear Inventory Suite
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
