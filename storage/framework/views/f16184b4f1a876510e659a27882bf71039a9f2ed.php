<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"><?php echo e($user->user_type); ?></h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back to !</h5>
                                <p><?php echo e(application('name')); ?></p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="<?php echo e(asset('images/profile-img.png')); ?>" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-6 col-lg-8">
                            <div class="avatar-md profile-user-wid">
                                <img src="<?php echo e(asset('storage/'.$user->image())); ?>" alt="" class="img-thumbnail rounded-circle avatar-sm">
                            </div>
                            <div>
                                <h5><span class="badge badge-soft-info">Name:</span> <?php echo e($user->name()); ?></h5>
                                <p class="text-muted mb-1"><span class="badge badge-soft-info">Reg No.:</span> <?php echo e($user->code()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div>
                    <div class="row">
                    
                        <div class="col-lg-12">
                            <div class="p-4">
                                <p style="font-weight: bold; font-size: 20px"><?php echo e(application('name')); ?></p>
                                <div class="mt-2">
                                    <div class="onoffswitch3">
                                        <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox" id="myonoffswitch3" checked>
                                        <label class="onoffswitch3-label" for="myonoffswitch3">
                                            <span class="onoffswitch3-inner">
                                                <span class="onoffswitch3-active">
                                                    <marquee class="scroll-text">
                                                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span><?php echo e($event->title()); ?>: <?php echo e(strip_tags($event->description())); ?></span> 
                                                            <span class="bx bx-caret-right"></span> 
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </marquee>
                                                    <span class="onoffswitch3-switch">BREAKING NEWS <span class="bx bx-x"></span></span>
                                                </span>
                                                <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch">SHOW BREAKING NEWS</span></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 align-self-center">
                                            <div class="text-lg-center mt-4 mt-lg-0">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div>
                                                            <p class="text-muted text-truncate mb-2">Session</p>
                                                            <h5 class="mb-0"><?php echo e($session?->title() ?? 'Not set'); ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div>
                                                            <p class="text-muted text-truncate mb-2">Term</p>
                                                            <h5 class="mb-0"><?php echo e($term?->title() ?? 'Not set'); ?></h5>
                                                        </div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\dashboard\teacher.blade.php ENDPATH**/ ?>