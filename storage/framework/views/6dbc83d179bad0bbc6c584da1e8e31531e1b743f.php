<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Dashboard</h5>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('stock.in')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Stok Masuk
        </a>
        <a href="<?php echo e(route('stock.out')); ?>" class="btn btn-outline-secondary btn-sm">
            Stok Keluar
        </a>
    </div>
</div>

<!-- 4 Kartu Metrik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Total Produk</span>
                <i class="bi bi-box text-primary"></i>
            </div>
            <div class="fs-4 fw-bold text-dark"><?php echo e(number_format($total_produk)); ?></div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Nilai Aset</span>
                <i class="bi bi-wallet2 text-success"></i>
            </div>
            <div class="fs-4 fw-bold text-dark">Rp <?php echo e(number_format($total_nilai, 0, ',', '.')); ?></div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Stok Menipis</span>
                <i class="bi bi-exclamation-triangle text-warning"></i>
            </div>
            <div class="fs-4 fw-bold <?php echo e($total_low_stock > 0 ? 'text-warning' : 'text-dark'); ?>">
                <?php echo e(number_format($total_low_stock)); ?>

            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small fw-medium text-uppercase">Total Mutasi</span>
                <i class="bi bi-arrow-left-right text-secondary"></i>
            </div>
            <div class="fs-4 fw-bold text-dark d-flex gap-3">
                <span class="text-success small fw-semibold">+<?php echo e(number_format($total_in)); ?></span>
                <span class="text-danger small fw-semibold">-<?php echo e(number_format($total_out)); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Peringatan Stok Menipis -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Stok Perlu Perhatian</span>
                <span class="badge text-bg-light border"><?php echo e($low_stock_products->count()); ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th class="text-center">Sisa</th>
                            <th class="text-center">Min</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $low_stock_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="fw-medium text-dark"><?php echo e($prod->name); ?></div>
                                    <span class="text-muted small font-monospace"><?php echo e($prod->sku); ?></span>
                                </td>
                                <td><span class="badge text-bg-light border"><?php echo e($prod->category->name); ?></span></td>
                                <td class="text-center">
                                    <span class="badge bg-danger-subtle text-danger border-0 fw-semibold">
                                        <?php echo e($prod->stock); ?>

                                    </span>
                                </td>
                                <td class="text-center text-muted small"><?php echo e($prod->minimum_stock); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('stock.in', ['product_id' => $prod->id])); ?>" class="btn btn-light btn-sm border py-0 px-2" style="font-size: 0.8rem;">
                                        Restock
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    Semua stok dalam kondisi aman.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Mutasi Terakhir -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Aktivitas Mutasi Terkini</span>
                <a href="<?php echo e(route('stock.history')); ?>" class="small text-decoration-none">
                    Semua &rarr;
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th class="text-center">Qty</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recent_movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="small text-muted font-monospace">
                                    <?php echo e($m->created_at->format('d/m H:i')); ?>

                                </td>
                                <td>
                                    <div class="fw-medium text-dark text-truncate" style="max-width: 160px;"><?php echo e($m->product->name); ?></div>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($m->type === 'IN' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'); ?> border-0">
                                        <?php echo e($m->type); ?>

                                    </span>
                                </td>
                                <td class="text-center fw-semibold <?php echo e($m->type === 'IN' ? 'text-success' : 'text-danger'); ?>">
                                    <?php echo e($m->type === 'IN' ? '+' : '-'); ?><?php echo e($m->quantity); ?>

                                </td>
                                <td class="small text-muted">{{ $m->user->username }}</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\mini_project_4\resources\views/dashboard.blade.php ENDPATH**/ ?>