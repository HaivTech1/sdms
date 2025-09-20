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
                        <div class="col-sm-12">
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
                                    <div class="btn-group btn-group-example mb-3" role="group">
                                        
                                    </div>
                                    <div class="row">
                                        <?php if($selectedRows): ?>
                                            <div class="col-6">
                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button wire:click.prevent="markAllAsAvailable" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-check-double"></i>
                                                        Available
                                                    </button>
                                                    <button wire:click.prevent="markAllAsUnavailable" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-x-circle"></i>
                                                        Unavailable
                                                    </button>
                                                    <button wire:click.prevent="deleteAll" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-block"></i>
                                                        Delete All
                                                    </button>
                                                    <button wire:click.prevent="markAllAsVerified" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-check-double"></i>
                                                        Verified
                                                    </button>
                                                    <button wire:click.prevent="markAllAsUnverified" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-x-circle"></i>
                                                        Unverified
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

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
                                    <th class="align-middle">Student</th>
                                    <th class="align-middle">Amount</th>
                                    <th class="align-middle">Products</th>
                                    <th class="align-middle">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" value="<?php echo e($order->id()); ?>" type="checkbox"
                                                    id="<?php echo e($order->id()); ?>" wire:model="selectedRows">
                                                <label class="form-check-label" for="<?php echo e($order->id()); ?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo e($order->student->student->lastName()); ?> <?php echo e($order->student->student->firstName()); ?></td>
                                        <td><?php echo e(trans('global.naira')); ?><?php echo e(number_format($order->paid(), 2)); ?></td>
                                        <td><?php echo e(count($order->items)); ?></td>
                                        <td>
                                            <?php echo e($order->order_status); ?>

                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <button 
                                                        wire:click="getOrderDetails(<?php echo e($order->id()); ?>)"
                                                        class="dropdown-item"
                                                        data-id="<?php echo e($order->id()); ?>"
                                                    >
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button 
                                                class="btn btn-sm btn-primary viewOrder"
                                                data-id="<?php echo e($order->id()); ?>"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($orders->links('pagination::custom-pagination')); ?>

                </div>
            </div>
        </div>
    </div>

     <div class="modal fade showOrder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Ordered courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 mb-2">
                        <div class="table-responsive">
                            <table id="courses-list" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->startSection('scripts'); ?>
        <script>
            $('.viewOrder').on('click', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                
                
            });
        </script>
    <?php $__env->stopSection(); ?>
</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\commerce\order\index.blade.php ENDPATH**/ ?>