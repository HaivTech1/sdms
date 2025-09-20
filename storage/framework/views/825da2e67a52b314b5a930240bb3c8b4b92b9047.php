<div
    x-data="{
        initPickr: function (element) {
            let pickr = Pickr.create(<?php echo e(json_encode($options())); ?>);
            let input = document.getElementById('<?php echo e($id . '-input'); ?>');

            pickr.on('save', function (color) {
                let currentColor = color ? color.toHEXA().toString() : '';

                input.setAttribute('value', currentColor);
                element.setAttribute('title', currentColor);
            });
        }
    }"
    x-init="initPickr($el)"
    <?php echo e($attributes->merge(['title' => $value])); ?>

>
    <div id="<?php echo e($id); ?>"></div>

    <input
        id="<?php echo e($id); ?>-input"
        name="<?php echo e($name); ?>"
        type="hidden"
        <?php if($value): ?>value="<?php echo e($value); ?>"<?php endif; ?>
    />
</div>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\forms\inputs\color-picker.blade.php ENDPATH**/ ?>