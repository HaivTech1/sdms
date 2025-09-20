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
                                            <th class="align-middle"> Title</th>
                                            <th class="align-middle"> Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $subgrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subgrade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="<?php echo e($subgrade->id()); ?>"
                                                        type="checkbox" id="<?php echo e($subgrade->id()); ?>" wire:model="selectedRows">
                                                    <label class="form-check-label" for="<?php echo e($subgrade->id()); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold"><?php echo e($key+1); ?></a>
                                            </td>
                                            <td>
                                                <span><?php echo e($subgrade->grade->title()); ?></span>
                                                <span><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $subgrade,'field' => 'title'])->html();
} elseif ($_instance->childHasBeenRendered($subgrade->id())) {
    $componentId = $_instance->getRenderedChildComponentId($subgrade->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($subgrade->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($subgrade->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $subgrade,'field' => 'title']);
    $html = $response->html();
    $_instance->logRenderedChild($subgrade->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></span>
                                            </td>
                                            <td>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $subgrade,'field' => 'status'])->html();
} elseif ($_instance->childHasBeenRendered($subgrade->id())) {
    $componentId = $_instance->getRenderedChildComponentId($subgrade->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($subgrade->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($subgrade->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $subgrade,'field' => 'status']);
    $html = $response->html();
    $_instance->logRenderedChild($subgrade->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="right" title="Click to show class details" wire:click="subgradeDetails(<?php echo e($subgrade->id()); ?>)" class="dropdown-item">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo e($subgrades->links('pagination::custom-pagination')); ?>

                        </div>
                        <div class='col-sm-4'>
                            <form wire:submit.prevent="createSubGrade">
                                <div class="col-sm-12">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'title','value' => ''.e(__('Sub Class Name')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title','value' => ''.e(__('Sub Class Name')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your class here..."
                                        aria-label="Add your class here...">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'title']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'title']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'grade_id','value' => ''.e(__('Class')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'grade_id','value' => ''.e(__('Class')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <select class="form-control" wire:model.defer="grade_id">
                                        <option>Select</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'grade_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'grade_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                            <?php if($subgrade_details): ?>
                                <div id="details" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalFullscreenLabel">Class Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col sm-12">
                                                        <h5><?php echo e($subgrade_details->title()); ?></h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"></th>
                                                                <th scope="col" class="text-center">
                                                                xs<br>
                                                                <span class="fw-normal">&lt;576px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                sm<br>
                                                                <span class="fw-normal">≥576px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                md<br>
                                                                <span class="fw-normal">≥768px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                lg<br>
                                                                <span class="fw-normal">≥992px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                xl<br>
                                                                <span class="fw-normal">≥1200px</span>
                                                                </th>
                                                                <th scope="col" class="text-center">
                                                                xxl<br>
                                                                <span class="fw-normal">≥1400px</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Grid behavior</th>
                                                            <td>Horizontal at all times</td>
                                                            <td colspan="5">Collapsed to start, horizontal above breakpoints</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Max container width</th>
                                                            <td>None (auto)</td>
                                                            <td>540px</td>
                                                            <td>720px</td>
                                                            <td>960px</td>
                                                            <td>1140px</td>
                                                            <td>1320px</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Class prefix</th>
                                                            <td><code>.col-</code></td>
                                                            <td><code>.col-sm-</code></td>
                                                            <td><code>.col-md-</code></td>
                                                            <td><code>.col-lg-</code></td>
                                                            <td><code>.col-xl-</code></td>
                                                            <td><code>.col-xxl-</code></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row"># of columns</th>
                                                            <td colspan="6">12</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Gutter width</th>
                                                            <td colspan="6">24px (12px on each side of a column)</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Custom gutters</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Nestable</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Offsets</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Column ordering</th>
                                                            <td colspan="6">Yes</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\sub-grade.blade.php ENDPATH**/ ?>