<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Finger Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"><?php echo e(trans('global.show')); ?> <?php echo e(trans('cruds.finger_device.title')); ?></h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e($fingerDevice->name); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card">

        <div class="card-header">

            <?php echo e(trans('global.show')); ?> <?php echo e(trans('cruds.finger_device.title')); ?>


        </div>

        <div class="card-body">

            <div class="form-group">

                <div class="form-group">

                    <a class="btn btn-primary" href="<?php echo e(route('finger_device.index')); ?>">

                        <?php echo e(trans('global.back_to_list')); ?>


                    </a>

                </div>

                <table class="table table-bordered table-striped">

                    <tbody>

                        <tr>

                            <th>

                                <?php echo e(trans('cruds.finger_device.fields.id')); ?>


                            </th>

                            <td>

                                <?php echo e($fingerDevice->id); ?>


                            </td>

                        </tr>

                        <tr>

                            <th>

                                <?php echo e(trans('cruds.finger_device.fields.name')); ?>


                            </th>

                            <td>

                                <?php echo e($fingerDevice->name); ?>


                            </td>

                        </tr>

                        <tr>

                            <th>

                                <?php echo e(trans('cruds.finger_device.fields.ip')); ?>


                            </th>

                            <td>

                                <?php echo e($fingerDevice->ip); ?>


                            </td>

                        </tr>

                        <tr>

                            <th>

                                <?php echo e(trans('cruds.finger_device.fields.serialNumber')); ?>


                            </th>

                            <td>

                                <?php echo e($fingerDevice->serialNumber); ?>


                            </td>

                        </tr>

                    </tbody>

                </table>



            </div>

        </div>

    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\finger\show.blade.php ENDPATH**/ ?>