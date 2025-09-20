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
                                        <div class="col-lg-4">
                                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                                <option value=''>Select Grade</option>
                                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($grade->id); ?>"><?php echo e($grade->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <select class="form-control select2" wire:model.debounce.350ms="subject">
                                                <option value=''>Select subject</option>
                                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->title()); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-12">
                            <div class="row">
                                <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-4 col-sm-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-4">
                                                        <div class="avatar-md">
                                                            <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                                                <img src="<?php echo e(asset('storage/'.$lesson->cover())); ?>" alt="<?php echo e($lesson->title()); ?>" height="30" class="rounded-circle avatar-md">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate font-size-15"><a href="javascript: void(0);" class="text-dark"><?php echo e($lesson->title()); ?></a></h5>
                                                        <p class="text-muted mb-4"><?php echo e($lesson->excerpt()); ?></p>
                                                        <div class="avatar-group">
                                                            <a href="<?php echo e(route('lesson.show', $lesson->id())); ?>"  class="btn btn-primary btn-sm">
                                                                <i class= "bx bxs-show me-1"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 py-3 border-top">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bx-calendar me-1"></i> <?php echo e($lesson->createdAt()); ?>

                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bxs-show me-1"></i> <?php echo e(views($lesson)->count()); ?>

                                                    </li>
                                                    <li class="list-inline-item me-3">
                                                        <i class= "bx bxs-comment me-1"></i> <?php echo e($lesson->comments()->count()); ?>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php echo e($lessons->links('pagination::custom-pagination')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\student\lesson\index.blade.php ENDPATH**/ ?>