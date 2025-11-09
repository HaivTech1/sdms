
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Result Comment"); ?>
    <?php $__env->startSection('styles'); ?>
        <style>
            .comment-page {
                padding: 1.5rem 0;
            }

            .comment-card {
                background: #ffffff;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
                border: 1px solid rgba(148, 163, 184, 0.15);
                overflow: hidden;
            }

            .comment-header {
                background: #4f46e5;
                color: #ffffff;
                padding: 2rem;
                text-align: center;
            }

            .comment-title {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #ffffff;
            }

            .comment-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin: 0;
            }

            .filter-section {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 2rem;
            }

            .filter-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                align-items: end;
            }

            .filter-field label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }

            .filter-field .form-control {
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.3);
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                transition: all 0.2s ease;
            }

            .filter-field .form-control:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .fetch-btn {
                background: #4f46e5;
                border: none;
                border-radius: 8px;
                color: #ffffff;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s ease;
                width: 100%;
                justify-content: center;
            }

            .fetch-btn:hover {
                background: #3730a3;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            }

            .fetch-btn i {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                padding: 4px;
                font-size: 0.875rem;
            }

            .assessment-section {
                padding: 2rem;
            }

            .assessment-table-wrapper {
                border-radius: 12px;
                overflow-x: auto;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                -webkit-overflow-scrolling: touch;
            }

            .assessment-table {
                margin: 0;
                width: 100%;
                min-width: 800px;
            }

            .assessment-table thead th {
                background: #4f46e5;
                color: #ffffff;
                font-size: 0.875rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 1rem 0.75rem;
                border: none;
                text-align: center;
            }

            .assessment-table tbody td {
                padding: 1rem 0.75rem;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
                background: #ffffff;
            }

            .assessment-table tbody tr {
                transition: background-color 0.2s ease;
            }

            .assessment-table tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            .assessment-table tbody tr:hover {
                background: #f0f4ff;
            }

            .student-name-cell {
                font-weight: 600;
                color: #1e293b;
                min-width: 250px;
            }

            .comment-input {
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                width: 100%;
            }

            .comment-input:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
                outline: none;
            }

            .attendance-input {
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                width: 100%;
                text-align: center;
            }

            .attendance-input:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
                outline: none;
            }

            .save-section {
                padding: 2rem;
                text-align: center;
                border-top: 1px solid #e2e8f0;
                background: #f8fafc;
            }

            .save-btn {
                background: #10b981;
                border: none;
                border-radius: 8px;
                color: #ffffff;
                font-weight: 600;
                padding: 0.875rem 2rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s ease;
                min-width: 140px;
                justify-content: center;
            }

            .save-btn:hover {
                background: #059669;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
            }

            @media (max-width: 768px) {
                .filter-grid {
                    grid-template-columns: 1fr;
                }

                .comment-header {
                    padding: 1.5rem;
                }

                .assessment-section,
                .filter-section,
                .save-section {
                    padding: 1rem;
                }

                .assessment-table-wrapper {
                    margin: 0 -1rem;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                }

                .assessment-table {
                    min-width: 600px;
                }

                .assessment-table thead th,
                .assessment-table tbody td {
                    padding: 0.5rem 0.4rem;
                    font-size: 0.8rem;
                }

                .student-name-cell {
                    min-width: 150px;
                }
            }

            @media (max-width: 576px) {
                .comment-header {
                    padding: 1rem;
                    text-align: center;
                }

                .comment-title {
                    font-size: 1.4rem;
                }

                .comment-subtitle {
                    font-size: 0.9rem;
                }

                .assessment-table {
                    min-width: 500px;
                }

                .assessment-table thead th,
                .assessment-table tbody td {
                    padding: 0.4rem 0.3rem;
                    font-size: 0.75rem;
                }

                .comment-input,
                .attendance-input {
                    font-size: 0.75rem;
                    padding: 0.4rem 0.5rem;
                }
            }
        </style>
    <?php $__env->stopSection(); ?>

    <div class="comment-page">
        <div class="row">
            <div class="col-12">
                <div class="comment-card">
                    <div class="comment-header">
                        <h5 class="comment-title">Student Comments & Attendance</h5>
                        <p class="comment-subtitle">Manage student comments and attendance records</p>
                    </div>

                    <div class="filter-section">
                        <form id="fetchStudent">
                            <div class="filter-grid">
                                <div class="filter-field">
                                    <label for="grade_id">Class</label>
                                    <select class="form-control" id="grade_id" name="grade_id">
                                        <option value=''>Select Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <div class="filter-field">
                                    <label for="period_id">Session</label>
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

                                <div class="filter-field">
                                    <label for="term_id">Term</label>
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
                                
                                <div class="filter-field">
                                    <label>&nbsp;</label>
                                    <button type="submit" id="fetchStudentButton" class="fetch-btn">
                                        <i class="bx bx-search-alt"></i>
                                        Load Students
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="assessment-section">

                        <form id="commentForm">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="period_id" id="periodId" value="" />
                            <input type="hidden" name="term_id" id="termId" value="" />

                            <div class="assessment-table-wrapper">
                                <table id="comment-data" class="table assessment-table">
                                    <thead>
                                        <tr>
                                            <th class="text-start" style="width: 35%;">Student Name</th>
                                            <th class="text-center">Comment</th>
                                            <th class="text-center" style="width: 15%;">Total Present</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>

                    <div class="save-section">
                        <button type="submit" form="commentForm" id="submitComment" class="save-btn">
                            <i class="bx bx-save"></i>
                            Save Comments
                        </button>
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
                        url: '<?php echo e(route("student.cognitives", ["period" => ":period_id", "term" => ":term_id"])); ?>'.replace(':period_id', period).replace(':term_id', term),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        var cognitives = res.cognitives;

                        $('#periodId').val(period);
                        $('#termId').val(term);

                        displayComment(students, cognitives);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                    });
                    
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                });
            });

            function displayComment(data, initialData){
                var tableRows = '';

                data.forEach(function(student) {

                    var comment = initialData.find(cognitive => cognitive.student_id === student['id']);
                    tableRows += `
                        <tr>
                            <td class="student-name-cell" style="width: 35%;">
                                ${student['name']}
                                <input type="hidden" class="form-control" id="student-${student['id']}" name="students[]" value="${student['id']}" />
                            </td>
                            <td>
                                <input type="text" class="comment-input" id="comment-${student['id']}" name="comments[]" value="${comment && comment.comment !== null ? comment.comment : ''}" placeholder="Enter comment..." />
                            </td>
                            <td style="width: 15%;">
                                <input type="text" class="attendance-input" id="attendance-${student['id']}" name="attendances[]" value="${comment && comment.present !== null ? comment.present : ''}" placeholder="0" />
                            </td>
                        </tr>
                    `;
                });

                $('#comment-data tbody').html(tableRows);
            }


            $('#commentForm').on('submit', function(e){
                e.preventDefault();
                var button = $('#submitComment');
                toggleAble(button, true, 'Updating...');

                var data = $(this).serializeArray();
                var url = "<?php echo e(route('result.batchcognitive')); ?>";

                $.ajax({
                    url,
                    type: 'POST',
                    data,
                }).done((response) => {
                    toggleAble(button, false);
                    toastr.success(response.message);
                    resetForm('#commentForm');
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
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/class_comment.blade.php ENDPATH**/ ?>