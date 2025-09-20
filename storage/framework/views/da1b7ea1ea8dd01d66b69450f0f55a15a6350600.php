<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', "Check General Result"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">General Results</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Result</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>
    
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.admin.result.general-primary', [])->html();
} elseif ($_instance->childHasBeenRendered('sZ7pe7H')) {
    $componentId = $_instance->getRenderedChildComponentId('sZ7pe7H');
    $componentTag = $_instance->getRenderedChildComponentTagName('sZ7pe7H');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('sZ7pe7H');
} else {
    $response = \Livewire\Livewire::mount('components.admin.result.general-primary', []);
    $html = $response->html();
    $_instance->logRenderedChild('sZ7pe7H', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\check_general.blade.php ENDPATH**/ ?>