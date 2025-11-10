<tr>
<td class="header">
<a href="<?php echo e($url); ?>" style="display: inline-block;">
<?php if(trim($slot) === application('name')): ?>
<img src="<?php echo e(asset('storage/'.application('image'))); ?>" class="logo" alt="<?php echo e(application('name')); ?>">
<?php else: ?>
<?php echo e($slot); ?>

<?php endif; ?>
</a>
</td>
</tr>
<?php /**PATH C:\laragon\www\primary\resources\views/vendor/mail/html/header.blade.php ENDPATH**/ ?>