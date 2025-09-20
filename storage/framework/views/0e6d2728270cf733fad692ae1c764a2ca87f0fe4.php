<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Assignment Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Assignment</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Available assignments</h4>

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-check">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle"> </th>
                                        <th class="align-middle"> Title</th>
                                        <th class="align-middle">Subject</th>
                                        <th class="align-middle">Posted By</th>
                                        <th class="align-middle">Posted Date</th>
                                        <th class="align-middle"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($key+1); ?>

                                        </td>
                                        <td>
                                            <?php echo e($assignment->title()); ?>

                                        </td>
                                        <td>
                                            <?php echo e($assignment->subject->title()); ?>

                                        </td>
                                        <td>
                                           <?php echo e($assignment->author()->title()); ?>. <?php echo e($assignment->author()->name()); ?>

                                        </td>
                                        <td>
                                           <?php echo e($assignment->createdAt()); ?>

                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('assignment.show', $assignment->id())); ?>"
                                                class="btn btn-sm btn-primary"><i class="bx bx-show"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\assignment\get.blade.php ENDPATH**/ ?>