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
        <div class="col-lg-12">
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
                                    <?php if( Auth::user()->isTeamOwner() ): ?>
                                    <div class="text-center">
                                        <div class="d-flex flex-wrap gap-3 align-items-center">
                                            <div class="btn-group-vertical" role="group"
                                                aria-label="Vertical button group">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupVerticalDrop1" type="button"
                                                        class="btn btn-primary" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                        <a class="dropdown-item"
                                                            wire:click.prevent="ApproveAll">Approved
                                                            Task</a>
                                                        <a class="dropdown-item"
                                                            wire:click.prevent="CompleteAll">Complete
                                                            Task</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </diV>
                    </div>
                </div>

                <div class=" col-sm-4">
                    <div class="text-sm-end">
                        <a href="<?php echo e(route('task.create')); ?>"
                            class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                class="mdi mdi-plus me-1"></i> Add Task</a>
                    </div>
                </div><!-- end col-->
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Upcoming</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                <?php $__empty_3 = true; $__currentLoopData = $waitings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waiting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                <tr>
                                    <td style="width: 40px;">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="<?php echo e($waiting->id()); ?>" type="checkbox"
                                                id="<?php echo e($waiting->id()); ?>" wire:model="selectedRows">
                                            <label class="form-check-label" for="upcomingtaskCheck01"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark"><?php echo e($waiting->name()); ?></a></h5>
                                    </td>
                                    <td>

                                        <?php $__currentLoopData = $waiting->team->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="<?php echo e(asset('storage/profile-photos/'. $user->profile_photo_path)); ?>"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill badge-soft-secondary font-size-11"><?php echo e($waiting->status_badge); ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no waiting tasks.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">In Progress</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                <?php $__empty_3 = true; $__currentLoopData = $approveds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                <tr>
                                    <td style="width: 40px;">
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" value="<?php echo e($approved->id()); ?>"
                                                type="checkbox" id="<?php echo e($approved->id()); ?>" wire:model="selectedRows">
                                            <label class="form-check-label" for="upcomingtaskCheck01"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark"><?php echo e($approved->name()); ?></a></h5>
                                    </td>
                                    <td>

                                        <?php $__currentLoopData = $approved->team->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="<?php echo e(asset('storage/profile-photos/'. $user->profile_photo_path)); ?>"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill <?php echo e($approved->status_badge === 'Approved' ? 'badge-soft-warning' : 'badge-soft-secondary'); ?> font-size-11"><?php echo e($approved->status_badge); ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no progress tasks.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Completed</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <tbody>
                                <?php $__empty_3 = true; $__currentLoopData = $completeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $completed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                <tr>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="javascript: void(0);"
                                                class="text-dark"><?php echo e($completed->name()); ?></a></h5>
                                    </td>
                                    <td>

                                        <?php $__currentLoopData = $completed->team->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="avatar-group">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="<?php echo e(asset('storage/profile-photos/'. $user->profile_photo_path)); ?>"
                                                        alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span
                                                class="badge rounded-pill <?php echo e($completed->status_badge === 'Completed' ? 'badge-soft-success' : 'badge-soft-secondary'); ?>  font-size-11"><?php echo e($completed->status_badge); ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm" colspan="2">
                                        Your team has no completed tasks.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\task.blade.php ENDPATH**/ ?>