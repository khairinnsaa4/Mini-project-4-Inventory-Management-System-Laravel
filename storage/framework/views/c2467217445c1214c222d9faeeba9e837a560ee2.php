<?php $attributes = $attributes->exceptProps(['type' => 'info']); ?>
<?php foreach (array_filter((['type' => 'info']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'alert alert-' . $type . ' alert-dismissible fade show small d-flex align-items-center'])); ?> role="alert">
    <div>
        <?php echo e($slot); ?>

    </div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php /**PATH C:\xampp2\htdocs\tugas_inventory\web5_laravel\resources\views/components/alert.blade.php ENDPATH**/ ?>