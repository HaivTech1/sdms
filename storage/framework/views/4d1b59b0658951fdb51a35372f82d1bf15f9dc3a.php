<?php $__env->startComponent('mail::message'); ?>
**<?php echo e($booking->author()->name()); ?>** has just booked your property **<?php echo e($booking->property->id()); ?>**
Login into your dashboard to verify booking.

<?php $__env->startComponent('mail::panel'); ?>
order_id = <?php echo e($booking->id()); ?>

<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::button', ['url' => route('booking.index')]); ?>
Bookings
<?php echo $__env->renderComponent(); ?>

Thanks, <br />
Team <?php echo e(application('name')); ?>, <?php echo e(date('Y')); ?>.
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\primary\resources\views\emails\new_booking.blade.php ENDPATH**/ ?>