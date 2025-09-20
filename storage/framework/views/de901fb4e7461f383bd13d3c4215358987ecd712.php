<?php if($exists()): ?>
    <div role="alert" <?php echo e($attributes); ?>>
        <?php if($slot->isEmpty()): ?>
            <?php echo e($message()); ?>

        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\alerts\alert.blade.php ENDPATH**/ ?>