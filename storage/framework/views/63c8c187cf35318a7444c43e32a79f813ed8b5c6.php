
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Result Affective"); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">Result</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Affective</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <div class="mt-2">

                            <form id="fetchStudent">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" id="grade_id" name="grade_id">
                                            <option value=''>Class</option>
                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
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

                                    <div class="col-lg-3">
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
                                    
                                    <div class="col-lg-3">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <button type="submit" id="fetchStudentButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i> fetch
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <form id="commentForm">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="period_id" id="periodId" value="" />
                                <input type="hidden" name="term_id" id="termId" value="" />

                                <div class="table-responsive">
                                    <table id="affective-data" class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <?php
                                                $affectives = get_settings('affective_domain');
                                            ?>
                                            <tr>
                                                <th class="text-center"  style="width: 300px">Name of Student</th>
                                                <?php $__currentLoopData = $affectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $affective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th class="text-center"><?php echo e($key+1); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    
                                    <div id="noAffectiveList" class="my-2 text-center d-none">
                                        <p class="text-danger">The following student's affective domain has not been computed</p>
                                        <p class="listNoAffective"></p>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" id="submitComment" class="btn btn-success rounded-pill px-4">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $('#fetchStudent').on('submit', function(e){
                e.preventDefault();

                var button = $('#fetchStudentButton');
                toggleAble(button, true, 'Fetching...');

                var grade = $('#grade_id').val();
                var period = $('#period_id').val();
                var term = $('#term_id').val();

                $.ajax({
                    url: '<?php echo e(route("grade.students", ["grade" => ":grade_id"])); ?>'.replace(':grade_id', grade),
                    type: 'GET',
                    dataType: 'json',
                }).done((response) => {
                    var students = response.student;

                    $.ajax({
                        url: '<?php echo e(route("student.affectives", ["period" => ":period_id", "term" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        var affectives = res.affectives;

                        $('#periodId').val(period);
                        $('#termId').val(term);

                        displayAffective(students, affectives);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                    });
                    
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                });
            });

            function displayAffective(students, initialData){
                var tableRows = '';
                var listAffectives = <?php echo json_encode(get_settings('affective_domain'), 15, 512) ?>;

                students.forEach(function(student) {

                    var affectivesList = '';
                    listAffectives.forEach(function(domain, index) {
                        var radioButtons = '';

                        for (var i = 1; i <= 5; i++) {
                            var psycho = initialData.find(psycho => psycho.student_id === student['id'] && psycho.title.trim() == domain.trim());
                            var isChecked = psycho && psycho.value == i ? 'checked' : '';

                            radioButtons += `
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-${student['id']}-${index + 1}-${i}-${domain}" name="affectives[${student['id']}][${domain}][]" value="${i}" ${isChecked} />
                                    <label class="form-check-label" for="checkbox-${student['id']}-${index + 1}-${i}">${i}</label>
                                </div>
                            `;
                        }
                        affectivesList += `<td>${domain}${radioButtons}</td>`;
                    });

                    tableRows += `
                        <tr>
                            <td class="text-left" style="width: 300px">
                                ${student['name']}
                                <input type="hidden" class="form-control" id="student-${student['id']}" name="students[]" value="${student['id']}" />
                            </td>
                            ${affectivesList}
                        </tr>
                    `;
                });

                $('#affective-data tbody').html(tableRows);
            }


            $('#commentForm').on('submit', function(e){
                e.preventDefault();
                var button = $('#submitComment');
                toggleAble(button, true, 'Updating...');

                var data = $(this).serializeArray();
                var url = "<?php echo e(route('result.batchAffective')); ?>";

                $.ajax({
                    url,
                    type: 'POST',
                    data,
                }).done((response) => {
                    toggleAble(button, false);
                    toastr.success(response.message);
                    resetForm('#commentForm');
                    var no_affective_count = response.no_affective.count;
                    var no_affective = response.no_affective.data;

                    var listRow = '';
                    if (no_affective_count > 0) {
                        no_affective.forEach(function(name, index) {
                            listRow += (index < no_affective_count - 1) ? `${name}, ` : `${name}.`;
                        });
                        $('#noAffectiveList .listNoAffective').html(listRow);
                        $('#noAffectiveList').removeClass('d-none'); 
                    } else {
                        $('#noAffectiveList').addClass('d-none');
                    }

                    setTimeout(() => {
                        $('#noAffectiveList').addClass('d-none');
                    }, 10000);

                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                    console.log(error);
                });
            });
            
        </script>
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\class_affective.blade.php ENDPATH**/ ?>