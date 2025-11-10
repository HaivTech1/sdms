<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', application('name')." | Teacher Students"); ?>
    <?php $__env->startSection('styles'); ?>
        <style>
            .students-page {
                padding: 1.5rem 0;
            }

            .students-card {
                background: #ffffff;
                border-radius: 15px;
                box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
                border: 1px solid rgba(148, 163, 184, 0.15);
                overflow: hidden;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .card-header {
                padding: 1.5rem 2rem;
                border-bottom: none;
            }
            
            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin: 0;
            }
            
            .card-text {
                font-size: 0.95rem;
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

            .search-btn {
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

            .search-btn:hover {
                background: #3730a3;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            }

            .search-btn i {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                padding: 4px;
                font-size: 0.875rem;
            }

            .students-section {
                padding: 2rem;
            }

            .students-table-wrapper {
                border-radius: 12px;
                overflow-x: auto;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                -webkit-overflow-scrolling: touch;
            }

            .students-table {
                margin: 0;
                width: 100%;
                min-width: 800px;
            }

            .students-table thead th {
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

            .students-table tbody td {
                padding: 1rem 0.75rem;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
                background: #ffffff;
            }

            .students-table tbody tr {
                transition: background-color 0.2s ease;
            }

            .students-table tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            .students-table tbody tr:hover {
                background: #f0f4ff;
            }

            .student-name {
                font-weight: 600;
                color: #1e293b;
            }

            .reg-number {
                font-family: 'Courier New', monospace;
                font-size: 0.875rem;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .reg-number:hover {
                transform: scale(1.05);
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .subject-count {
                font-size: 0.75rem;
                padding: 0.4rem 0.6rem;
                border-radius: 12px;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .action-btn {
                border-radius: 6px;
                padding: 0.4rem 0.6rem;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                border-width: 1px;
            }

            .action-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .students-table-wrapper {
                border-radius: 12px;
                overflow-x: auto;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                -webkit-overflow-scrolling: touch;
            }

            .students-table {
                margin: 0;
                width: 100%;
                min-width: 800px;
            }

            .students-table thead th {
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

            .students-table tbody td {
                padding: 1rem 0.75rem;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
                background: #ffffff;
            }

            .students-table tbody tr {
                transition: background-color 0.2s ease;
            }

            .students-table tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            .students-table tbody tr:hover {
                background: #f0f4ff;
            }

            .student-name {
                font-weight: 600;
                color: #1e293b;
            }

            .reg-number {
                color: #4f46e5;
                cursor: pointer;
                text-decoration: none;
                font-weight: 500;
            }

            .reg-number:hover {
                text-decoration: underline;
                color: #3730a3;
            }

            .subject-count {
                background: #e0e7ff;
                color: #4338ca;
                padding: 0.25rem 0.75rem;
                border-radius: 12px;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .action-btn {
                background: #10b981;
                border: none;
                border-radius: 6px;
                color: #ffffff;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .action-btn:hover {
                background: #059669;
                transform: translateY(-1px);
            }

            .modal .modal-content {
                border-radius: 12px;
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .modal .modal-header {
                background: #4f46e5;
                color: white;
                border-radius: 12px 12px 0 0;
                border-bottom: none;
            }

            .modal .modal-header .btn-close {
                filter: invert(1);
            }

            .modal .form-control {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                padding: 0.75rem 1rem;
                transition: all 0.2s ease;
            }

            .modal .form-control:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .pagination-section {
                padding: 1.5rem 2rem;
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
                text-align: center;
            }

            @media (max-width: 768px) {
                .filter-grid {
                    grid-template-columns: 1fr;
                }

                .students-header {
                    padding: 1.5rem;
                }

                .students-section,
                .filter-section {
                    padding: 1rem;
                }

                .students-table-wrapper {
                    margin: 0 -1rem;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                }

                .students-table {
                    min-width: 600px;
                }

                .students-table thead th,
                .students-table tbody td {
                    padding: 0.5rem 0.4rem;
                    font-size: 0.8rem;
                }
            }

            @media (max-width: 576px) {
                .students-header {
                    padding: 1rem;
                    text-align: center;
                }

                .students-title {
                    font-size: 1.4rem;
                }

                .students-subtitle {
                    font-size: 0.9rem;
                }

                .students-table {
                    min-width: 500px;
                }

                .students-table thead th,
                .students-table tbody td {
                    padding: 0.4rem 0.3rem;
                    font-size: 0.75rem;
                }
            }
        </style>
    <?php $__env->stopSection(); ?>

    <div class="students-page">
        <div class="row">
            <div class="col-12">
                <div class="students-card">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bx bx-users font-size-24"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Student Management</h5>
                                <p class="card-text mb-0 opacity-75">Manage your assigned students and their details</p>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <form id="filterStudents">
                            <div class="filter-grid">
                                <div class="filter-field">
                                    <label for="search">Search Students</label>
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by name...">
                                </div>
                                
                                <div class="filter-field">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value=''>All Genders</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Others</option>
                                    </select>
                                </div>

                                <div class="filter-field">
                                    <label for="grade">Grade/Class</label>
                                    <select class="form-control" id="grade" name="grade">
                                        <option value=''>All Grades</option>
                                        
                                    </select>
                                </div>

                                <div class="filter-field">
                                    <label for="sortBy">Sort Order</label>
                                    <select class="form-control" id="sortBy" name="sortBy">
                                        <option value='asc'>Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>

                                <div class="filter-field">
                                    <label for="orderBy">Order By</label>
                                    <select class="form-control" id="orderBy" name="orderBy">
                                        <option value='first_name'>First Name</option>
                                        <option value="last_name">Last Name</option>
                                    </select>
                                </div>
                                
                                <div class="filter-field">
                                    <label>&nbsp;</label>
                                    <button type="submit" id="searchStudentButton" class="search-btn">
                                        <i class="bx bx-search-alt"></i>
                                        Search Students
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="students-section">
                        <div class="students-table-wrapper">
                            <table class="students-table table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Registration Number</th>
                                        <th>Gender</th>
                                        <th>Grade/Class</th>
                                        <th>Subjects</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <!-- Students will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="noStudents" class="text-center py-4" style="display: none;">
                            <i class="bx bx-user-x font-size-48 text-muted"></i>
                            <h5 class="mt-2 text-muted">No students found</h5>
                            <p class="text-muted">Try adjusting your search criteria</p>
                        </div>
                    </div>

                    <div class="pagination-section" id="paginationSection" style="display: none;">
                        <!-- Pagination will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Load grades when page loads
            loadGrades();
            // Show initial empty state
            showInitialEmptyState();

            // Handle form submission
            $('#filterStudents').on('submit', function(e) {
                e.preventDefault();
                const gradeSelected = $('#grade').val();
                if (gradeSelected) {
                    loadStudents();
                } else {
                    showSelectGradeMessage();
                }
            });

            // Load students when grade is selected
            $('#grade').on('change', function() {
                const gradeSelected = $(this).val();
                if (gradeSelected) {
                    loadStudents();
                } else {
                    showInitialEmptyState();
                }
            });

            // Load students when other filters change (only if grade is selected)
            $('#search, #gender, #sortBy, #orderBy').on('change', function() {
                const gradeSelected = $('#grade').val();
                if (gradeSelected) {
                    loadStudents();
                }
            });

            function loadGrades() {
                $.ajax({
                    url: '<?php echo e(route("teacher.grades")); ?>',
                    method: 'GET',
                    success: function(response) {
                        const gradeSelect = $('#grade');
                        gradeSelect.empty();
                        gradeSelect.append('<option value="">All Grades</option>');
                        
                        if (response.grades && response.grades.length > 0) {
                            response.grades.forEach(function(grade) {
                                gradeSelect.append(`<option value="${grade.id}">${grade.title}</option>`);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to load grades:', xhr);
                        toastr.error('Failed to load grades');
                    }
                });
            }

            function loadStudents() {
                const formData = $('#filterStudents').serialize();
                const $tableBody = $('#studentsTableBody');
                const $noStudents = $('#noStudents');
                const $searchBtn = $('#searchStudentButton');

                // Show loading state
                $searchBtn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i> Searching...');
                $tableBody.html('<tr><td colspan="7" class="text-center"><i class="bx bx-loader bx-spin"></i> Loading students...</td></tr>');

                $.ajax({
                    url: '<?php echo e(route("teacher.students")); ?>',
                    method: 'GET',
                    data: formData,
                    success: function(response) {
                        $tableBody.empty();
                        $noStudents.hide();

                        if (response && response.students && response.students.length > 0) {
                            let html = '';
                            response.students.forEach(function(student, index) {
                                // Ensure student object has required properties
                                if (!student) return;
                                
                                html += `
                                    <tr class="student-row">
                                        <td class="fw-bold">${index + 1}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                                    <span class="text-primary fw-bold">${(student.first_name || 'U').charAt(0)}${(student.last_name || 'N').charAt(0)}</span>
                                                </div>
                                                <div>
                                                    <h6 class="student-name mb-0">${student.name || 'Unknown'}</h6>
                                                    <small class="text-muted">${student.id || 'No email'}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="reg-number badge bg-light text-dark">${student.reg_number || 'Not set'}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-${getGenderColor(student.gender)}">${capitalizeFirst(student.gender || 'not-set')}</span>
                                        </td>
                                        <td>${student.grade ? student.grade.title : 'No Grade'}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-grow-1">
                                                    <span class="subject-count badge bg-info">${student.subjects_count || 0} subjects</span>
                                                </div>
                                                <div class="ms-2">
                                                    <button class="btn btn-sm btn-outline-info manage-teacher-subjects" type="button" 
                                                            data-student-id="${student.id}" 
                                                            data-student-name="${student.name || 'Unknown'}"
                                                            data-student-first-name="${student.first_name || ''}"
                                                            data-student-last-name="${student.last_name || ''}"
                                                            data-student-reg="${student.reg_number || ''}"
                                                            data-student-grade="${student.grade ? student.grade.title : ''}"
                                                            data-student-subjects-count="${student.subjects_count || 0}"
                                                            title="Manage subjects">
                                                        <i class="bx bx-cog"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                            $tableBody.html(html);
                        } else {
                            $noStudents.show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to load students:', {xhr, status, error});
                        $tableBody.html('<tr><td colspan="7" class="text-center text-danger">Failed to load students. Please try again.</td></tr>');
                        
                        // Better error message handling
                        let errorMessage = 'Failed to load students';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                // Keep default message if JSON parsing fails
                            }
                        }
                        
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $searchBtn.prop('disabled', false).html('<i class="bx bx-search-alt"></i> Search Students');
                    }
                });
            }

            function getGenderColor(gender) {
                switch(gender) {
                    case 'male': return 'primary';
                    case 'female': return 'success';
                    case null:
                    case undefined:
                    case 'not-set':
                        return 'secondary';
                    default: return 'secondary';
                }
            }

            function capitalizeFirst(str) {
                if (!str || str === 'not-set') return 'Not Set';
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            // Show initial empty state
            function showInitialEmptyState() {
                const $tableBody = $('#students-table tbody');
                const $noStudents = $('#no-students');
                
                $tableBody.empty();
                $noStudents.hide();
                
                $tableBody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-info-circle mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Please select a class to view students</p>
                            </div>
                        </td>
                    </tr>
                `);
            }

            // Show select grade message
            function showSelectGradeMessage() {
                const $tableBody = $('#students-table tbody');
                const $noStudents = $('#no-students');
                
                $tableBody.empty();
                $noStudents.hide();
                
                $tableBody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-user-plus mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Select a class to view students</p>
                                <small>Choose a class from the dropdown above</small>
                            </div>
                        </td>
                    </tr>
                `);
            }

            // Handle manage subjects modal
            $(document).on('click', '.manage-teacher-subjects', function() {
                const studentId = $(this).data('student-id');
                const studentName = $(this).data('student-name');
                const firstName = $(this).data('student-first-name');
                const lastName = $(this).data('student-last-name');
                const regNumber = $(this).data('student-reg');
                const grade = $(this).data('student-grade');
                const subjectsCount = $(this).data('student-subjects-count');

                openTeacherSubjectManagementModal({
                    id: studentId,
                    name: studentName,
                    first_name: firstName,
                    last_name: lastName,
                    reg_number: regNumber,
                    grade: grade,
                    subjects_count: subjectsCount
                });
            });

            // Refresh table button handler
            $('#teacher-refresh-table-btn').on('click', function() {
                const gradeSelected = $('#grade').val();
                if (gradeSelected) {
                    loadStudents();
                }
                $('#teacherSubjectManagementModal').modal('hide');
            });

            // Subject management functions
            function openTeacherSubjectManagementModal(student) {
                // Populate student info
                $('#teacher-subject-modal-student-name').text(student.name || 'Student');
                $('#teacher-subject-modal-student-class').text(student.grade || '-');
                $('#teacher-subject-modal-student-reg').text(student.reg_number || '-');
                $('#teacher-subject-modal-student-id').val(student.id);
                
                // Set initials
                const initials = `${(student.first_name || 'U').charAt(0)}${(student.last_name || 'N').charAt(0)}`;
                $('#teacher-subject-modal-student-initials').text(initials);
                
                // Clear previous content
                $('#teacher-current-subjects-list').empty();
                $('#teacher-available-subjects-list').empty();
                $('#teacher-subject-modal-alerts').empty();
                
                // Show loading
                $('#teacher-current-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
                $('#teacher-available-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
                
                // Load current subjects
                loadTeacherSubjects(student);
                
                // Show modal
                $('#teacherSubjectManagementModal').modal('show');
            }

            function loadTeacherSubjects(student) {
                // Show loading for both lists
                $('#teacher-current-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
                $('#teacher-available-subjects-list').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>');
                
                // Get student's current subjects and all available subjects in parallel
                Promise.all([
                    // Get student's current subjects
                    fetch(`<?php echo e(url('teacher/student/subjects')); ?>/${student.id}`).then(res => res.json()),
                    // Get all subjects
                    fetch('<?php echo e(route("subject.index")); ?>', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(res => res.json())
                ]).then(([currentResponse, allSubjectsResponse]) => {
                    const currentSubjects = currentResponse.data || [];
                    const assignedIds = currentSubjects.map(s => parseInt(s.id));
                    
                    // Get all subjects from response
                    let allSubjects = [];
                    if (allSubjectsResponse.data) {
                        allSubjects = allSubjectsResponse.data;
                    } else if (Array.isArray(allSubjectsResponse)) {
                        allSubjects = allSubjectsResponse;
                    } else if (allSubjectsResponse.subjects) {
                        allSubjects = allSubjectsResponse.subjects;
                    }
                    
                    // Filter available subjects (not yet assigned)
                    const availableSubjects = allSubjects.filter(subject => 
                        !assignedIds.includes(parseInt(subject.id))
                    );
                    
                    // Update counts
                    $('#assigned-count').text(currentSubjects.length);
                    $('#available-count').text(availableSubjects.length);
                    
                    // Render current subjects
                    renderCurrentSubjects(currentSubjects);
                    
                    // Render available subjects
                    renderAvailableSubjects(availableSubjects);
                    
                }).catch(error => {
                    console.error('Failed to load subjects:', error);
                    $('#teacher-current-subjects-list').html('<div class="text-center text-danger py-3"><i class="bx bx-error-circle display-4"></i><p class="mt-2">Failed to load subjects</p></div>');
                    $('#teacher-available-subjects-list').html('<div class="text-center text-danger py-3"><i class="bx bx-error-circle display-4"></i><p class="mt-2">Failed to load subjects</p></div>');
                });
            }
            
            function renderCurrentSubjects(currentSubjects) {
                const container = $('#teacher-current-subjects-list');
                
                if (currentSubjects.length === 0) {
                    container.html('<div class="text-center text-muted py-3"><i class="bx bx-book-open display-4"></i><p class="mt-2">No subjects assigned</p></div>');
                    return;
                }
                
                const html = currentSubjects.map(function(subject, index) {
                    return `
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2 subject-item" data-subject-id="${subject.id}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-2">${index + 1}</span>
                                <div>
                                    <div class="fw-medium">${escapeHtml(subject.title)}</div>
                                    <small class="text-muted">Subject ID: ${subject.id}</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-teacher-subject" 
                                    data-subject-id="${subject.id}" title="Remove subject">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    `;
                }).join('');
                
                container.html(html);
            }
            
            function renderAvailableSubjects(availableSubjects) {
                const container = $('#teacher-available-subjects-list');
                
                if (availableSubjects.length === 0) {
                    container.html('<div class="text-center text-muted py-3"><i class="bx bx-check-circle display-4"></i><p class="mt-2">All subjects assigned</p></div>');
                    return;
                }
                
                const html = availableSubjects.map(function(subject) {
                    const subjectTitle = subject.title || subject.name || `Subject ${subject.id}`;
                    return `
                        <div class="d-flex align-items-center justify-content-between p-2 border rounded mb-2 subject-item">
                            <div>
                                <div class="fw-medium">${escapeHtml(subjectTitle)}</div>
                                <small class="text-muted">Subject ID: ${subject.id}</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success add-teacher-subject" 
                                    data-subject-id="${subject.id}" title="Add subject">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>
                    `;
                }).join('');
                
                container.html(html);
            }

            // Handle subject addition
            $(document).on('click', '.add-teacher-subject', function() {
                const subjectId = $(this).data('subject-id');
                const studentId = $('#teacher-subject-modal-student-id').val();
                const $button = $(this);
                const $subjectItem = $button.closest('.subject-item');
                
                $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
                
                $.ajax({
                    url: '<?php echo e(route("teacher.student.assignSubject")); ?>',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        student_id: studentId,
                        subjects: [subjectId]
                    },
                    success: function(response) {
                        if (response.status) {
                            showTeacherModalAlert('success', 'Subject assigned successfully!');
                            // Refresh both lists
                            const student = {
                                id: studentId,
                                name: $('#teacher-subject-modal-student-name').text()
                            };
                            loadTeacherSubjects(student);
                        } else {
                            showTeacherModalAlert('danger', response.message || 'Failed to assign subject');
                            $button.prop('disabled', false).html('<i class="bx bx-plus"></i>');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to assign subject';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showTeacherModalAlert('danger', errorMessage);
                        $button.prop('disabled', false).html('<i class="bx bx-plus"></i>');
                    }
                });
            });

            // Handle subject removal
            $(document).on('click', '.remove-teacher-subject', function() {
                const subjectId = $(this).data('subject-id');
                const studentId = $('#teacher-subject-modal-student-id').val();
                const $button = $(this);
                const $subjectItem = $button.closest('.subject-item');
                
                $button.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
                
                $.ajax({
                    url: `<?php echo e(url('teacher/student')); ?>/${studentId}/subject/${subjectId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.status) {
                            showTeacherModalAlert('success', 'Subject removed successfully!');
                            // Refresh both lists
                            const student = {
                                id: studentId,
                                name: $('#teacher-subject-modal-student-name').text()
                            };
                            loadTeacherSubjects(student);
                        } else {
                            showTeacherModalAlert('danger', response.message || 'Failed to remove subject');
                            $button.prop('disabled', false).html('<i class="bx bx-trash"></i>');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to remove subject';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showTeacherModalAlert('danger', errorMessage);
                        $button.prop('disabled', false).html('<i class="bx bx-trash"></i>');
                    }
                });
            });

            function showTeacherModalAlert(type, message) {
                const icons = {
                    success: 'bx-check-circle',
                    danger: 'bx-error-circle',
                    warning: 'bx-error',
                    info: 'bx-info-circle',
                };

                $('#teacher-subject-modal-alerts').html(`
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        <i class="bx ${icons[type] || 'bx-info-circle'} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                
                // Auto-hide success messages after 3 seconds
                if (type === 'success') {
                    setTimeout(() => {
                        $('#teacher-subject-modal-alerts .alert').alert('close');
                    }, 3000);
                }
            }

            function escapeHtml(value) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                };
                return String(value || '').replace(/[&<>"']/g, function (s) {
                    return map[s];
                });
            }
        });
    </script>
    <?php $__env->stopSection(); ?>

    
    <?php echo $__env->make('admin.teacher.modals.subject-management', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\primary\resources\views/admin/teacher/students.blade.php ENDPATH**/ ?>