<?php $__env->startComponent('mail::message'); ?>
Booking: **<?php echo e($booking->id()); ?>**, has just been accepted.

<?php $__env->startComponent('mail::panel'); ?>
You can proceed to make payment on your dashboard by clicking the pay now button in the **action** dropdown. If you have
any complain about the property please call <?php echo e(application('name')); ?>

customer care line on <a href="tel:+<?php echo e(application('line1')); ?>"><?php echo e(application('line1')); ?></a> or email us at <a
    href="mailto:<?php echo e(application('email')); ?>"><?php echo e(application('email')); ?></a>.

Please be informed that your booking: **<?php echo e($booking->id()); ?>** contains logistics and cleaning services
which <?php echo e(application('name')); ?> offers completely out of the box so as to ease your stress
of moving to a new home; we transport your loads and do a thorough cleaning of the
environment before you move in. Feel free to remove it before making payment if you don't find it necessary.

<?php echo $__env->renderComponent(); ?>

Thanks,
Team <?php echo e(application('name')); ?>, <?php echo e(date('Y')); ?>.
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\primary\resources\views\emails\new_booking_accepted.blade.php ENDPATH**/ ?>