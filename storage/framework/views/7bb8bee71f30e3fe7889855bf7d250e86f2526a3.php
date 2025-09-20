<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Finger Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18"> <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.finger_device.title_singular')); ?>

        </h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active"><?php echo e(trans('global.create')); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card">
        <div class="card-header">
            <?php echo e(trans('global.create')); ?> <?php echo e(trans('cruds.finger_device.title_singular')); ?>

        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route("finger_device.store")); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="required" for="title"><?php echo e(trans('cruds.finger_device.fields.name')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name"
                        id="title" value="<?php echo e(old('name', '')); ?>" required>
                        <?php if($errors->has('name')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                        <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.finger_device.fields.name_helper')); ?></span>
                </div>

                <div class="form-group">
                    <label class="required" for="ip"><?php echo e(trans('cruds.finger_device.fields.ip')); ?></label>
                    <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="ip"
                        id="ip" value="<?php echo e(old('ip', '')); ?>" required>
                    <?php if($errors->has('ip')): ?>
                        <span class="text-danger"><?php echo e($errors->first('ip')); ?></span>
                    <?php endif; ?>
                    <span class="help-block"><?php echo e(trans('cruds.finger_device.fields.ip_helper')); ?></span>
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-primary" type="submit">
                        <?php echo e(trans('global.save')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\finger\create.blade.php ENDPATH**/ ?>