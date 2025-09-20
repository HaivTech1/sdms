<?php
    $galleries = \App\Models\Gallery::where('status', true)->get();
?>

<div class="full-width-header header-style2">
    <header id="rs-header" class="rs-header">
        <div class="topbar-area">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-md-7">
                        <ul class="topbar-contact">
                            <li>
                                <i class="flaticon-email"></i>
                                <a href="mailto:<?php echo e(application('email')); ?>"><?php echo e(application('email')); ?></a>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <a href="tel:<?php echo e(application('line1')); ?>"><?php echo e(application('line1')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 text-right">
                        <ul class="topbar-right">
                            <li class="login-register">
                                <i class="fa fa-sign-in"></i>
                                <a href="<?php echo e(route('login')); ?>">Portal</a>
                            </li>
                            <li class="btn-part">
                                <a class="apply-btn" href="<?php echo e(url('registration')); ?>">Admission</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-5">
                        <div class="logo-cat-wrap">
                            <div class="logo-part pr-90">
                                <a class="dark-logo" href="<?php echo e(url('/')); ?>">
                                    <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>">
                                </a>
                                <a class="light-logo" href="<?php echo e(url('/')); ?>">
                                    <img src="<?php echo e(asset('storage/'.application('image'))); ?>" alt="<?php echo e(application('name')); ?>">
                                </a>
                            </div>
                            <!-- <div class="categories-btn">
                                <button type="button" class="cat-btn"><i class="fa fa-th"></i>Categories</button>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-lg-7 text-center">
                        <div class="rs-menu-area">
                            <div class="main-menu pr-90">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <!-- current-menu-item -->
                                <nav class="rs-menu">
                                    <ul class="nav-menu">
                                        <li class="menu-item"> 
                                            <a href="<?php echo e(url('/')); ?>">Home</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="<?php echo e(url('/about')); ?>">About</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="<?php echo e(url('/gallery')); ?>">Gallery</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="<?php echo e(url('registration')); ?>">Admission</a>
                                        </li>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <li class="menu-item mobile-menu">
                                                <a href="<?php echo e(route('dashboard')); ?>">Portal</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="menu-item mobile-menu">
                                                <a href="<?php echo e(route('login')); ?>">Login</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav> 
                            </div>

                            <div class="expand-btn-inner">
                                <!-- <ul>
                                    <li>
                                        <a class="hidden-xs rs-search short-border" data-target=".search-modal" data-toggle="modal" href="#">
                                            <i class="flaticon-search"></i>
                                        </a>
                                    </li>
                                    <li class="icon-bar cart-inner no-border mini-cart-active">
                                        <a class="cart-icon">
                                            <span class="cart-count">2</span>
                                            <i class="flaticon-bag"></i>
                                        </a>
                                        <div class="woocommerce-mini-cart text-left">
                                            <div class="cart-bottom-part">
                                                <ul class="cart-icon-product-list">
                                                    <li class="display-flex">
                                                        <div class="icon-cart">
                                                            <a href="#"><i class="fa fa-times"></i></a>
                                                        </div>
                                                        <div class="product-info">
                                                            <a href="cart.html">Law Book</a><br>
                                                            <span class="quantity">1 × $30.00</span>
                                                        </div>
                                                        <div class="product-image">
                                                            <a href="cart.html"><img src="<?php echo e(asset('frontend/images/shop/1.jpg')); ?>" alt="Product Image"></a>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <div class="total-price text-center">
                                                    <span class="subtotal">Subtotal:</span>
                                                    <span class="current-price">$85.00</span>
                                                </div>

                                                <div class="cart-btn text-center">
                                                    <a class="crt-btn btn1" href="<?php echo e(url('cart')); ?>">View Cart</a>
                                                    <a class="crt-btn btn2" href="<?php echo e(url('checkout')); ?>">Check Out</a>
                                                </div>
                                            </div>
                                        </div> 
                                    </li>
                                </ul> -->
                                <a id="nav-expander" class="nav-expander style3">
                                    <span class="dot1"></span>
                                    <span class="dot2"></span>
                                    <span class="dot3"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="right_menu_togle hidden-md">
            <div class="close-btn">
                <div id="nav-close">
                    <div class="line">
                        <span class="line1"></span><span class="line2"></span>
                    </div>
                </div>
            </div>
            <div class="canvas-logo">
                <a href="index.html"><img src="<?php echo e(asset('storage/'.application('image') )); ?>" alt="logo"></a>
            </div>
            <div class="offcanvas-text">
                <p><?php echo e(application('description')); ?></p>
            </div>
            <div class="offcanvas-gallery">
                <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-img">
                        <a class="image-popup" href="<?php echo e(asset($gallery->image())); ?>"><img src="<?php echo e(asset($gallery->image())); ?>" alt="<?php echo e($gallery->title()); ?>"></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="canvas-contact">
                <ul class="social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>
</div><?php /**PATH C:\laragon\www\primary\resources\views/components/partials/nav.blade.php ENDPATH**/ ?>