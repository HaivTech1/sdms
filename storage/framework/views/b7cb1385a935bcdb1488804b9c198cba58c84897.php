<div>
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.loading','data' => []]); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <div class="text-center">
        <button type="button" wire:click='addToCart(<?php echo e($product->id()); ?>)' class="btn btn-primary waves-effect  mt-2 waves-light">
            <i class="bx bx-shopping-bag me-2"></i>Add to cart
        </button>
    </div>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\add-to-cart.blade.php ENDPATH**/ ?>