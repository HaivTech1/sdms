<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Teams</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
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
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <a href="<?php echo e(route('teams.create')); ?>" type="button"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Create Team</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table class="table align-middle table-nowrap table-check">
                        <thead class="table-light">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($team->name); ?></td>
                                <td>
                                    <?php if(auth()->user()->isOwnerOfTeam($team)): ?>
                                    <span class="label label-success">Owner</span>
                                    <?php else: ?>
                                    <span class="label label-primary">Member</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(is_null(auth()->user()->currentTeam) ||
                                    auth()->user()->currentTeam->getKey() !== $team->getKey()): ?>
                                    <a href="<?php echo e(route('teams.switch', $team)); ?>" class="btn btn-sm btn-default">
                                        <i class="fa fa-sign-in"></i> Switch
                                    </a>
                                    <?php else: ?>
                                    <span class="label label-default">Current team</span>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('teams.members.show', $team)); ?>" class="btn btn-sm btn-default">
                                        <i class="fa fa-users"></i> Members
                                    </a>

                                    <?php if(auth()->user()->isOwnerOfTeam($team)): ?>

                                    <a href="<?php echo e(route('teams.edit', $team)); ?>" class="btn btn-sm btn-default">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>

                                    <form style="display: inline-block;" action="<?php echo e(route('teams.destroy', $team)); ?>"
                                        method="post">
                                        <?php echo csrf_field(); ?>

                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                            Delete</button>
                                    </form>
                                    <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\teamwork\index.blade.php ENDPATH**/ ?>