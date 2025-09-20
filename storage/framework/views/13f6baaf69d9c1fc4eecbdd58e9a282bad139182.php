<?php if (isset($component)) { $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BaseLayout::class, []); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php
        $choose = \App\Models\Choose::first();
        $parent_reviews = \App\Models\ParentReview::all();
    ?>

    <div id="rs-banner" class="rs-banner style7">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1 class="banner-title white-color"><?php echo e(getAboutSetting('home_title')); ?></h1>
                        <div class="desc white-color mb-50">
                            <?php echo e(getAboutSetting('home_description')); ?>

                        </div>
                        <div class="btn-part">
                            <a class="readon border-less" href="<?php echo e(url('/about')); ?>"><?php echo e(getAboutSetting('home_button_text')); ?></a>
                        </div>
                    </div>
                    <div class="icons one up-down">
                        <img src="<?php echo e(asset('frontend/images/banner/home7/icon/2.png')); ?>" alt="Images">
                    </div> 
                    <div class="icons two left-right">
                        <img src="<?php echo e(asset('frontend/images/banner/home7/icon/1.png')); ?>" alt="Images">
                    </div> 
                    <div class="icons three left-right">
                        <img src="<?php echo e(asset('frontend/images/banner/home7/icon/1.png')); ?>" alt="Images">
                    </div> 
                    <div class="icons four up-down">
                        <img src="<?php echo e(asset('frontend/images/banner/home7/icon/2.png')); ?>" alt="Images">
                    </div>
                </div>
                <div class="offset-lg-6"></div>
            </div>
        </div>
        <div class="img-part">
            <img src="<?php echo e(asset('storage/'.getAboutSetting('home_banner_image') )); ?> }}" alt="Banner Image">
        </div>
    </div>

    <div class="rs-about style11 pt-100 md-pt-70 pb-100 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 md-mb-30">
                    <div class="img-part js-tilt">
                        <img src="<?php echo e(asset('storage/'. getAboutSetting('about_background_image'))); ?>" alt="images">
                    </div>
                </div>
                <div class="col-lg-6 pl-65 md-pl-15 col-md-12">
                    <div class="sec-title2">
                        <div class="sub-title">
                            About us
                        </div>
                        <h2 class="title purple-color mb-30"><?php echo e(getAboutSetting('about_heading')); ?></h2>
                        <p class="desc mb-45">
                            <?php echo e(getAboutSetting('about_description')); ?>

                        </p>
                    </div>
                    <div class="btn-part">
                        <a class="readon purple-btn" href="<?php echo e(url('/about')); ?>">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (\Illuminate\Support\Facades\Blade::check('registrationLinkEnabled')): ?>
        <div class="rs-cta  style2 gray-bg3 pt-100 pb-100 md-pt-70 md-pb-70">
                <div class=" wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                <div class="content  text-center">
                    <div class="sec-title2 mb-40 ">
                        <div class="sub-title purple-color"><?php echo e(application('name')); ?> Admission</div>
                        <h2 class="title purple-color">Admission Open for <?php echo e(date('Y')); ?></h2>
                        <div class="desc purple-color">
                            <?php echo e(getAboutSetting('admission_description')); ?>

                        </div>
                    </div>
                    <div class="btn-part">
                        <a class="readon purple-color" href="<?php echo e(url('registration')); ?>">Contact Now</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="why-choose-us style2 gray-bg3 pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 order-last">
                    <div class="video-wrap md-mb-40">
                        <img src="<?php echo e(asset('storage/'. getAboutSetting('choose_background_image'))); ?>" alt="">
                        <a class="popup-videos" href="<?php echo e(getAboutSetting('choose_link')); ?>">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="sec-title2 mb-40">
                        <div class="sub-title">Specialty</div>
                        <h2 class="title purple-color"><?php echo e(getAboutSetting('choose_title')); ?></h2>
                        <div class="desc pr-124 md-pr-15"><?php echo e(getAboutSetting('choose_description')); ?></div>
                    </div>
                    <div class="facilities-two">
                        <div class="row">
                            <?php $__currentLoopData = convertStringToArray(getAboutSetting('choose_options')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-6 mb-40 md-mb-25 col-md-6">
                                    <div class="content-part">
                                        <div class="icon-part purple-bg">
                                        <img src="<?php echo e(asset('frontend/images/choose/icons/2.png')); ?>" alt="">
                                        </div>
                                        <div class="text-part">
                                        <h4 class="title"><?php echo e($option); ?></h4> 
                                        </div>  
                                    </div>
                                </div> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>
    </div>

    <?php if(count($parent_reviews) > 0): ?>
        <div class="rs-testimonial home11-style pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="sec-title2 text-center mb-40">
                    <div class="sub-title">Testimonials</div>
                    <h2 class="title purple-color">Our Happy Parents</h2>
                </div>
                    <div class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="true" data-autoplay-timeout="7000" data-smart-speed="2000" data-dots="true" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="2" data-md-device-nav="false" data-md-device-dots="true">
                    <?php $__currentLoopData = $parent_reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testi-item">
                            <div class="row">
                                <div class="col-lg-4 md-mb-30 col-md-4">
                                    <div class="user-img">
                                        <img src="<?php echo e(asset('storage/'.$review->image())); ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="user-info">
                                        <div class="desc"><?php echo e($review->description()); ?></div>
                                        <a class="name" href="#"><?php echo e($review->name()); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="rs-gallery home11-style pt-100 md-pt-70 pb-100 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 md-mb-30">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="<?php echo e(asset('storage/'.getAboutSetting('home_gallery_image'))); ?>" alt="">
                                <div class="content-part">
                                    <h2 class="title">Our Gallery</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Our Gallery</h2>
                                <p>
                                    <?php echo e(getAboutSetting('home_gallery_description')); ?>

                                </p>
                                <div class="btn-part">
                                    <a href="<?php echo e(url('gallery')); ?>">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-4 md-mb-30">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="<?php echo e(asset('storage/'.getAboutSetting('home_timetable_image'))); ?>" alt="">
                                <div class="content-part">
                                    <h2 class="title">Timetable</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Timetable</h2>
                                <p>
                                   <?php echo e(getAboutSetting('home_timetable_description')); ?>

                                </p>
                                <div class="btn-part">
                                    <a href="<?php echo e(route('timetable.index')); ?>">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-4">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="<?php echo e(asset('storage/'. getAboutSetting('home_tuition_image'))); ?>" alt="">
                                <div class="content-part">
                                    <h2 class="title">Tuition Fee</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Tuition Fee</h2>
                                <p>
                                   <?php echo e(getAboutSetting('home_tuition_description')); ?>

                                </p>
                                <div class="btn-part">
                                    <a href="<?php echo e(route('student.fees')); ?>">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\frontend\welcome.blade.php ENDPATH**/ ?>