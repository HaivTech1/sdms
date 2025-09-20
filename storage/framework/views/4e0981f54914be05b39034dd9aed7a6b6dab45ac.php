<meta name="twitter:card" content="<?php echo e($card); ?>" />

<meta property="og:type" content="<?php echo e($type); ?>">
<meta property="og:title" content="<?php echo e($title); ?>" />

<?php if($description): ?>
    <meta name="description" content="<?php echo e($description); ?>">
    <meta property="og:description" content="<?php echo e($description); ?>">
<?php endif; ?>

<?php if($image): ?>
    <meta property="og:image" content="<?php echo e($image); ?>" />
<?php endif; ?>

<meta property="og:url" content="<?php echo e($url); ?>" />
<meta property="og:locale" content="<?php echo e(app()->getLocale()); ?>" />
<?php /**PATH C:\laragon\www\primary\vendor\blade-ui-kit\blade-ui-kit\resources\views\components\layouts\social-meta.blade.php ENDPATH**/ ?>