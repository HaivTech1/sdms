<div x-data="{ show: false }">
    <?php if(!$comment->maximumReplies()): ?>
    <button class="text-sm font-semibold text-blue-500 uppercase" @click="show = !show" :aria-expanded="show ? 'true' : 'false'" :class="{ 'active': show }">
        Reply
    </button>
    <?php else: ?>
    <h2 class="text-sm text-theme-blue-100">
        Maximum replies reached for this comment
    </h2>
    <?php endif; ?>
    <div x-show="show">
        <form action="<?php echo e(route('comments.store')); ?>" class="space-y-4" method="POST">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.textarea','data' => ['name' => 'body','class' => '','placeholder' => 'Leave a reply here...']]); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'body','class' => '','placeholder' => 'Leave a reply here...']); ?>
                <?php echo e(old('body')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'body']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'body']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <input type="hidden" name="commentable_id" value="<?php echo e($lesson->id()); ?>">
            <input type="hidden" name="commentable_type" value="lessons">
            <input type="hidden" name="parent_id" value="<?php echo e($comment->id()); ?>">
            <input type="hidden" name="depth" value="<?php echo e($loop); ?>">


            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.default','data' => []]); ?>
<?php $component->withName('buttons.default'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                Submit
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\components\lesson\reply.blade.php ENDPATH**/ ?>