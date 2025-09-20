<?php $__env->startComponent('mail::message'); ?>
A new payment has just been made with transaction id =  **<?php echo e($payment->transactionId()); ?>**

<?php $__env->startComponent('mail::panel'); ?>
**Reference Number:** <?php echo e($payment->referenceId()); ?> <br />
**Amount:** <?php echo e(trans('global.naira')); ?><?php echo e(number_format($payment->amount(), 2)); ?> <br>
**Balance:** <?php echo e(trans('global.naira')); ?><?php echo e(number_format($payment->balance(), 2)); ?> <br>
**Paid by:** <?php echo e($payment->paidBy()); ?> <br>
<?php
    $student = \App\Models\Student::findOrFail($payment->student_uuid);
?>
**Class:** <?php echo e($student->grade->title()); ?>

<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::button', ['url' => route('payment.index')]); ?>
View payments
<?php echo $__env->renderComponent(); ?>

Thanks,
<?php echo e(application('name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\primary\resources\views\emails\new_payment.blade.php ENDPATH**/ ?>