<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo e(application('name')); ?></title>

<link rel="shortcut icon" href="<?php echo e(URL::asset('storage/' .application('image'))); ?>" type="image/png">
<link rel="apple-touch-icon" href="<?php echo e(URL::asset('storage/' .application('image'))); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/animate.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/owl.carousel.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/slick.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/off-canvas.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/magnific-popup.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('frontend/css/rsmenu-main.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/rs-spacing.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/style.css')); ?>"> 
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/responsive.css')); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/fonts/linea-fonts.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/fonts/flaticon.css')); ?>">
<!-- Theme overrides generated from settings (loaded after frontend styles) -->
<link rel="stylesheet" href="<?php echo e(asset('css/theme.css')); ?>?v=<?php echo e(filemtime(public_path('css/theme.css')) ?? time()); ?>" />
<style>
	:root{
		--primary-color: <?php echo e(get_settings('primary_color') ?? '#377dff'); ?>;
		--secondary-color: <?php echo e(get_settings('secondary_color') ?? '#6c757d'); ?>;
		--app-bg: <?php echo e(get_settings('app_background_color') ?? '#ffffff'); ?>;
		--primary-contrast: <?php echo e(get_settings('primary_contrast') ?? '#ffffff'); ?>;
	}
</style>

<link href="<?php echo e(asset('css/toastr.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/notiflix.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php echo BladeUIKit\BladeUIKit::outputStyles(); ?><?php /**PATH C:\laragon\www\primary\resources\views\components\partials\head.blade.php ENDPATH**/ ?>