<?php $__env->startSection('title', 'Data Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Supplier</h5>
    <?php if(Auth::user()->role === 'admin'): ?>
        <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Supplier
        </a>
    <?php endif; ?>
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th class="text-center">Produk</th>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <th class="text-end" style="width: 80px;">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <span class="fw-medium text-dark"><?php echo e($s->name); ?></span>
                        </td>
                        <td><?php echo e($s->contact_person ?: '-'); ?></td>
                        <td><span class="font-monospace small text-dark"><?php echo e($s->phone ?: '-'); ?></span></td>
                        <td class="small text-muted text-truncate" style="max-width: 240px;">
                            <?php echo e($s->address ?: '-'); ?>

                        </td>
                        <td class="text-center">
                            <span class="badge text-bg-light border"><?php echo e($s->products_count); ?></span>
                        </td>
                        <?php if(Auth::user()->role === 'admin'): ?>
                            <td class="text-end">
                                <a href="<?php echo e(route('suppliers.edit', $s)); ?>" class="btn btn-light btn-sm border" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data supplier.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/suppliers/index.blade.php ENDPATH**/ ?>