<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('styles'); ?>
        <link href="<?php echo e(asset('libs/admin-resources/rwd-table/rwd-table.min.css')); ?>" rel="stylesheet" type="text/css" />
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('title', application('name')." | Class Broadsheet"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Broadsheet</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Class</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.admin.result.broadsheet.grade', [])->html();
} elseif ($_instance->childHasBeenRendered('E0ilZ0z')) {
    $componentId = $_instance->getRenderedChildComponentId('E0ilZ0z');
    $componentTag = $_instance->getRenderedChildComponentTagName('E0ilZ0z');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('E0ilZ0z');
} else {
    $response = \Livewire\Livewire::mount('components.admin.result.broadsheet.grade', []);
    $html = $response->html();
    $_instance->logRenderedChild('E0ilZ0z', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/classBroadsheet.blade.php ENDPATH**/ ?>