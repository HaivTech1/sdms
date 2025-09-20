<input
    name="<?php echo e($name); ?>"
    type="checkbox"
    id="<?php echo e($id); ?>"
    <?php if($value): ?>value="<?php echo e($value); ?>"<?php endif; ?>
    <?php echo e($checked ? 'checked' : ''); ?>

    <?php echo e($attributes); ?>

/>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\forms\inputs\checkbox.blade.php ENDPATH**/ ?>