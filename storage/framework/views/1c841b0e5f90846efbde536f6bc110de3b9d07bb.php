<div class="col-md-4">
    <div class="card mini-stats-wid">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <p class="text-muted fw-medium"><?php echo e($title); ?></p>
                    <h4 class="mb-0"> <?php echo e(trans('global.naira')); ?>  <?php echo e(number_format(intval($amount), 2)); ?></h4>
                </div>

                <div class="flex-shrink-0 align-self-center">
                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                        <span class="avatar-title">
                            <i class="<?php echo e($iconClass); ?> font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $attributes = $attributes->exceptProps(['title', 'amount', 'iconClass']); ?>
<?php foreach (array_filter((['title', 'amount', 'iconClass']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?><?php /**PATH C:\laragon\www\primary\resources\views\components\card\slot.blade.php ENDPATH**/ ?>