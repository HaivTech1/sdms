<form method="POST" action="<?php echo e($action); ?>">
    <?php echo csrf_field(); ?>

    <button type="submit" <?php echo e($attributes); ?>>
        <?php echo e($slot->isEmpty() ? __('Log out') : $slot); ?>

    </button>
</form>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\buttons\logout.blade.php ENDPATH**/ ?>