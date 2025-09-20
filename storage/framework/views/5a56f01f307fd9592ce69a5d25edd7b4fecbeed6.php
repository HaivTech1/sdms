<?php
$classes = 'inline-flex items-center px-2 py-2 border border-gray-300 rounded font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-400 focus:outline-none focus:border-gray-100 focus:ring focus:ring-gray-100 disabled:opacity-25 transition cursor-pointer'
?>

<a <?php echo e($attributes->merge(['class' => $classes ])); ?>>
    <?php echo e($slot); ?>

</a>
<?php /**PATH C:\laragon\www\primary\resources\views\components\buttons\social.blade.php ENDPATH**/ ?>