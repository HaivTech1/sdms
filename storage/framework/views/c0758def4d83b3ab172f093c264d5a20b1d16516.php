<?php if(isset($user)): ?>
<?php
$classes = 'img-fluid d-block rounded-circle';
?>

<a href="#">
    <img <?php echo e($attributes->merge(['class' => $classes])); ?> src="<?php echo e(asset('storage/'.$user->image())); ?>" alt="<?php echo e($user->name()); ?>">
</a>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\components\user\avatar.blade.php ENDPATH**/ ?>