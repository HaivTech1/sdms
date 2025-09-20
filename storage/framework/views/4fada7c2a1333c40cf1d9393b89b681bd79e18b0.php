<?php if($human): ?>

<time datetime="<?php echo e($date->format($format)); ?>" <?php echo e($attributes); ?>>
    <?php echo e($date->diffForHumans()); ?>

</time>

<?php elseif($local !== null): ?>

<span
    x-data="{
        formatLocalTimeZone: function (element, timestamp) {
            const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const date = moment.unix(timestamp).tz(timeZone);

            element.innerHTML = date.format('<?php echo e($local !== true ? $local : 'YYYY-MM-DD HH:mm:ss (z)'); ?>');
        }
    }"
    x-init="formatLocalTimeZone($el, <?php echo e($date->timestamp); ?>)"
    title="<?php echo e($date->diffForHumans()); ?>"
    <?php echo e($attributes); ?>

>
    <?php echo e($date->format('Y-m-d H:i:s')); ?>

</span>

<?php else: ?>

<span title="<?php echo e($date->diffForHumans()); ?>" <?php echo e($attributes); ?>>
    <?php echo e($date->format($format)); ?>

</span>

<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\date-time\carbon.blade.php ENDPATH**/ ?>