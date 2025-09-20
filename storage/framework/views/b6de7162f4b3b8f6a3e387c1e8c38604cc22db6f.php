<div
    x-data="
{
    timer: {
        days: '<?php echo e($days()); ?>',
        hours: '<?php echo e($hours()); ?>',
        minutes: '<?php echo e($minutes()); ?>',
        seconds: '<?php echo e($seconds()); ?>',
    },
    startCounter: function () {
        let runningCounter = setInterval(() => {
            let countDownDate = new Date(<?php echo e($expires->timestamp); ?> * 1000).getTime();
            let timeDistance = countDownDate - new Date().getTime();

            if (timeDistance < 0) {
                clearInterval(runningCounter);

                return;
            }

            this.timer.days = this.formatCounter(Math.floor(timeDistance / (1000 * 60 * 60 * 24)));
            this.timer.hours = this.formatCounter(Math.floor((timeDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
            this.timer.minutes = this.formatCounter(Math.floor((timeDistance % (1000 * 60 * 60)) / (1000 * 60)));
            this.timer.seconds = this.formatCounter(Math.floor((timeDistance % (1000 * 60)) / 1000));
        }, 1000);
    },
    formatCounter: function (number) {
        return number.toString().padStart(2, '0');
    }
}
"
    x-init="startCounter()"
    <?php echo e($attributes); ?>

>
    <?php if($slot->isEmpty()): ?>
        <span x-text="timer.days"><?php echo e($days()); ?></span> :
        <span x-text="timer.hours"><?php echo e($hours()); ?></span> :
        <span x-text="timer.minutes"><?php echo e($minutes()); ?></span> :
        <span x-text="timer.seconds"><?php echo e($seconds()); ?></span>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\date-time\countdown.blade.php ENDPATH**/ ?>