<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - InvenSync</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-body: #f8fafc;
            --border-color: #e2e8f0;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Clean Modern */
        .navbar-main {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            padding: 0.65rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--text-heading) !important;
            letter-spacing: -0.3px;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-muted) !important;
            padding: 0.45rem 0.75rem !important;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .nav-link:hover {
            color: var(--text-heading) !important;
            background-color: #f1f5f9;
        }

        .nav-link.active {
            color: var(--primary) !important;
            background-color: #eff6ff;
            font-weight: 600;
        }

        /* Standard Cards */
        .card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-heading);
        }

        /* Standard Table */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            padding: 1.5rem 1rem;
            flex: 1;
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            padding: 0.35rem;
            font-size: 0.875rem;
        }

        .dropdown-item {
            border-radius: 5px;
            padding: 0.5rem 0.75rem;
            color: var(--text-body);
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--text-heading);
        }

        .form-label {
            font-size: 0.825rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.35rem;
        }

        .form-control, .form-select {
            font-size: 0.875rem;
            border-color: #cbd5e1;
            border-radius: 6px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
    </style>
</head>
<body>

<?php if(auth()->guard()->check()): ?>
<nav class="navbar navbar-expand-lg navbar-main sticky-top">
    <div class="container-fluid px-3" style="max-width: 1280px;">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('dashboard')); ?>">
            <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-2" style="width: 28px; height: 28px;">
                <i class="bi bi-box-seam fs-6"></i>
            </span>
            <span>InvenSync</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>" href="<?php echo e(route('products.index')); ?>">
                        Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('categories.index')); ?>">
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('suppliers.*') ? 'active' : ''); ?>" href="<?php echo e(route('suppliers.index')); ?>">
                        Supplier
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('stock.*') ? 'active' : ''); ?>" href="#" id="stockDrop" role="button" data-bs-toggle="dropdown">
                        Mutasi Stok
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('stock.in')); ?>"><i class="bi bi-arrow-down-left text-success me-2"></i> Barang Masuk</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('stock.out')); ?>"><i class="bi bi-arrow-up-right text-danger me-2"></i> Barang Keluar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('stock.history')); ?>"><i class="bi bi-clock-history text-secondary me-2"></i> Riwayat Mutasi</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 600; font-size: 0.8rem;">
                        <?php echo e(strtoupper(substr(Auth::user()->username ?? 'U', 0, 1))); ?>

                    </div>
                    <div class="small">
                        <span class="fw-semibold text-dark"><?php echo e(Auth::user()->profile->full_name ?? Auth::user()->name ?? Auth::user()->username); ?></span>
                        <span class="badge text-bg-light border text-uppercase ms-1" style="font-size: 0.65rem;">
                            <?php echo e(Auth::user()->role); ?>

                        </span>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-secondary btn-sm px-2 py-1" title="Logout" onclick="return confirm('Keluar dari sistem?')">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="main-container">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show small d-flex align-items-center mb-3 rounded-2" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <div><?php echo e(session('success')); ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show small d-flex align-items-center mb-3 rounded-2" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <div><?php echo e(session('error')); ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
    <div class="container">
        <span>&copy; <?php echo e(date('Y')); ?> InvenSync. All rights reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>