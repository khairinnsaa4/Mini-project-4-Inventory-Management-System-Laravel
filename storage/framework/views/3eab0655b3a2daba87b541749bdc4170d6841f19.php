<?php $__env->startSection('title', 'Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Kategori Produk</h5>
    <?php if(Auth::user()->role === 'admin'): ?>
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    <?php endif; ?>
</div>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Jumlah Item</th>
                    <th class="text-center">Total Stok</th>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <th class="text-end" style="width: 100px;">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <span class="fw-medium text-dark"><?php echo e($cat->name); ?></span>
                        </td>
                        <td class="text-muted small"><?php echo e($cat->description ?: '-'); ?></td>
                        <td class="text-center">
                            <span class="badge text-bg-light border"><?php echo e($cat->products_count); ?></span>
                        </td>
                        <td class="text-center"><?php echo e($cat->total_stock ?? 0); ?></td>
                        <?php if(Auth::user()->role === 'admin'): ?>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo e(route('categories.edit', $cat)); ?>" class="btn btn-light border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('categories.destroy', $cat)); ?>" class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-light border text-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/categories/index.blade.php ENDPATH**/ ?>