 <div class="card">
        <div class="card-body">
        <div class="row mb-2">
        <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-lg-6">
                        <select class="form-control select2" id="teacher_id" wire:model.debounce.350ms="teacher">
                            <option value=''>Select Teacher</option>
                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>

            <div class="table-responsive">
                <table class="table table-responsive table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Class</th>
                            <?php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month,
                                $i)->format('Y-m-d');
                                }

                                ?>
                                <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th>
                                    <?php echo e($date); ?>

                                </th>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="<?php echo e(route('check.check_store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success" style="display: flex; margin:10px">Submit</button>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="student_uuid" value="<?php echo e($student->id()); ?>">
                                <input type="hidden" name="grade_id" value="<?php echo e($student->grade->id()); ?>">
                                <tr>
                                    <td><?php echo e($student->fullName()); ?></td>
                                    <td><?php echo e($student->grade->title()); ?></td>

                                    <?php for($i = 1; $i < $today->daysInMonth + 1; ++$i): ?>
                                        <?php
                                            
                                            $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                            
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
                                           <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="check_box"
                                                    name="attd[<?php echo e($date_picker); ?>][<?php echo e($student->id()); ?>]" type="checkbox"
                                                    <?php if(isset($check_attd)): ?>  checked <?php endif; ?> id="inlineCheckbox1" value="1">

                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="check_box"
                                                    name="leave[<?php echo e($date_picker); ?>][<?php echo e($student->id()); ?>]]" type="checkbox"
                                                    <?php if(isset($check_leave)): ?>  checked <?php endif; ?> id="inlineCheckbox2" value="1">

                                            </div>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </form>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div><?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\teacher\attendance.blade.php ENDPATH**/ ?>