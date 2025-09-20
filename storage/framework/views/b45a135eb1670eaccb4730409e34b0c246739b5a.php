<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta property="description" content="<?php echo e(application('description')); ?>" />
    <meta property="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />

    
    <meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta property="og:image" content="<?php echo e(asset('storage/'.application('image'))); ?>" />
    <meta property="og:image:type" content="image/jpeg" />


    
    <meta property="twitter:card" content="<?php echo $__env->yieldContent('summary_large_image'); ?>" />
    <meta property="twitter:site" content="<?php echo e(config('services.twitter.handle')); ?>" />
    <meta property="twitter:image" content="<?php echo e(asset('storage/'.application('image'))); ?>" />
    <meta property="twitter:description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta property="twitter:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta name="theme-color" content="#6777ef" />

    <title>Site under maintenance</title>

    <?php echo $__env->make('partials.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>
    
    <?php echo $__env->make('partials.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>


</html><?php /**PATH C:\laragon\www\primary\resources\views\maintenance.blade.php ENDPATH**/ ?>