<?php $__env->startSection('title', 'Data Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Data Produk</h5>
    <?php if(Auth::user()->role === 'admin'): ?>
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    <?php endif; ?>
</div>

<!-- Filter & Search Bar -->
<div class="card p-3 mb-3">
    <form method="GET" action="<?php echo e(route('products.index')); ?>" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau SKU..." value="<?php echo e(request('search')); ?>">
        </div>

        <div class="col-md-3">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e((string)request('category_id') === (string)$c->id ? 'selected' : ''); ?>>
                        <?php echo e($c->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-md-3">
            <div class="input-group input-group-sm">
                <select name="sort" class="form-select">
                    <option value="name" <?php echo e($sortBy === 'name' ? 'selected' : ''); ?>>Urut: Nama</option>
                    <option value="sku" <?php echo e($sortBy === 'sku' ? 'selected' : ''); ?>>Urut: SKU</option>
                    <option value="price" <?php echo e($sortBy === 'price' ? 'selected' : ''); ?>>Urut: Harga</option>
                    <option value="stock" <?php echo e($sortBy === 'stock' ? 'selected' : ''); ?>>Urut: Stok</option>
                </select>
                <select name="order" class="form-select" style="max-width: 80px;">
                    <option value="asc" <?php echo e($order === 'asc' ? 'selected' : ''); ?>>ASC</option>
                    <option value="desc" <?php echo e($order === 'desc' ? 'selected' : ''); ?>>DESC</option>
                </select>
            </div>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                Filter
            </button>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm" title="Reset">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Tabel Data Produk -->
<div class="card overflow-hidden mb-3">
    <div class="table-responsive">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode SKU</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th class="text-end">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                    <th class="text-end" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($loop->iteration + ($products->currentPage() - 1) * $products->perPage()); ?></td>
                        <td>
                            <span class="font-monospace text-dark" style="font-size: 0.8rem;"><?php echo e($product->sku); ?></span>
                        </td>
                        <td>
                            <div class="fw-medium text-dark"><?php echo e($product->name); ?></div>
                        </td>
                        <td>
                            <span class="badge text-bg-light border"><?php echo e($product->category->name); ?></span>
                        </td>
                        <td>
                            <?php if($product->suppliers->isNotEmpty()): ?>
                                <span class="small text-muted"><?php echo e($product->suppliers->pluck('name')->join(', ')); ?></span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end text-dark">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
                        <td class="text-center fw-semibold <?php echo e($product->stock <= $product->minimum_stock ? 'text-danger' : 'text-dark'); ?>">
                            <?php echo e($product->stock); ?>

                        </td>
                        <td class="text-center">
                            <?php if($product->stock <= 0): ?>
                                <span class="badge bg-danger-subtle text-danger">Habis</span>
                            <?php elseif($product->stock <= $product->minimum_stock): ?>
                                <span class="badge bg-warning-subtle text-warning">Menipis</span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success">Aman</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('stock.in', ['product_id' => $product->id])); ?>" class="btn btn-light border" title="Tambah Stok">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <?php if(Auth::user()->role === 'admin'): ?>
                                    <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-light border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-light border text-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            Tidak ditemukan produk.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($products->hasPages()): ?>
        <div class="card-footer bg-white py-2 px-3 border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">Total <?php echo e($products->total()); ?> produk</small>
            <div>
                <?php echo e($products->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/products/index.blade.php ENDPATH**/ ?>