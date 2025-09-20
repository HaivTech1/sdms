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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.search','data' => []]); ?>
<?php $component->withName('search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        
                                        <?php if($selectedRows): ?>
                                        <div class="col-6">
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button wire:click.prevent="deleteAll" type="button"
                                                    class="btn btn-outline-primary w-sm">
                                                    <i class="bx bx-block"></i>
                                                    Delete All
                                                </button>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class='row'>

                        <div class='col-sm-8'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        wire:model="selectPageRows">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Key</th>
                                            <th class="align-middle">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="<?php echo e($setting->id()); ?>"
                                                        type="checkbox" id="<?php echo e($setting->id()); ?>" wire:model="selectedRows">
                                                    <label class="form-check-label" for="<?php echo e($setting->id()); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold"><?php echo e($key+1); ?></a>
                                            </td>
                                            <td>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $setting,'field' => 'key'])->html();
} elseif ($_instance->childHasBeenRendered($setting->id())) {
    $componentId = $_instance->getRenderedChildComponentId($setting->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($setting->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($setting->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $setting,'field' => 'key']);
    $html = $response->html();
    $_instance->logRenderedChild($setting->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </td>
                                            <td>
                                                <?php if($setting->value === '1' || $setting->value === '0'): ?>
                                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $setting,'field' => 'value'])->html();
} elseif ($_instance->childHasBeenRendered($setting->id())) {
    $componentId = $_instance->getRenderedChildComponentId($setting->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($setting->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($setting->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $setting,'field' => 'value']);
    $html = $response->html();
    $_instance->logRenderedChild($setting->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                <?php else: ?>
                                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $setting,'field' => 'value'])->html();
} elseif ($_instance->childHasBeenRendered($setting->id())) {
    $componentId = $_instance->getRenderedChildComponentId($setting->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($setting->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($setting->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $setting,'field' => 'value']);
    $html = $response->html();
    $_instance->logRenderedChild($setting->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo e($settings->links('pagination::custom-pagination')); ?>

                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createSetting">
                                <div class="gap-3">
                                    <div class="mb-2">
                                        <input class="form-control me-auto" wire:model.defer="key" placeholder="Add your key here..." />
                                    </div>

                                    <div class="mb-2">
                                        <input class="form-control me-auto" wire:model.defer="value" placeholder="Add your value here..." />
                                    </div>

                                    <button type="submit" class="btn btn-secondary">Add</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\settings.blade.php ENDPATH**/ ?>