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
                    <div class="row">
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                <option value=''>Class</option>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-lg-8">
                             <?php if($selectedRows): ?>
                                <div class="row justify-content-center align-items-center g-2 mt-2">
                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="deleteAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-trash"></i>
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="generatePin" type="button"
                                                class="btn btn-outline-primary w-sm">
                                                <i class="bx bx-caret-right"></i>
                                                Generate Pin
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="regeneratePin" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-caret-right"></i>
                                                Regenerate Pin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2 mt-2">
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
                                        <th class="align-middle"> Name </th>
                                        <th class="align-middle">Reg. no </th>
                                        <th class="align-middle">Code </th>
                                        <th class="align-middle">Used</th>
                                        <th class="align-middle">Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" value="<?php echo e($student->id()); ?>"
                                                    type="checkbox" id="<?php echo e($student->id()); ?>"
                                                    wire:model="selectedRows">
                                                <label class="form-check-label" for="<?php echo e($student->id()); ?>"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript: void(0);" class="text-body fw-bold"><?php echo e($key + 1); ?></a>
                                        </td>
                                        <td>
                                            <?php echo e($student->firstName()); ?> <?php echo e($student->lastName()); ?>

                                        </td>
                                        <td>
                                            <?php echo e($student->user->code()); ?>

                                        </td>
                                        <td>
                                            <?php if($student->user->pin()): ?>
                                                <?php echo e($student->user->pin()); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($student->user->scratchCard?->usedTimes()): ?>
                                                <?php echo e($student->user->scratchCard?->usedTimes()); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($student->user->pin() == null): ?>
                                                 <button class="btn btn-primary waves-effect waves-light" type="button" wire:click="generateSinglePin('<?php echo e($student->id()); ?>')">Generate</button>
                                            <?php else: ?>
                                                 <button class="btn btn-success waves-effect waves-light" type="button" wire:click="regenerateSinglePin('<?php echo e($student->id()); ?>')">Regenerate</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php echo e($pins->links('pagination::custom-pagination')); ?>

                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\manager\generate.blade.php ENDPATH**/ ?>