<?php $__env->startComponent('mail::message'); ?>

<div class="relative w-100 mb4 bg-near-white">
    <div class="mb3 pa4 mid-gray overflow-hidden">
        <div class="f6"> <?php echo e(date('D, M j, Y \a\t g:ia')); ?> </div>
        <h1 class="f3 near-black"> <?php echo e(ucwords($subject)); ?> </h1>
        <?php echo $body ?? ''; ?>

    </div>
</div>

<br>
Thanks,<br>
<?php echo e(application('name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\primary\resources\views\emails\messaging\send_mail.blade.php ENDPATH**/ ?>