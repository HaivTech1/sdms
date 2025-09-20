<?php $__env->startComponent('mail::message'); ?>

<div class="relative w-100 mb4 bg-near-white">
    <div class="mb3 pa4 mid-gray overflow-hidden">
        <h5 class="f3 near-black" style="margin-bottom: 5px"> <?php echo e(ucwords($subject)); ?> </h5>
        <div class="nested-links f5 lh-copy nested-copy-line-height">
            <?php echo $message->saveHTML(); ?>
        </div>
    </div>
</div>

<br>
Thanks,<br>
<?php echo e(application('name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\primary\resources\views\emails\messaging\birthday_wish.blade.php ENDPATH**/ ?>