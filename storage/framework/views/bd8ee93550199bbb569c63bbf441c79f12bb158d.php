<textarea
    x-data
    x-init="new EasyMDE({ element: $el <?php echo e($jsonOptions()); ?> })"
    name="<?php echo e($name); ?>"
    id="<?php echo e($id); ?>"
    <?php echo e($attributes); ?>

><?php echo e(old($name, $slot)); ?></textarea>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\editors\easy-mde.blade.php ENDPATH**/ ?>