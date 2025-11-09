<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | View Result Page"); ?>
    <?php $__env->startSection('styles'); ?>
        <style>
            .search-card {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
                padding: 24px;
                border: 1px solid rgba(148, 163, 184, 0.15);
            }

            .search-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .search-header p {
                color: #64748b;
                font-size: 0.875rem;
            }

            .search-btn {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                border: none;
                border-radius: 12px;
                color: #ffffff;
                font-weight: 600;
                padding: 12px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .search-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 15px 30px rgba(99, 102, 241, 0.25);
            }

            .student-panel {
                background: #ffffff;
                border-radius: 18px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
                padding: 24px;
                border: 1px solid rgba(148, 163, 184, 0.16);
                height: 100%;
            }

            .student-panel-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .student-count-badge {
                background: rgba(99, 102, 241, 0.1);
                color: #4338ca;
                font-weight: 600;
                border-radius: 999px;
                padding: 6px 14px;
            }

            .student-list {
                max-height: 620px;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .student-card {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px 18px;
                border-radius: 14px;
                border: 1px solid rgba(148, 163, 184, 0.12);
                background: #f8fafc;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .student-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
                border-color: rgba(99, 102, 241, 0.35);
            }

            .student-card.selected {
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(139, 92, 246, 0.15) 100%);
                border-color: rgba(99, 102, 241, 0.45);
                box-shadow: 0 20px 45px rgba(99, 102, 241, 0.18);
            }

            .student-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .student-name {
                font-weight: 600;
                color: #1e293b;
            }

            .student-meta {
                font-size: 0.8rem;
                color: #64748b;
            }

            .student-status i {
                font-size: 1.1rem;
                color: #cbd5f5;
            }

            .student-card.has-results .student-status i {
                color: #16a34a;
            }

            .student-card.no-results .student-status i {
                color: #dc2626;
            }

            .result-panel {
                background: rgba(15, 23, 42, 0.02);
                border-radius: 22px;
                padding: 3px;
                height: 100%;
            }

            .result-panel-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 18px;
                padding: 0 12px;
            }

            .save-btn {
                background: linear-gradient(135deg, #22c55e 0%, #14b8a6 100%);
                border: none;
                color: #ffffff;
                padding: 10px 18px;
                border-radius: 12px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .save-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 15px 30px rgba(34, 197, 94, 0.25);
            }

            .result-content {
                background: linear-gradient(135deg, #1e3a8a 0%, #9333ea 100%);
                border-radius: 18px;
                min-height: 620px;
                overflow: hidden;
                position: relative;
                padding: 0;
            }

            .result-content::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.2), transparent 55%);
                pointer-events: none;
            }

            .no-selection,
            .no-result-message {
                text-align: center;
                color: rgba(255, 255, 255, 0.9);
                padding: 120px 20px;
                position: relative;
                z-index: 1;
            }

            .no-selection-icon,
            .no-result-icon {
                font-size: 3rem;
                margin-bottom: 16px;
                opacity: 0.75;
            }

            .student-result-detail {
                position: relative;
                z-index: 1;
                padding: 32px;
                color: #0f172a;
            }

            .result-summary {
                background: rgba(255, 255, 255, 0.92);
                border-radius: 18px;
                padding: 22px;
                margin-bottom: 28px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
            }

            .summary-item {
                background: rgba(15, 23, 42, 0.04);
                border-radius: 14px;
                padding: 14px;
            }

            .summary-item label {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #64748b;
                display: block;
                margin-bottom: 6px;
            }

            .summary-value {
                font-size: 1.25rem;
                font-weight: 700;
                color: #1e293b;
            }

            .subjects-section,
            .comments-section {
                background: rgba(255, 255, 255, 0.94);
                border-radius: 18px;
                padding: 22px;
                margin-bottom: 28px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
            }

            .section-title {
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 18px;
            }

            .table-responsive {
                border-radius: 14px;
                overflow: hidden;
                border: 1px solid rgba(148, 163, 184, 0.18);
            }

            .result-table {
                width: 100%;
                border-collapse: collapse;
                background: #ffffff;
            }

            .result-table th {
                background: linear-gradient(135deg, #1d4ed8 0%, #7c3aed 100%);
                color: #ffffff;
                font-size: 0.75rem;
                font-weight: 600;
                letter-spacing: 0.05em;
                padding: 12px 10px;
                text-transform: uppercase;
            }

            .result-table td {
                padding: 12px 10px;
                font-size: 0.85rem;
                color: #1f2937;
                border-top: 1px solid rgba(226, 232, 240, 0.7);
            }

            .result-table tbody tr:hover {
                background: rgba(129, 140, 248, 0.1);
            }

            .result-table td.text-start {
                font-weight: 600;
            }

            .comment-group textarea {
                border-radius: 14px;
                border: 1px solid rgba(148, 163, 184, 0.28);
                padding: 14px;
                min-height: 110px;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .comment-group textarea:focus {
                border-color: rgba(99, 102, 241, 0.7);
                box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.2);
            }

            .no-result-message {
                padding: 90px 20px;
            }

            .no-result-message p {
                color: rgba(255, 255, 255, 0.8);
            }

            .result-panel-footer {
                display: flex;
                justify-content: flex-end;
                padding: 0 12px 12px;
                margin-top: 12px;
            }

            .result-panel-footer .save-btn {
                min-width: 160px;
            }

            .loading-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.12);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                backdrop-filter: blur(6px);
            }

            @media (max-width: 991px) {
                .student-list {
                    max-height: none;
                }

                .result-content {
                    min-height: 520px;
                }

                .student-result-detail {
                    padding: 24px;
                }
            }

            @media (max-width: 575px) {
                .search-card,
                .student-panel {
                    padding: 18px;
                }

                .result-panel-header {
                    flex-direction: column;
                    gap: 12px;
                    align-items: flex-start;
                }

                .save-btn {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    <?php $__env->stopSection(); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h4 class="mb-sm-0 font-size-18">View Results</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Result</li>
                </ol>
            </div>
         <?php $__env->endSlot(); ?>

        <div class="loading-overlay d-none" id="loadingOverlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="search-card">
                    <div class="search-header">
                        <h5 class="mb-0">Class Results Management</h5>
                        <p class="mb-0">Select class parameters to view and manage student results</p>
                    </div>
                    <div class="search-body">
                        <form id="resultSearchForm">
                            <div class="row g-3">
                                <div class="col-lg-3">
                                    <label class="form-label">Class</label>
                                    <select class="form-control" id="gradeSelect" name="grade_id">
                                        <option value=''>Select Class</option>
                                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->id()); ?>"><?php echo e($grade->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Session</label>
                                    <select class="form-control" id="periodSelect" name="period_id">
                                        <option value=''>Select Session</option>
                                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($period->id()); ?>"><?php echo e($period->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Term</label>
                                    <select class="form-control" id="termSelect" name="term_id">
                                        <option value=''>Select Term</option>
                                        <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($term->id()); ?>"><?php echo e($term->title()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="search-btn">
                                            <i class="bx bx-search-alt me-1"></i> Load Results
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two-Column Results Layout -->
        <div class="result-container" id="resultContainer" style="display: none;">
            <div class="row g-4">
                <!-- Left Column - Student List -->
                <div class="col-lg-4">
                    <div class="student-panel">
                        <div class="student-panel-header">
                            <h6 class="mb-0">Class Students</h6>
                            <div class="student-count-badge" id="studentCount">0 Students</div>
                        </div>
                        <div class="student-list" id="studentList">
                            <!-- Students will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Right Column - Result Display -->
                <div class="col-lg-8">
                    <div class="result-panel">
                        <div class="result-panel-header">
                            <div>
                                <h6 class="mb-0">Student Result</h6>
                                <small class="text-muted" id="selectedStudentName">Select a student to view results</small>
                            </div>
                        </div>
                        <div class="result-content" id="resultContent">
                            <div class="no-selection">
                                <div class="no-selection-icon">
                                    <i class="bx bx-user-check"></i>
                                </div>
                                <h6>No Student Selected</h6>
                                <p>Choose a student from the left panel to view their detailed results</p>
                            </div>
                        </div>
                        <div class="result-panel-footer" id="saveButtonContainer" style="display: none;">
                            <button type="button" class="save-btn" id="saveAllComments">
                                <i class="bx bx-save me-1"></i> Save Comments
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $__env->startSection('scripts'); ?>
        <script>
        $(document).ready(function() {
            const gradeSelect = $('#gradeSelect');
            const resultSearchForm = $('#resultSearchForm');
            const resultContainer = $('#resultContainer');
            const studentList = $('#studentList');
            const resultContent = $('#resultContent');
            const loadingOverlay = $('#loadingOverlay');
            const studentCount = $('#studentCount');
            const selectedStudentName = $('#selectedStudentName');
            const saveButtonContainer = $('#saveButtonContainer');
            const saveAllCommentsBtn = $('#saveAllComments');
            
            let currentPeriodId = null;
            let currentTermId = null;
            let currentGradeId = null;
            let studentsData = [];
            let selectedStudentIndex = null;

            // Handle result search form submission
            resultSearchForm.on('submit', function(e) {
                e.preventDefault();
                
                const formData = {
                    grade_id: $('#gradeSelect').val(),
                    period_id: $('#periodSelect').val(),
                    term_id: $('#termSelect').val()
                };

                // Validate required fields
                if (!formData.grade_id || !formData.period_id || !formData.term_id) {
                    Swal.fire('Error', 'Please fill in all required fields', 'error');
                    return;
                }

                currentPeriodId = formData.period_id;
                currentTermId = formData.term_id;
                currentGradeId = formData.grade_id;
                saveButtonContainer.hide();
                fetchClassResults(formData);
            });

            // Handle save all comments
            saveAllCommentsBtn.on('click', function() {
                saveStudentComment();
            });

            function fetchClassResults(data) {
                showLoading();
                resultContainer.hide();
                
                // First get the students for this grade
                $.ajax({
                    url: '<?php echo e(route("student.list.data")); ?>',
                    method: 'GET',
                    data: { grade: data.grade_id },
                    success: function(response) {
                        if (response.data) {
                            const students = response.data || [];
                            fetchAllStudentResults(students, data);
                        } else {
                            hideLoading();
                            Swal.fire('Error', 'Failed to load students', 'error');
                        }
                    },
                    error: function() {
                        hideLoading();
                        Swal.fire('Error', 'Failed to load students', 'error');
                    }
                });
            }

            function fetchAllStudentResults(students, searchData) {
                const promises = students.map(student => {
                    return $.ajax({
                        url: '<?php echo e(route("result.student.result")); ?>',
                        method: 'POST',
                        data: {
                            grade_id: searchData.grade_id,
                            student_id: student.id,
                            period_id: searchData.period_id,
                            term_id: searchData.term_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                });

                Promise.allSettled(promises).then(results => {
                    const successfulResults = [];
                    
                    results.forEach((result, index) => {
                        if (result.status === 'fulfilled' && result.value.status) {
                            successfulResults.push({
                                student: students[index],
                                data: result.value.data
                            });
                        } else {
                            successfulResults.push({
                                student: students[index],
                                data: null,
                                hasResult: false
                            });
                        }
                    });

                    studentsData = successfulResults;
                    displayStudentList(successfulResults);
                    hideLoading();
                    resultContainer.show();
                });
            }

            function displayStudentList(studentsData) {
                studentCount.text(`${studentsData.length} Students`);
                
                let html = '';
                studentsData.forEach((studentData, index) => {
                    const { student, hasResult } = studentData;
                    const hasResults = hasResult !== false;
                    const statusClass = hasResults ? 'has-results' : 'no-results';
                    const statusIcon = hasResults ? 'bx-check-circle' : 'bx-x-circle';
                    
                    html += `
                        <div class="student-card ${statusClass}" data-index="${index}">
                            <div class="student-info">
                                <div class="student-name">
                                    ${student.last_name} ${student.first_name} ${student.other_name || ''}
                                </div>
                                <div class="student-meta">
                                    <span class="student-id">${student.reg_no || 'No ID'}</span>
                                </div>
                            </div>
                            <div class="student-status">
                                <i class="bx ${statusIcon}"></i>
                            </div>
                        </div>
                    `;
                });
                
                studentList.html(html);
                
                // Add click handlers for student selection
                $('.student-card').on('click', function() {
                    const index = $(this).data('index');
                    selectStudent(index);
                });
            }

            function selectStudent(index) {
                selectedStudentIndex = index;
                const studentData = studentsData[index];
                
                // Update UI
                $('.student-card').removeClass('selected');
                $(`.student-card[data-index="${index}"]`).addClass('selected');
                
                // Update selected student name
                const student = studentData.student;
                selectedStudentName.text(`${student.last_name} ${student.first_name} ${student.other_name || ''}`);
                
                // Display student result
                if (studentData.hasResult !== false) {
                    displayStudentResult(studentData);
                    saveButtonContainer.show();
                } else {
                    displayNoResult(student);
                    saveButtonContainer.hide();
                }
            }

            function displayStudentResult(studentData) {
                const { data } = studentData;
                const { results, student, period, term, grade, studentAttendance, aggregate, gradeStudents, marksObtained, markObtainable } = data;
                
                const midtermFormat = <?php echo json_encode(get_settings('midterm_format') ?? [], 15, 512) ?>;
                const examFormat = <?php echo json_encode(get_settings('exam_format') ?? [], 15, 512) ?>;
                
                let html = `
                    <div class="student-result-detail">
                        <!-- Result Summary -->
                        <div class="result-summary">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <label>Total Marks</label>
                                        <div class="summary-value">${marksObtained}/${markObtainable}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <label>Percentage</label>
                                        <div class="summary-value">${aggregate}%</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <label>Class Size</label>
                                        <div class="summary-value">${gradeStudents}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="summary-item">
                                        <label>Attendance</label>
                                        <div class="summary-value">${studentAttendance?.attendance_present || 0}/${studentAttendance?.attendance_duration || 0}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Results -->
                        <div class="subjects-section">
                            <h6 class="section-title">Subject Performance</h6>
                            ${generateResultTable(results, midtermFormat, examFormat, term.id)}
                        </div>

                        <!-- Comments Section -->
                        <div class="comments-section">
                            <h6 class="section-title">Comments</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="comment-group">
                                        <label class="form-label">Teacher's Comment</label>
                                        <textarea class="form-control teacher-comment" id="teacherComment" rows="3" placeholder="Enter teacher's comment...">${studentAttendance?.comment || ''}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="comment-group">
                                        <label class="form-label">Principal's Comment</label>
                                        <textarea class="form-control principal-comment" id="principalComment" rows="3" placeholder="Enter principal's comment...">${studentAttendance?.principal_comment || ''}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                resultContent.html(html);
            }

            function displayNoResult(student) {
                let html = `
                    <div class="no-result-message">
                        <div class="no-result-icon">
                            <i class="bx bx-file-blank"></i>
                        </div>
                        <h6>No Results Available</h6>
                        <p>No examination results found for <strong>${student.last_name} ${student.first_name}</strong> in the selected term.</p>
                    </div>
                `;
                
                resultContent.html(html);
            }

            function saveStudentComment() {
                if (selectedStudentIndex === null) {
                    Swal.fire('Error', 'Please select a student first', 'error');
                    return;
                }

                const student = studentsData[selectedStudentIndex].student;
                const teacherComment = $('#teacherComment').val();
                const principalComment = $('#principalComment').val();

                const commentData = {
                    student_uuid: student.id,
                    period_id: currentPeriodId,
                    term_id: currentTermId,
                    comment: teacherComment,
                    principal_comment: principalComment
                };

                $.ajax({
                    url: '<?php echo e(route("result.student.comment.update")); ?>',
                    method: 'POST',
                    data: commentData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Success', 'Comments saved successfully!', 'success');
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to save comments', 'error');
                    }
                });
            }

            function generateResultTable(results, midtermFormat, examFormat, termId) {
                let headers = '<tr><th>SUBJECTS</th>';
                
                // Add midterm headers
                Object.keys(midtermFormat).forEach(key => {
                    headers += `<th class="text-center">${key.toUpperCase()}</th>`;
                });
                
                // Add exam headers
                Object.keys(examFormat).forEach(key => {
                    headers += `<th class="text-center">${key.toUpperCase()}</th>`;
                });
                
                if (termId === '2') {
                    headers += '<th class="text-center">1ST TERM</th>';
                } else if (termId === '3') {
                    headers += '<th class="text-center">1ST TERM</th><th class="text-center">2ND TERM</th>';
                }
                
                headers += '<th class="text-center">TOTAL</th><th class="text-center">GRADE</th><th class="text-center">POSITION</th></tr>';

                let rows = '';
                results.forEach(result => {
                    let total = 0;
                    
                    // Calculate total based on term
                    if (termId === '2') {
                        total = calculateResult(result) + (result.first_term || 0) / 2;
                    } else if (termId === '3') {
                        total = secondaryAverage(result.first_term || 0, result.second_term || 0, calculateResult(result), 2);
                    } else {
                        total = calculateResult(result);
                    }

                    rows += `<tr>
                        <td class="text-start fw-bold">${result.subject}</td>`;
                    
                    // Add midterm scores
                    Object.keys(midtermFormat).forEach(key => {
                        rows += `<td class="text-center">${result[key] || '-'}</td>`;
                    });
                    
                    // Add exam scores
                    Object.keys(examFormat).forEach(key => {
                        rows += `<td class="text-center">${result[key] || '-'}</td>`;
                    });
                    
                    if (termId === '2') {
                        rows += `<td class="text-center">${result.first_term || '-'}</td>`;
                    } else if (termId === '3') {
                        rows += `<td class="text-center">${result.first_term || '-'}</td><td class="text-center">${result.second_term || '-'}</td>`;
                    }
                    
                    rows += `
                        <td class="text-center fw-bold">${Math.round(total)}</td>
                        <td class="text-center">A</td>
                        <td class="text-center">${result.position_in_class_subject || '-'}</td>
                    </tr>`;
                });

                return `
                    <div class="table-responsive">
                        <table class="result-table">
                            <thead>${headers}</thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                `;
            }

            function calculateResult(result) {
                const midtermFormat = <?php echo json_encode(get_settings('midterm_format') ?? [], 15, 512) ?>;
                const examFormat = <?php echo json_encode(get_settings('exam_format') ?? [], 15, 512) ?>;
                
                let total = 0;
                
                Object.keys(midtermFormat).forEach(key => {
                    total += parseInt(result[key] || 0);
                });
                
                Object.keys(examFormat).forEach(key => {
                    total += parseInt(result[key] || 0);
                });
                
                return total;
            }

            function secondaryAverage(first, second, third, by) {
                if (by <= 0) return Math.ceil(third);
                
                const one = first + second;
                const oneResult = one / 2;
                const two = oneResult + third;
                const twoResult = two / by;
                
                return Math.ceil(twoResult);
            }

            function showLoading() {
                loadingOverlay.removeClass('d-none');
            }

            function hideLoading() {
                loadingOverlay.addClass('d-none');
            }
        });
        </script>
        <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/result/view_result.blade.php ENDPATH**/ ?>