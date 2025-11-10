<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Unauthorized User</title>

    <?php echo $__env->make('partials.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-2 fw-medium">4<i class="bx bx-buoy bx-spin text-primary display-3"></i>3
                        </h1>
                        <h4 class="text-uppercase">Unauthorized User</h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="<?php echo e(route('dashboard')); ?>">Back to
                                Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div>
                        <img src="<?php echo e(asset('images/error-img.png')); ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('partials.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>


</html><?php /**PATH C:\laragon\www\primary\resources\views/errors/403.blade.php ENDPATH**/ ?>