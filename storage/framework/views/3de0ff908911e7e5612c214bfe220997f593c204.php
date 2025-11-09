<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', "Check Result Page"); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">Primary Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Result</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>
        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.admin.result.check-primary', [])->html();
} elseif ($_instance->childHasBeenRendered('fzAiOkA')) {
    $componentId = $_instance->getRenderedChildComponentId('fzAiOkA');
    $componentTag = $_instance->getRenderedChildComponentTagName('fzAiOkA');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fzAiOkA');
} else {
    $response = \Livewire\Livewire::mount('components.admin.result.check-primary', []);
    $html = $response->html();
    $_instance->logRenderedChild('fzAiOkA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/check_primary.blade.php ENDPATH**/ ?>