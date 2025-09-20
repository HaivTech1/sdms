<div>
    
        <div class="row mt-2 mb-2">
            <div class="col-sm-8">
                <form wire:submit.prevent="createCategory">
                    <div class="hstack gap-3">
                        <input class="form-control me-auto" wire:model.defer="title" placeholder="Add your category here..."
                            aria-label="Add your category here...">
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
            
            <?php if($selectedRows): ?>
                <div class="col-sm-2">
                    <div class="btn-group btn-group-example" role="group">
                        <button wire:click.prevent="deleteAll" type="button"
                            class="btn btn-outline-danger w-sm">
                            <i class="bx bx-trash"></i>
                            Delete All
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    

    <div class='row'>
        <div class='col-sm-12'>
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
                            <th class="align-middle"> Title </th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" value="<?php echo e($category->id()); ?>"
                                        type="checkbox" id="<?php echo e($category->id()); ?>"
                                        wire:model="selectedRows">
                                    <label class="form-check-label" for="<?php echo e($category->id()); ?>"></label>
                                </div>
                            </td>
                            <td>
                                <?php echo e($category->title()); ?>

                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger btn-sm" wire:click="delete(<?php echo e($category->id()); ?>)"><i class="bx bx-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\commerce\category\index.blade.php ENDPATH**/ ?>