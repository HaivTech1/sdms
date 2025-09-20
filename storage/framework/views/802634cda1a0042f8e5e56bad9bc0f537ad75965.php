<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Result Page"); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">Mid-Term Results</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.student.result.midterm', ['user' => ''.e($user->id).''])->html();
} elseif ($_instance->childHasBeenRendered('GBEpQ0L')) {
    $componentId = $_instance->getRenderedChildComponentId('GBEpQ0L');
    $componentTag = $_instance->getRenderedChildComponentTagName('GBEpQ0L');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('GBEpQ0L');
} else {
    $response = \Livewire\Livewire::mount('components.student.result.midterm', ['user' => ''.e($user->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('GBEpQ0L', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\midterm_index.blade.php ENDPATH**/ ?>