<input
    x-data
    x-init="new Pikaday({ field: $el <?php echo e($jsonOptions()); ?> })"
    name="<?php echo e($name); ?>"
    type="text"
    id="<?php echo e($id); ?>"
    placeholder="<?php echo e($placeholder); ?>"
    <?php if($value): ?>value="<?php echo e($value); ?>"<?php endif; ?>
    <?php echo e($attributes); ?>

/>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\forms\inputs\pikaday.blade.php ENDPATH**/ ?>