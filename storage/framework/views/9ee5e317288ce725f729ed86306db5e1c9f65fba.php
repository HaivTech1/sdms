<div>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.loading','data' => []]); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="mt-2">
                            <form id="fetchResultForm">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <select class="form-control getStudents" id="grade_id" name="grade_id">
                                            <option value=''>Class</option>
                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <select class="form-control" id="student_id" name="student_id">
                                            <option value=''>Student</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <select class="form-control" id="period_id" name="period_id">
                                            <option value=''>Select Session</option>
                                            <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'period_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'period_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="col-lg-2">
                                        <select class="form-control" id="term_id" name="term_id">
                                            <option value=''>Select Term</option>
                                            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.form.error','data' => ['for' => 'term_id']]); ?>
<?php $component->withName('form.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'term_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <button type="submit" id="fetchResultButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                Fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <div class="table-responsive">
                                <table id="result-data" class="table table-bordered table-striped table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Name of Student</th>
                                            <th scope="col" class="text-center">
                                                Recorded Subjects
                                            </th>
                                            <th scope="col" class="text-center" id="action">
                                                Action
                                            </th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>

                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->startSection('scripts'); ?>

    

    <script>
        $(document).ready(function() {
            var student_uuid = $("input[name=student_uuid]").val();
            var period_id = $("input[name=period_id]").val();
            var term_id = $("input[name=term_id]").val();
            
            $('#createAffective').submit((e) => {
                e.preventDefault();
                toggleAble('#affective_button', true, 'Submitting...');

                var data = $('#createAffective').serializeArray();
                var url = "<?php echo e(route('result.affective.upload')); ?>";

                $.ajax({
                    type: "POST",
                    url,
                    data,
                }).done((res) => {
                    toggleAble('#affective_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createAffective');
                     $("#createAffectiveModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#affective_button', false);
                });
            });

            $('#createPsychomotor').submit((e) => {
                e.preventDefault();
                toggleAble('#psychomotor_button', true, 'Submitting...');

                var data = $('#createPsychomotor').serializeArray();
                var url = "<?php echo e(route('result.psychomotor.upload')); ?>";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#psychomotor_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createPsychomotor');
                    $("#createPsychomotorModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#psychomotor_button', false);
                });

                
            });

            $('#createComment').submit((e) => {
                e.preventDefault();
                toggleAble('#submit_comment', true, 'Submitting...');

                var data = $('#createComment').serializeArray();
                var url = '/result/cognitive/upload';
                var type = $(this).attr('method')

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit_comment', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createCommentModal").modal('toggle');
                        
                    }
                }).fail((res) => {
                    toggleAble('#submit_comment', false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $('#createPrincipalComment').submit((e) => {
                e.preventDefault();
                var button = "#submit_principal_comment";
                toggleAble(button, true, 'Submitting...');

                var data = $('#createPrincipalComment').serializeArray();
                var url = '<?php echo e(route('result.principal.comment.upload')); ?>';

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble(button, false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createPrincipalCommentModal").modal('toggle');
                    }
                }).fail((res) => {
                    toggleAble(button, false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.psychomotor.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                psy = data
                if(data.length > 0){
                    $("#psychomoting").css("display", "none");
                }
            });

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.affective.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#affecting").css("display", "none");
                }
            })

            $.ajax({
                type: "GET",
                url: "<?php echo e(route('result.cummulative.get')); ?>",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#cummulative").css("display", "none");
                }
            })
            
        });
    </script>

    <script>
       
        $('.getStudents').on('change', function() {
            var id = $(this).val();
            
            $.ajax({
                url: "<?php echo e(route('')); ?>",
                method: 'GET',
                data: { levelId: levelId, attendanceId: attendanceId },
                success: function(response) {
                    var students = response.students;
                    console.log(students)
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        });
    </script>
    <?php $__env->stopSection(); ?>

</div>
<?php /**PATH C:\laragon\www\primary\resources\views\livewire\components\admin\result\general-primary.blade.php ENDPATH**/ ?>