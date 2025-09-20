<div x-data="{ open: false }" @click.away="open = false" <?php echo e($attributes); ?>>
    <div @click="open = ! open">
        <?php echo e($trigger); ?>

    </div>

    <div x-show="open">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\navigation\dropdown.blade.php ENDPATH**/ ?>