<?php
$classes = 'border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm w-full'
?>

<textarea <?php echo e($attributes->merge(['class' => $classes])); ?>><?php echo e($slot); ?></textarea>
<?php /**PATH C:\laragon\www\primary\resources\views\components\form\textarea.blade.php ENDPATH**/ ?>