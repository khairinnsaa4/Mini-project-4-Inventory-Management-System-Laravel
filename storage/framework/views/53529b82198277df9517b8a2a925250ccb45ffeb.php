<?php $__env->startSection('title', 'Riwayat Mutasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Riwayat Mutasi</h5>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('stock.in')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Stok Masuk
        </a>
        <a href="<?php echo e(route('stock.out')); ?>" class="btn btn-outline-secondary btn-sm">
            Stok Keluar
        </a>
    </div>
</div>

<!-- Filter Tipe Mutasi -->
<div class="card p-3 mb-3">
    <div class="d-flex align-items-center gap-2">
        <span class="small text-muted me-1">Filter:</span>
        <a href="<?php echo e(route('stock.history')); ?>" class="btn btn-sm <?php echo e(empty($type) ? 'btn-secondary' : 'btn-light border'); ?>">
            Semua
        </a>
        <a href="<?php echo e(route('stock.history', ['type' => 'IN'])); ?>" class="btn btn-sm <?php echo e($type === 'IN' ? 'btn-success' : 'btn-light border'); ?>">
            Masuk
        </a>
        <a href="<?php echo e(route('stock.history', ['type' => 'OUT'])); ?>" class="btn btn-sm <?php echo e($type === 'OUT' ? 'btn-danger' : 'btn-light border'); ?>">
            Keluar
        </a>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Waktu</th>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Qty</th>
                    <th>Catatan</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($loop->iteration + ($movements->currentPage() - 1) * $movements->perPage()); ?></td>
                        <td class="small text-muted font-monospace">
                            <?php echo e($m->created_at->format('d/m/Y H:i')); ?>

                        </td>
                        <td><span class="badge text-bg-light border font-monospace"><?php echo e($m->product->sku); ?></span></td>
                        <td class="fw-medium text-dark"><?php echo e($m->product->name); ?></td>
                        <td class="text-center">
                            <span class="badge <?php echo e($m->type === 'IN' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'); ?> border-0">
                                <?php echo e($m->type); ?>

                            </span>
                        </td>
                        <td class="text-center fw-semibold <?php echo e($m->type === 'IN' ? 'text-success' : 'text-danger'); ?>">
                            <?php echo e($m->type === 'IN' ? '+' : '-'); ?><?php echo e($m->quantity); ?>

                        </td>
                        <td class="small text-muted"><?php echo e($m->notes ?: '-'); ?></td>
                        <td class="small text-muted">&#64;<?php echo e($m->user->username); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat pergerakan stok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($movements->hasPages()): ?>
        <div class="card-footer bg-white py-2 px-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Total <?php echo e($movements->total()); ?> transaksi</small>
            <div>
                <?php echo e($movements->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/stock/history.blade.php ENDPATH**/ ?>