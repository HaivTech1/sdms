<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | $title"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"><?php echo e($description); ?></h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row mt-2 mb-2">
        <div class="col-sm-4">
            <div class="search-box me-2 mb-2 d-inline-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." id="input-search">
                    <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class='row'>
          <div class='col-sm-12'>
            <div class="table-responsive">
                <table class="table align-middle table-nowrap table-check search-table">
                    <thead class="table-light header-item">
                        <tr>
                            <th style="width: 20px;" class="align-middle">
                                <div class="form-check font-size-16">
                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                        wire:model="selectPageRows">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th class="align-middle"> Sender </th>
                            <th class="align-middle"> To</th>
                            <th class="align-middle"> Message</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody class="search-row">
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="search-items">
                                <td>
                                    <div class="form-check font-size-16">
                                        <input class="form-check-input message-checkbox" value="<?php echo e($message['id']); ?>"
                                            type="checkbox" id="<?php echo e($message['id']); ?>">
                                        <label class="form-check-label" for="<?php echo e($message['id']); ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <?php echo e($message['sender']); ?>

                                </td>
                                <td>
                                    <?php echo e($message['number']); ?>

                                </td>
                                <td>
                                    <?php echo e(Illuminate\Support\Str::limit($message['message'], 20, '...')); ?>

                                </td>
                                <td>
                                    <?php if($message['status'] == 1): ?>
                                        <span class="badge bg-success"><i class="bx bx-check"></i> Sent </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bx bx-times"></i> Failed</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary btn-sm resendMessage" data-id="<?php echo e($message['id']); ?>" data-phone="<?php echo e($message['id']); ?>"><i class="bx bx-send"></i>Resend</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <?php if(count($messages) > 0): ?>
                    <?php echo e($messages->links('pagination::bootstrap-4')); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>

   

    <?php $__env->startSection('scripts'); ?>
      
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\whatsapp\sentMessage.blade.php ENDPATH**/ ?>