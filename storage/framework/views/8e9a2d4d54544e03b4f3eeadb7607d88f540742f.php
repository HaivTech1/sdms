<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Student Virtual Class"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Virtual Class</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e($lesson->title()); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <div class="card" style="width: 100%">
                        <figure id="videoContainer">
                            <video width="320" height="240" 
                                id="video"
                                controls 
                                preload="metadata"
                                
                                >
                                <source src="<?php echo e(asset('storage/'.$lesson->path())); ?>" type="<?php echo e($lesson->type()); ?>">
                            </video> 
                            <ul id="video-controls" class="controls">
                                <li><button id="playpause" type="button"><i class="bx bx-play"></i>/<i class="bx bx-pause"></i></button></li>
                                <li><button id="stop" type="button"><i class="bx bx-stop"></i></button></li>
                                <li class="progress">
                                    <progress id="progress" value="0" min="0">
                                    <span id="progress-bar"></span>
                                    </progress>
                                </li>
                                <li><button id="mute" type="button"><i class="bx bx-volume-mute"></i></button></li>
                                <li><button id="volinc" type="button"><i class="bx bx-volume-full"></i></button></li>
                                <li><button id="voldec" type="button"><i class="bx bx-volume-low"></i></button></li>
                                <li><button id="fs" type="button"><i class="bx bx-fullscreen"></i></button></li>
                            </ul> 
                        </figure>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0 me-4">
                            <img src="<?php echo e(asset('storage/'.$lesson->cover())); ?>" alt="<?php echo e($lesson->title()); ?>" class="avatar-sm">
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="text-truncate font-size-15"><?php echo e($lesson->title()); ?></h5>
                            <p class="text-muted"><?php echo e($lesson->excerpt()); ?></p>
                        </div>
                    </div>

                    <h5 class="font-size-15 mt-4">Topic Details :</h5>

                    <p class="text-muted"><?php echo e($lesson->description()); ?></p>
                    
                    <div class="row task-dates">
                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-calendar me-1 text-primary"></i> Created Date</h5>
                                <p class="text-muted mb-0"><?php echo e($lesson->createdAt()); ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="mt-4">
                                <h5 class="font-size-14"><i class="bx bx-user-check me-1 text-primary"></i> Lesson By</h5>
                                <p class="text-muted mb-0"><?php echo e($lesson->author()->title()); ?>. <?php echo e($lesson->author()->name()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <iframe src="<?php echo e(asset('storage/'.$lesson->transcript())); ?>#toolbar=0" height="300" style="border:none;"></iframe>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Comments</h4>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.lesson.comments','data' => ['lesson' => $lesson]]); ?>
<?php $component->withName('lesson.comments'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['lesson' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lesson)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\student\lesson\show.blade.php ENDPATH**/ ?>