<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title()); ?></title>

    <?php echo e($head ?? ''); ?>

</head>
<body <?php echo e($attributes); ?>>

<?php echo e($slot); ?>


</body>
</html>
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\layouts\html.blade.php ENDPATH**/ ?>