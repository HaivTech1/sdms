<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta property="description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta property="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />

    
    <meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta property="og:image" content="<?php echo $__env->yieldContent('metaImage'); ?>" />
    <meta property="og:image:type" content="image/jpeg" />


    
    <meta property="twitter:card" content="<?php echo $__env->yieldContent('summary_large_image'); ?>" />
    <meta property="twitter:site" content="<?php echo e(config('services.twitter.handle')); ?>" />
    <meta property="twitter:image" content="<?php echo $__env->yieldContent('metaImage'); ?>" />
    <meta property="twitter:description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta property="twitter:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta name="theme-color" content="#6777ef" />
    <link rel="shortcut icon" href="<?php echo e(asset('storage/'.application('image'))); ?>" />

    
    <title><?php echo $__env->yieldContent('title', ''.application('name')); ?></title>

    <?php echo $__env->make('partials.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <!-- ========== Left Sidebar Start ========== -->

        <?php echo $__env->make('partials.sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                <div class="container-fluid">
                    <?php if(isset($header)): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <?php echo e($header); ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php echo $__env->make('partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo e($slot); ?>


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Transaction Modal -->
            <?php echo $__env->make('shared.transactionModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- end modal -->

            <!-- subscribeModal -->
            <!-- <?php echo $__env->make('shared.subscriptionModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->
            <!-- end modal -->

            <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <?php echo $__env->make('partials.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH C:\laragon\www\primary\resources\views\layouts\app.blade.php ENDPATH**/ ?>