<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-print-none">
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model.debounce.350ms="grade">
                                <option value=''>Class</option>
                                <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pin-card mb-2">
                        <?php $__currentLoopData = $pins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-4">
                            <h1 class="text-center"><?php echo e($pin->user->student->fullName()); ?></h1>
                            <div class="card-scratch">
                                <img
                                    class="demo-bg"
                                    src="/images/logo.png"
                                    alt=""
                                >
                                <img src="<?php echo e(asset('storage/'.application('image'))); ?>" style="width: 40px; height: 40px; border-radius: 50%" />
                                <div class="demo-content">
                                    <h1><?php echo e(application('name')); ?></h1>
                                    <span>Pin: <b style="color: red"><?php echo e($pin->user->pin()); ?></b></span>
                                    <span style="font-size: 5px"><?php echo e($pin->term->title()); ?> - <?php echo e($pin->period->title()); ?></span>
                                    <br />
                                    <span style="font-size: 8px">visit: <?php echo e(application('website')); ?></span>
                                </div>
                            </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\manager\pins.blade.php ENDPATH**/ ?>