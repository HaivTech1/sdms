<form method="<?php echo e($method !== 'GET' ? 'POST' : 'GET'); ?>" <?php if(isset($action)): ?> action="<?php echo e($action); ?>" <?php endif; ?> <?php echo $hasFiles ? 'enctype="multipart/form-data"' : ''; ?> <?php echo e($attributes); ?>>
    <?php echo csrf_field(); ?>
    <?php echo method_field($method); ?>

    <?php echo e($slot); ?>

</form>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\forms\form.blade.php ENDPATH**/ ?>