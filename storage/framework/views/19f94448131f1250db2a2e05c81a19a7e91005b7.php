<article class="flex" data-aos="fade-up">

    <a href="<?php echo e(route('posts.show', $post)); ?>" class="post-image">
        <img class="object-cover w-full h-full" src="<?php echo e(asset('storage/' . $post->image())); ?>" alt="Stock One">
    </a>

    <section class="relative flex-1">
        <div class="mt-16 space-y-8">

            
            <div class="relative flex space-x-4">
                <?php $__currentLoopData = $post->tags(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#" class="text-sm font-bold uppercase text-theme-blue-100"><?php echo e($tag->name()); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($post->isPremium()): ?>
                
                <div class="absolute top-0 right-0">
                    <h2 class="p-2 text-xs text-gray-200 uppercase bg-gray-800">
                        Premium
                    </h2>
                </div>
                <?php endif; ?>
            </div>

            
            <h2 class="font-serif text-5xl font-bold">
                <?php echo e($post->title()); ?>

            </h2>

            
            <p class="leading-6 tracking-wide text-gray-700">
                <?php echo e($post->excerpt(300)); ?>

            </p>
        </div>

        
        <div class="absolute flex justify-between w-full bottom-8">
            <div class="flex items-center space-x-4">
                <a href="#">
                    <img class="object-cover w-12 h-12 rounded" src="<?php echo e(asset($post->author()->profile_photo_url)); ?>" alt="<?php echo e($post->author()->name()); ?>">
                </a>
                <div class="">
                    <h3 class="text-xl font-bold"><?php echo e($post->author()->name()); ?></h3>
                    <span class="text-sm text-gray-600">Food & Leisure</span>
                </div>
            </div>

            
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.link.primary','data' => ['href' => ''.e(route('posts.show', $post)).'']]); ?>
<?php $component->withName('link.primary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('posts.show', $post)).'']); ?>
                <?php echo e(__('Read More')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        </div>
    </section>
</article>
<?php /**PATH C:\laragon\www\primary\resources\views\components\lesson\latest.blade.php ENDPATH**/ ?>