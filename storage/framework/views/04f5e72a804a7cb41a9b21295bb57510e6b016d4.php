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
                        <div class='col-sm-12'>
                            <form wire:submit.prevent="createGrade">
                                <div class="hstack gap-3">
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
                                    <button type="submit" class="btn btn-secondary">Add</button>
                                    <div class="vr"></div>
                                    <button wire:click="resetState" type="button" class="btn btn-outline-danger">Reset</button>
                                </div>
                            </form>

                            
                        </div>

                        <div class='col-sm-12 mt-4'>
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
                                            <th class="align-middle">No. of students</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="<?php echo e($grade->id()); ?>"
                                                        type="checkbox" id="<?php echo e($grade->id()); ?>" wire:model="selectedRows">
                                                    <label class="form-check-label" for="<?php echo e($grade->id()); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold"><?php echo e($key+1); ?></a>
                                            </td>
                                            <td>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.edit-title', ['model' => $grade,'field' => 'title'])->html();
} elseif ($_instance->childHasBeenRendered($grade->id())) {
    $componentId = $_instance->getRenderedChildComponentId($grade->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($grade->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($grade->id());
} else {
    $response = \Livewire\Livewire::mount('components.edit-title', ['model' => $grade,'field' => 'title']);
    $html = $response->html();
    $_instance->logRenderedChild($grade->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </td>
                                            <td>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.toggle-button', ['model' => $grade,'field' => 'status'])->html();
} elseif ($_instance->childHasBeenRendered($grade->id())) {
    $componentId = $_instance->getRenderedChildComponentId($grade->id());
    $componentTag = $_instance->getRenderedChildComponentTagName($grade->id());
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($grade->id());
} else {
    $response = \Livewire\Livewire::mount('components.toggle-button', ['model' => $grade,'field' => 'status']);
    $html = $response->html();
    $_instance->logRenderedChild($grade->id(), $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </td>
                                            <td>
                                                <?php echo e($grade->students->count()); ?>

                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="right" title="Click to show class details" wire:click="GradeDetails(<?php echo e($grade->id()); ?>)" class="dropdown-item">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-primary waves-effect waves-light assignSubjects"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-id="<?php echo e($grade->id()); ?>"
                                                    title="Click to show assign subjects">
                                                    <i class="fa fa-list"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo e($grades->links('pagination::custom-pagination')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startSection('script'); ?>
    <script>
        // Delegated click handler so it survives Livewire re-renders and doesn't require jQuery
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.assignSubjects');
            if (!btn) return;
            e.preventDefault();
            const gradeId = btn.dataset.id;
            // quick debug - replace with your modal/open logic or Livewire emit
            alert('Assign subjects for grade: ' + gradeId);
            if (window.Livewire) {
                Livewire.emit('openAssignSubjectsModal', gradeId);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.assign-subject-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Provide the URL template for the AJAX partial loader; expects replaceable __ID__
        window.assignSubjectsUrlTemplate = '/admin/grades/__ID__/subjects/assign';
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\grade.blade.php ENDPATH**/ ?>