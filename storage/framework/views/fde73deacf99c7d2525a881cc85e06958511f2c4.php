<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Result Statistic Page"); ?>
    <?php $__env->startSection('styles'); ?>
        <style>
            .stat-page {
                display: flex;
                flex-direction: column;
                gap: 2.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: #ffffff;
                border-radius: 22px;
                padding: 32px;
                box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
                border: 1px solid rgba(148, 163, 184, 0.16);
            }

            .stat-card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1.5rem;
                margin-bottom: 1.75rem;
            }

            .stat-card-title {
                font-size: 1.45rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 0.35rem;
            }

            .stat-card-subtitle {
                margin: 0;
                color: #64748b;
                font-size: 0.95rem;
            }

            .stat-filter {
                background: rgba(15, 23, 42, 0.02);
                border: 1px solid rgba(148, 163, 184, 0.18);
                border-radius: 18px;
                padding: 20px;
            }

            .stat-filter-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
                gap: 1rem;
                align-items: end;
            }

            .stat-field label {
                display: block;
                font-size: 0.82rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.45rem;
            }

            .stat-field .form-control {
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.35);
                padding: 0.55rem 0.75rem;
                font-size: 0.92rem;
                color: #0f172a;
            }

            .stat-field .form-control:focus {
                border-color: rgba(99, 102, 241, 0.65);
                box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.15);
            }

            .generate-btn {
                width: 100%;
                border: none;
                border-radius: 12px;
                padding: 0.75rem 1rem;
                font-weight: 600;
                color: #ffffff;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .generate-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 16px 32px rgba(99, 102, 241, 0.2);
            }

            .stat-table-wrapper {
                margin-top: 24px;
                border-radius: 18px;
                border: 1px solid rgba(148, 163, 184, 0.16);
                overflow: hidden;
                background: #ffffff;
            }

            .stat-table thead th {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #ffffff;
                background: linear-gradient(135deg, #1d4ed8 0%, #7c3aed 100%);
                border: none;
                padding: 0.85rem 0.75rem;
                text-align: center;
            }

            .stat-table tbody td {
                font-size: 0.9rem;
                padding: 0.9rem 0.75rem;
                border-top: 1px solid rgba(226, 232, 240, 0.7);
                color: #1e293b;
            }

            .stat-table tbody tr:hover {
                background: rgba(129, 140, 248, 0.08);
            }

            .stat-table tbody td.text-start {
                text-align: left !important;
            }

            .stat-table tbody td.text-center {
                text-align: center !important;
            }

            .stat-table tbody td.fw-semibold {
                font-weight: 600;
            }

            .stat-empty-row td {
                text-align: center;
                color: #64748b;
                padding: 1.5rem;
                font-style: italic;
            }

            .stat-card-footer {
                display: flex;
                justify-content: flex-end;
                margin-top: 20px;
            }

            .stat-download-form {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
            }

            .stat-download-btn {
                border: none;
                border-radius: 12px;
                background: linear-gradient(135deg, #22c55e 0%, #14b8a6 100%);
                color: #ffffff;
                padding: 0.7rem 1.2rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .stat-download-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                box-shadow: none;
                transform: none;
            }

            .stat-download-btn:not(:disabled):hover {
                transform: translateY(-1px);
                box-shadow: 0 14px 30px rgba(14, 165, 233, 0.2);
            }

            @media (max-width: 767px) {
                .stat-card {
                    padding: 24px;
                }

                .stat-card-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .stat-filter {
                    padding: 16px;
                }
            }
        </style>
    <?php $__env->stopSection(); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h4 class="mb-sm-0 font-size-18">Grade Result</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Statistic</li>
            </ol>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="stat-page">
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <h2 class="stat-card-title">Students Class Ranking</h2>
                    <p class="stat-card-subtitle">Compare cumulative totals and positions for every student in the selected class.</p>
                </div>
            </div>

            <form id="class-performance" class="stat-filter">
                <div class="stat-filter-grid">
                    <div class="stat-field">
                        <label for="class-performance-grade">Class</label>
                        <select class="form-control" id="class-performance-grade" name="grade_id">
                            <option value="">Select Class</option>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>"><?php echo e($class->title()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="stat-field">
                        <label for="class-performance-period">Session</label>
                        <select class="form-control" id="class-performance-period" name="period_id">
                            <option value="">Select Session</option>
                            <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($session->id()); ?>"><?php echo e($session->title()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="stat-field">
                        <label>&nbsp;</label>
                        <button id="class-performance-btn" type="submit" class="generate-btn">
                            <i class="bx bx-search-alt"></i>
                            Generate Sheet
                        </button>
                    </div>
                </div>
            </form>

            <div class="stat-table-wrapper">
                <div class="table-responsive">
                    <table class="table stat-table align-middle table-nowrap" id="class-data">
                        <thead>
                            <tr>
                                <th class="text-start">#</th>
                                <th class="text-start">Name</th>
                                <th class="text-center">1st Term</th>
                                <th class="text-center">2nd Term</th>
                                <th class="text-center">3rd Term</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Position in Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="stat-empty-row">
                                <td colspan="7">Run a search to populate this table.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                                <?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views\admin\result\statistic.blade.php ENDPATH**/ ?>
                            <i class="bx bx-search-alt"></i>
                            Generate Sheet
                        </button>
                    </div>
                </div>
            </form>

            <div class="stat-table-wrapper">
                <div class="table-responsive">
                    <table class="table stat-table align-middle table-nowrap" id="subject-data">
                        <thead>
                            <tr>
                                <th class="text-start">#</th>
                                <th class="text-start">Name</th>
                                <th class="text-center">1st Term</th>
                                <th class="text-center">2nd Term</th>
                                <th class="text-center">3rd Term</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Position in Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="stat-empty-row">
                                <td colspan="7">Run a search to populate this table.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="stat-card-footer">
                <form action="<?php echo e(route('result.download.subject.statistic')); ?>" method="POST" class="stat-download-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="grade_id" id="download_grade_id" />
                    <input type="hidden" name="subject_id" id="download_subject_id" />
                    <input type="hidden" name="period_id" id="download_period_id" />
                    <button type="submit" class="stat-download-btn" id="download_subject_btn" disabled>
                        <i class="bx bx-download"></i>
                        Download
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $(function () {
                const safeScore = (value) => {
                    const parsed = parseInt(value, 10);
                    return Number.isNaN(parsed) ? 0 : parsed;
                };

                const safeText = (value, fallback = '-') => (value ? value : fallback);

                const setTableMessage = (selector, message) => {
                    const columnCount = $(`${selector} thead tr th`).length || 1;
                    $(`${selector} tbody`).html(`<tr class="stat-empty-row"><td colspan="${columnCount}">${message}</td></tr>`);
                };

                $(document).on('submit', '#class-performance', function (e) {
                    e.preventDefault();
                    const button = '#class-performance-btn';
                    toggleAble(button, true, 'Generating stat...');

                    const grade = $('#class-performance-grade').val();
                    const period = $('#class-performance-period').val();

                    if (!grade || !period) {
                        toggleAble(button, false);
                        Swal.fire('Missing Filters', 'Select both class and session to generate the sheet.', 'warning');
                        return;
                    }

                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.statistic.class.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id"])); ?>'
                            .replace(':grade_id', grade)
                            .replace(':period_id', period),
                    }).done((response) => {
                        toggleAble(button, false);
                        const students = response.students || [];

                        if (!students.length) {
                            setTableMessage('#class-data', 'No records found for the selected filters.');
                            $('#download_class_btn').prop('disabled', true);
                            return;
                        }

                        let html = '';
                        $.each(students, function (index, student) {
                            html += '<tr>';
                            html += '<td class="text-start">' + (index + 1) + '</td>';
                            html += '<td class="text-start">' + safeText(student.student_name, 'N/A') + '</td>';
                            html += '<td class="text-center">' + safeScore(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.third_term_total) + '</td>';
                            html += '<td class="text-center fw-semibold">' + safeScore(student.total) + '</td>';
                            html += '<td class="text-center">' + safeText(student.position) + '</td>';
                            html += '</tr>';
                        });

                        $('#class-data tbody').html(html);
                        document.getElementById('download_class_grade_id').value = grade;
                        document.getElementById('download_class_period_id').value = period;
                        $('#download_class_btn').prop('disabled', false);
                    }).fail((error) => {
                        toggleAble(button, false);
                        $('#download_class_btn').prop('disabled', true);
                        setTableMessage('#class-data', 'Unable to load data at the moment.');
                        const message = error.responseJSON && error.responseJSON.message
                            ? error.responseJSON.message
                            : 'Something went wrong while generating the sheet.';
                        Swal.fire('Error', message, 'error');
                    });
                });

                $(document).on('submit', '#grade-performance', function (e) {
                    e.preventDefault();
                    const button = '#grade-performance-btn';
                    toggleAble(button, true, 'Generating stat...');

                    const grade = $('#grade-performance-grade').val();
                    const period = $('#grade-performance-period').val();

                    if (!grade || !period) {
                        toggleAble(button, false);
                        Swal.fire('Missing Filters', 'Select both class and session to generate the sheet.', 'warning');
                        return;
                    }

                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.statistic.grade.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id"])); ?>'
                            .replace(':grade_id', grade)
                            .replace(':period_id', period),
                    }).done((response) => {
                        toggleAble(button, false);
                        const students = response.students || [];

                        if (!students.length) {
                            setTableMessage('#student-data', 'No records found for the selected filters.');
                            $('#download_grade_btn').prop('disabled', true);
                            return;
                        }

                        let html = '';
                        $.each(students, function (index, student) {
                            html += '<tr>';
                            html += '<td class="text-start">' + (index + 1) + '</td>';
                            html += '<td class="text-start">' + safeText(student.student_name, 'N/A') + '</td>';
                            html += '<td class="text-center">' + safeScore(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.third_term_total) + '</td>';
                            html += '<td class="text-center fw-semibold">' + safeScore(student.total) + '</td>';
                            html += '<td class="text-center">' + safeText(student.position) + '</td>';
                            html += '</tr>';
                        });

                        $('#student-data tbody').html(html);
                        document.getElementById('download_grade_grade_id').value = grade;
                        document.getElementById('download_grade_period_id').value = period;
                        document.getElementById('download_grade_subject_id').value = '';
                        $('#download_grade_btn').prop('disabled', false);
                    }).fail((error) => {
                        toggleAble(button, false);
                        $('#download_grade_btn').prop('disabled', true);
                        setTableMessage('#student-data', 'Unable to load data at the moment.');
                        const message = error.responseJSON && error.responseJSON.message
                            ? error.responseJSON.message
                            : 'Something went wrong while generating the sheet.';
                        Swal.fire('Error', message, 'error');
                    });
                });

                $(document).on('submit', '#subject-performance', function (e) {
                    e.preventDefault();
                    const button = '#subject-performance-btn';
                    toggleAble(button, true, 'Generating stat...');

                    const grade = $('#subject-performance-grade').val();
                    const period = $('#subject-performance-period').val();
                    const subject = $('#subject-performance-subject').val();

                    if (!grade || !period || !subject) {
                        toggleAble(button, false);
                        Swal.fire('Missing Filters', 'Select class, subject, and session to generate the sheet.', 'warning');
                        return;
                    }

                    $.ajax({
                        method: 'GET',
                        url: '<?php echo e(route('result.statistic.subject.generate', ["grade_id" => ":grade_id", "period_id" => ":period_id", "subject_id" => ":subject_id"])); ?>'
                            .replace(':grade_id', grade)
                            .replace(':period_id', period)
                            .replace(':subject_id', subject),
                    }).done((response) => {
                        toggleAble(button, false);
                        const students = response.students || [];

                        if (!students.length) {
                            setTableMessage('#subject-data', 'No records found for the selected filters.');
                            $('#download_subject_btn').prop('disabled', true);
                            return;
                        }

                        let html = '';
                        $.each(students, function (index, student) {
                            html += '<tr>';
                            html += '<td class="text-start">' + (index + 1) + '</td>';
                            html += '<td class="text-start">' + safeText(student.student_name, 'N/A') + '</td>';
                            html += '<td class="text-center">' + safeScore(student.first_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.second_term_total) + '</td>';
                            html += '<td class="text-center">' + safeScore(student.third_term_total) + '</td>';
                            html += '<td class="text-center fw-semibold">' + safeScore(student.total) + '</td>';
                            html += '<td class="text-center">' + safeText(student.position) + '</td>';
                            html += '</tr>';
                        });

                        $('#subject-data tbody').html(html);
                        document.getElementById('download_grade_id').value = grade;
                        document.getElementById('download_subject_id').value = subject;
                        document.getElementById('download_period_id').value = period;
                        $('#download_subject_btn').prop('disabled', false);
                    }).fail((error) => {
                        toggleAble(button, false);
                        $('#download_subject_btn').prop('disabled', true);
                        setTableMessage('#subject-data', 'Unable to load data at the moment.');
                        const message = error.responseJSON && error.responseJSON.message
                            ? error.responseJSON.message
                            : 'Something went wrong while generating the sheet.';
                        Swal.fire('Error', message, 'error');
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
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/statistic.blade.php ENDPATH**/ ?>