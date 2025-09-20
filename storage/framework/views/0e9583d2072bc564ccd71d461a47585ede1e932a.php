<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Attendance Sheet"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">TimeTable</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Sheet</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                        <tr>

                            <th>Student Name</th>
                            <th>Class</th>
                            <?php
                            $today = today();
                            $dates = [];

                            for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                }

                                ?>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th style="">
                                    <?php echo e($date); ?>

                                </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="student_uuid" value="<?php echo e($student->id()); ?>">
                            <tr>
                              <td><?php echo e($student->fullName()); ?></td>
                                <td><?php echo e($student->grade->title()); ?></td>

                                <?php for($i = 1; $i < $today->daysInMonth + 1; ++$i): ?>

                                    <?php

                                    $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month,
                                    $i)->format('Y-m-d');

                                    $check_attd = \App\Models\Attendance::query()
                                    ->where('student_uuid', $student->id())
                                    ->where('attendance_date', $date_picker)
                                    ->first();

                                    $check_leave = \App\Models\Leave::query()
                                    ->where('student_uuid', $student->id())
                                    ->where('leave_date', $date_picker)
                                    ->first();

                                    ?>
                                    <td>

                                        <div class="form-check form-check-inline ">

                                            <?php if(isset($check_attd)): ?>
                                                <?php if($check_attd->status==1): ?>
                                                <i class="bx bx-badge-check text-primary"></i>
                                                <?php else: ?>
                                                <i class="bx bx-badge-check text-danger"></i>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <i class="bx bx-x text-danger"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-check form-check-inline">

                                            <?php if(isset($check_leave)): ?>
                                            <?php if($check_leave->status==1): ?>
                                            <i class="bx bx-badge-check text-primary"></i>
                                            <?php else: ?>
                                            <i class="bx bx-badge-check text-danger"></i>
                                            <?php endif; ?>

                                            <?php else: ?>
                                            <i class="bx bx-x text-danger"></i>
                                            <?php endif; ?>


                                        </div>

                                    </td>

                                    <?php endfor; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\check\sheetreport.blade.php ENDPATH**/ ?>