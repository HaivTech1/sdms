<div <?php echo e($attributes); ?>>
    <input name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" value="<?php echo e(old($name, $slot)); ?>" type="hidden">
    <trix-editor input="<?php echo e($id); ?>" class="<?php echo e($styling); ?>"></trix-editor>
</div>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\editors\trix.blade.php ENDPATH**/ ?>