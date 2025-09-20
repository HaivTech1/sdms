<div class="">
    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $depth = ($comment->depth * 8)
        ?>

        <div class="d-flex py-3
        <?php if($comment->depth > 0 ): ?>mx-<?php echo e($depth); ?><?php endif; ?>"
        >
            <div class="flex-shrink-0 me-3">
                <div class="avatar-xs">
                    <img src="<?php echo e(asset('storage/'. $comment->author()->image())); ?>" alt="" class="img-fluid d-block rounded-circle">
                </div>
            </div>
            <div class="flex-grow-1">
                <h5 class="font-size-14 mb-1"><?php echo e($comment->author()->name()); ?> <small class="text-muted float-end"><?php echo e($comment->created_at->format('d, M,y')); ?></small></h5>
                <p class="text-muted"><?php echo e($comment->body()); ?></p>
                <div>
                    
                    <div class="">
                        <?php if(!$comment->depth()): ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.lesson.reply','data' => ['comment' => $comment,'lesson' => $lesson,'loop' => $loop->depth]]); ?>
<?php $component->withName('lesson.reply'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['comment' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($comment),'lesson' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lesson),'loop' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->depth)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if($comment->replies()): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.lesson.replies','data' => ['comments' => $comment->replies(),'lesson' => $lesson]]); ?>
<?php $component->withName('lesson.replies'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['comments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($comment->replies()),'lesson' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lesson)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div><?php /**PATH C:\laragon\www\primary\resources\views\components\lesson\replies.blade.php ENDPATH**/ ?>