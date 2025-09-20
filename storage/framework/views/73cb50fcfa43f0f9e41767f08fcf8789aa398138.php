<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Result Page"); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">School Calendar</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Generate calendar</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.admin.staff.calendar', [])->html();
} elseif ($_instance->childHasBeenRendered('UHXVO7f')) {
    $componentId = $_instance->getRenderedChildComponentId('UHXVO7f');
    $componentTag = $_instance->getRenderedChildComponentTagName('UHXVO7f');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('UHXVO7f');
} else {
    $response = \Livewire\Livewire::mount('components.admin.staff.calendar', []);
    $html = $response->html();
    $_instance->logRenderedChild('UHXVO7f', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\staff\calendar.blade.php ENDPATH**/ ?>