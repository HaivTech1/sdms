<?php if (isset($component)) { $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BaseLayout::class, []); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <p><?php echo e($title); ?></p>
     <?php $__env->endSlot(); ?>

        <div class="rs-shop-part orange-color pt-130 pb-130 md-pt-80 md-pb-80">
            <div class="container">
                <div class="row rs-vertical-middle shorting mb-25">
                    <div class="col-sm-6 col-12">
                        <p class="woocommerce-result-count">Showing 1-9 of 12 results</p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <select class="from-control">
                            <option>Default sorting</option>
                            <option>Sort by popularity</option>
                            <option>Sort by average rating</option>
                            <option>Sort by lates</option>
                            <option>Sort by price: low to high</option>
                            <option>Sort by price: high to low</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/4.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Medicine Bottle</a></h2>
                                <span class="price">$30.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/5.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Medicine Bottle</a></h2>
                                <span class="price">$30.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/7.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Prescription Book</a></h2>
                                <span class="price">$30.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/9.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                                <span class="onsale">sale!</span>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Stethoscope</a></h2>
                                <span class="price">$25.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/11.jpg" alt="">
                                <div class="overley">
                                <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Urinary System</a></h2>
                                <span class="price">$20.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/1.jpg" alt="">
                                <div class="overley">
                                <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Presser Machine</a></h2>
                                <span class="price">$25.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/2.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Digital Mechanics</a></h2>
                                <span class="price">$20.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/9.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                                <span class="onsale">sale!</span>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Oxygen Mask</a></h2>
                                <span class="price">$20.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-53">
                        <div class="product-list">
                            <div class="image-product">
                                <img src="assets/images/shop/10.jpg" alt="">
                                <div class="overley">
                                    <a href="#"><i class="flaticon-basket"></i></a>
                                </div>
                            </div>
                            <div class="content-desc text-center">
                                <h2 class="loop-product-title pt-15"><a href="#">Tablet Medicine</a></h2>
                                <span class="price">$20.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pagenav-link orange-color text-center">
                    <ul>
                        <li>1</li>
                        <li><a href="#">2</a></li>
                        <li><a href="#"><i class="flaticon-next"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\frontend\shop.blade.php ENDPATH**/ ?>