<form method="POST" <?php if(isset($action)): ?> action="<?php echo e($action); ?>" <?php endif; ?>>
    <?php echo csrf_field(); ?>
    <?php echo method_field($method); ?>

    <button type="submit" <?php echo e($attributes); ?>>
        <?php echo e($slot); ?>

    </button>
</form>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\buttons\form-button.blade.php ENDPATH**/ ?>