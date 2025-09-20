<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Finger Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Fingerprint Device</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('finger_device.create')); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('cruds.finger_device.title_singular')); ?>

                </a>

                <a class="btn btn-primary"
                   href="<?php echo e(route('finger_device.clear.attendance')); ?>">
                    <i class="fas fa-cog"></i>
                    Clear device attendance
                </a>
            </div>
        </div>

     <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                        <tr>
                                            <th data-priority="1"> <?php echo e(trans('cruds.finger_device.fields.id')); ?></th>
                                            <th data-priority="3"><?php echo e(trans('cruds.finger_device.fields.name')); ?></th>
                                            <th data-priority="4"><?php echo e(trans('cruds.finger_device.fields.ip')); ?></th>
                                            <th data-priority="6"> <?php echo e(trans('cruds.finger_device.fields.serialNumber')); ?></th>
                                            <th data-priority="7">Status</th>
                                            <th data-priority="7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr data-entry-id="<?php echo e($finger_device->id); ?>">

                                            <td><?php echo e($finger_device->id ?? ''); ?></td>
                                            <td><?php echo e($finger_device->name ?? ''); ?></td>
                                            <td><?php echo e($finger_device->ip ?? ''); ?></td>
                                            <td> <?php echo e($finger_device->serialNumber ?? ''); ?></td>
                                            <td>
                                                <?php
                                                    $device = $helper->init($finger_device->ip);
                                                ?>

                                                <?php if($helper->getStatus($device)): ?>
                                                    <div class="badge badge-success">
                                                        Active
                                                    </div>
                                                <?php else: ?>
                                                    <div class="badge badge-danger">
                                                        Deactivate
                                                    </div>
                                                <?php endif; ?>

                                                <a class="btn btn-xs btn-outline-success"
                                                    href="<?php echo e(route('finger_device.add.employee', $finger_device->id)); ?>">
                                                    <i class="fas fa-plus"></i>
                                                    Add Employee
                                                </a>
                                                
                                                <a class="btn btn-xs btn-outline-success"
                                                    href="<?php echo e(route('finger_device.get.attendance', $finger_device->id)); ?>">
                                                    <i class="fas fa-plus"></i>
                                                    Get Attendance
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-primary"
                                                    href="<?php echo e(route('finger_device.show', $finger_device->id)); ?>">
                                                    <?php echo e(trans('global.view')); ?>

                                                </a>
                                                <a class="btn btn-xs btn-info"
                                                    href="<?php echo e(route('finger_device.edit', $finger_device->id)); ?>">
                                                    <?php echo e(trans('global.edit')); ?>

                                                </a>

                                                <form action="<?php echo e(route('finger_device.destroy', $finger_device->id)); ?>" method="POST"
                                                    onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="<?php echo e(trans('global.delete')); ?>">
                                                </form>
                                            </td>
                                        </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\finger\index.blade.php ENDPATH**/ ?>