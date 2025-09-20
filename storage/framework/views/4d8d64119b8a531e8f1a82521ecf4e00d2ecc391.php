<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Timetable"); ?>

    <?php $__env->startSection('styles'); ?>
        <style>
            .lesson {
                display: flex;
                flex-direction: row;
                position: relative;
                margin: 5px 0px;
            }

            .main{
                display: flex;
                width: 100%
            }

            .minor{
                position: absolute;
                top: 0;
                right: 0;
                z-index: 100
            }

            .class-name {
                margin-right: 1em;
            }

            .teacher-name {
                margin-left: 1em;
            }

        </style>
    <?php $__env->stopSection(); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">Timetable</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>

        <div class="row">
            <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                <div class="row">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i class="bx bx-plus"></i></button>
                </div>
            <?php endif; ?>

            <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th width="125">Time</th>
                                    <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($day); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $calendarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time => $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-time="<?php echo e($time); ?>">
                                            <td>
                                                <?php echo e($time); ?>

                                            </td>
                                            <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayKey => $dayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="weekCol" data-day-key="<?php echo e($dayKey); ?>">
                                                    <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(is_array($value) && $value['week'] == $dayKey): ?>
                                                            <div class="lesson">
                                                                <div class="main">
                                                                    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                                        <div class="class-name badge badge-soft-info text-center"><?php echo e($value['class_name']); ?></div>
                                                                    <?php endif; ?>
                                                                    <div class="subject-name badge badge-soft-danger text-center"><?php echo e($value['subject_name']); ?></div>
                                                                    <div class="teacher-name badge badge-soft-primary text-center"><?php echo e($value['teacher_name']); ?></div>
                                                                </div>
                                                                <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
                                                                <div class="minor">
                                                                    <button type="button" data-id="<?php echo e($value['id']); ?>" class="delete-lesson"><i class="bx bx-trash text-danger"></i></button>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Create timetable</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="timetable" >

                            <div id="error-list" style="padding: 5px; margin: 5px">
                                <ul></ul>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'grade_id','value' => ''.e(__('Class')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'grade_id','value' => ''.e(__('Class')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <select class="form-control" name="grade_id">
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($grade); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'subject_id','value' => ''.e(__('Subject')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'subject_id','value' => ''.e(__('Subject')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <select class="form-control" name="subject_id">
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($subject); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'teacher_id','value' => ''.e(__('Teacher')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'teacher_id','value' => ''.e(__('Teacher')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <select class="form-control" name="teacher_id">
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($teacher->id()); ?>"><?php echo e($teacher->name()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'weekday','value' => ''.e(__('Week day')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'weekday','value' => ''.e(__('Week day')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <select class="form-control" id="weekday" name="weekday">
                                        <option>Select</option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'weekday']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'weekday']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-sm-6  mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'start_time','value' => ''.e(__('Start time')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'start_time','value' => ''.e(__('Start time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <div class="input-group" id="timepicker-input-group2">
                                        <input id="start_time" type="text" class="form-control"
                                            data-provide="timepicker" name="start_time">

                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'start_time']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'start_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                                <div class="col-sm-6  mb-3">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.label','data' => ['for' => 'end_time','value' => ''.e(__('End time')).'']]); ?>
<?php $component->withName('form.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'end_time','value' => ''.e(__('End time')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <div class="input-group" id="timepicker-input-group1">
                                        <input id="end_time" type="text" class="form-control"
                                            data-provide="timepicker" name="end_time">

                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'end_time']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'end_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>

                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button id="submit_button" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
        <?php $__env->startSection('scripts'); ?>
            <script>
                $(document).ready(function () {
                    $("#timepicker1").timepicker({
                        showMeridian: !1,
                        icons: {
                            up: "mdi mdi-chevron-up",
                            down: "mdi mdi-chevron-down",
                        },
                        appendWidgetTo: "#timepicker-input-group1",
                    }),
                    $("#timepicker2").timepicker({
                        showMeridian: !1,
                        icons: {
                            up: "mdi mdi-chevron-up",
                            down: "mdi mdi-chevron-down",
                        },
                        appendWidgetTo: "#timepicker-input-group2",
                    }),

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });

                    $('#timetable').submit((e) => {
                            e.preventDefault();
                            toggleAble('#submit_button', true, 'Submitting...');

                            var data = new FormData($('#timetable')[0]);
                            var url = "<?php echo e(route('timetable.store')); ?>";

                            $.ajax({
                                url,
                                method: 'post',
                                data,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                            }).then((response) => {
                                Swal.fire({
                                        title: "Good job!",
                                        text: response.message,
                                        icon: "success",
                                        showCancelButton: !0,
                                        confirmButtonColor: "#556ee6",
                                        cancelButtonColor: "#f46a6a",
                                    });
                                    toggleAble('#submit_button', false);
                                    resetForm('#timetable');
                                    window.location.reload();
                            }).catch((errors) => {
                                console.log(errors.responseJSON.errors);
                                toggleAble('#submit_button', false);

                                $("#error-list ul").empty();

                                if (errors.responseJSON.errors) {
                                    Object.values(errors.responseJSON.errors).forEach(function(errorArray) {
                                        errorArray.forEach(function(errorMessage) {
                                            $("#error-list ul").append('<li class="text-danger">' + errorMessage + '</li>');
                                        });
                                    });
                                }
                            });
                    })
                });
            </script>

            <script>
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    row.addEventListener('click', () => {
                        const dayKey = event.target.closest('td').dataset.dayKey;
                        
                        const timeString = row.cells[0].textContent;
                        const times = timeString.split(' - ');
                        const startTime = times[0];
                        const endTime = times[1];
                        $('.bs-example-modal-xl').modal('toggle');
                        $('#start_time').val(startTime);
                        $('#end_time').val(endTime);
                        $('#weekday').val(dayKey);
                        
                    });
                });
            </script>

            <script>
                const deleteLessonButtons = document.querySelectorAll('.delete-lesson');
                deleteLessonButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const lessonId = button.getAttribute('data-id');
                        Swal.fire({
                            title: 'Are you sure you want to delete the lesson?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/timetable/' + lessonId,
                                    type: 'DELETE',
                                    data: {
                                        _token: '<?php echo e(csrf_token()); ?>'
                                    },
                                    success: function(response) {
                                        toastr.success(response.message, 'Success');
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    },
                                    error: function(xhr, status, error) {
                                        toastr.error(error, 'Failed');
                                    }
                                });
                            }
                        });
                    });
                });
            </script>
        <?php $__env->stopSection(); ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\timetable\index.blade.php ENDPATH**/ ?>