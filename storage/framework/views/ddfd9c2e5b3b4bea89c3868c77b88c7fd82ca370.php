<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Mark Attendance Page"); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Mark <?php echo e($attendance->grade->title); ?> Attendance for <?php echo e($attendance->created_at->format('d-m-Y')); ?></li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="table-responsive">
                                <table id="students-table" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Morning</th>
                                            <th>Afternoon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                            
                                                <input name="attendance_id[]" type="hidden" value="<?php echo e($attendance->id()); ?>" />
                                                <input name="student_id[]" type="hidden" value="<?php echo e($student->id()); ?>" />

                                                <td><?php echo e($key+1); ?></td>
                                                <td><?php echo e($student->lastName()); ?> <?php echo e($student->firstName()); ?> <?php echo e($student->otherName()); ?></td>
                                                <td>
                                                    <input type="checkbox" 
                                                        class="attendance-checkbox" 
                                                        id="morning_<?php echo e($student->id()); ?>" 
                                                        data-attendance-type="morning" 
                                                        <?php echo e(isAttendanceMarked($student->id(), $attendance->id(), 'morning') ? 'checked' : ''); ?>

                                                    />
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="attendance-checkbox" 
                                                        id="afternoon_<?php echo e($student->id()); ?>" 
                                                        data-attendance-type="afternoon"
                                                        <?php echo e(isAttendanceMarked($student->id(), $attendance->id(), 'afternoon') ? 'checked' : ''); ?>

                                                    />
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

    <?php $__env->startSection('scripts'); ?>
        <script>
            $(document).ready(function () {
                $('.attendance-checkbox').change(function () {
                    var attendanceId = $(this).closest('tr').find('input[name="attendance_id[]"]').val();
                    var studentId = $(this).closest('tr').find('input[name="student_id[]"]').val();
                    var attendanceType = $(this).data('attendance-type');
                    var isChecked = $(this).is(':checked');

                    console.log(attendanceId, studentId, attendanceType, isChecked);

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(route('attendance.mark')); ?>',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            attendance_id: attendanceId,
                            student_id: studentId,
                            attendance_type: attendanceType,
                            is_checked: isChecked ? 1 : 0
                        },
                        success: function (response) {
                            toastr.success(response.message, 'Successful!');
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message, 'Failed!');
                        }
                    });
                });
            });
        </script>
    <?php $__env->stopSection(); ?>
   
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\primary\resources\views\admin\attendance\class_attendance.blade.php ENDPATH**/ ?>