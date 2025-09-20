<?php if (isset($component)) { $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\BaseLayout::class, []); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <p><?php echo e($title); ?></p>
     <?php $__env->endSlot(); ?>

    <div class="rs-gallery pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row">
                <?php if(count($images) > 0): ?>
                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 mb-30 col-md-6">
                            <div class="gallery-item">
                                <div class="gallery-img">
                                    <a class="image-popup" href="<?php echo e(asset($image->image())); ?>"><img src="<?php echo e(asset($image->image())); ?>" alt="<?php echo e($image->title()); ?>"></a>
                                </div>
                                <?php if($image->title): ?>
                                    <div class="title">
                                        <?php echo e($image->title()); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div style="display: flex; justify-content: center">
                        <p style="text-align: center">No image in the gallery</p>
                    </div> 
                <?php endif; ?>
            </div>
        </div> 
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\frontend\gallery.blade.php ENDPATH**/ ?>