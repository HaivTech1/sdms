<?php if($human): ?>

<span title="<?php echo e($schedule); ?>" <?php echo e($attributes); ?>>
    <?php echo e($translate); ?>

</span>

<?php else: ?>

<span title="<?php echo e($translate); ?>" <?php echo e($attributes); ?>>
    <?php echo e($schedule); ?>

</span>

<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\support\cron.blade.php ENDPATH**/ ?>