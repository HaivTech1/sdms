<x-app-layout>
    @section('title', application('name')." | Batch Midterm Result")
    
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Batch Midterm Result Upload</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('result.index') }}">Results</a></li>
                <li class="breadcrumb-item active">Batch Midterm Upload</li>
            </ol>
        </div>
    </x-slot>

    @midUploadEnabled
        <div class="row">
            <div class="col-12">
                <!-- Selection Form Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bx bx-search-alt-2 font-size-24"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="card-title mb-0">Select Class & Subject</h5>
                                <p class="card-text mb-0 opacity-75">Choose the class, subject, session and term to load students</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="selection-alerts"></div>
                        
                        <form id="fetch-students-form" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <label for="grade_id" class="form-label fw-semibold">
                                        <i class="bx bx-home-circle text-primary me-1"></i>Class
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="grade_id" name="grade_id" required>
                                        <option value="">Select Class</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a class.</div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="subject_id" class="form-label fw-semibold">
                                        <i class="bx bx-book-open text-primary me-1"></i>Subject
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="subject_id" name="subject_id" required>
                                        <option value="">Select Subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id() }}">{{ $subject->title() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a subject.</div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="period_id" class="form-label fw-semibold">
                                        <i class="bx bx-calendar text-primary me-1"></i>Session
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="period_id" name="period_id" required>
                                        <option value="">Select Session</option>
                                        @foreach ($periods as $period)
                                            <option value="{{ $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a session.</div>
                                </div>

                                <div class="col-lg-6">
                                    <label for="term_id" class="form-label fw-semibold">
                                        <i class="bx bx-time text-primary me-1"></i>Term
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="term_id" name="term_id" required>
                                        <option value="">Select Term</option>
                                        @foreach ($terms as $term)
                                            <option value="{{ $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a term.</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" id="fetch-students-btn" class="btn btn-primary btn-lg px-5">
                                            <i class="bx bx-search me-2"></i>Load Students
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Test Type Selection -->
                        <div id="test-type-section" class="mt-4" style="display: none;">
                            <div class="alert alert-info border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-info-circle font-size-20 me-2"></i>
                                    <span>Select test type only after loading students from the form above!</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="test-type" class="form-label fw-semibold">
                                        <i class="bx bx-list-check text-primary me-1"></i>Test Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="test-type" class="form-select">
                                        <option value="">Select test type</option>
                                        @php $midterm = get_settings('midterm_format') ?? []; @endphp
                                        @foreach ($midterm as $key => $value)
                                            <option value="{{ $key }}" data-mark="{{ $value['mark'] }}">{{ $value['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students Results Table -->
                <div id="students-section" class="card border-0 shadow-sm mt-4" style="display: none;">
                    <div class="card-header bg-gradient-success text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bx bx-users font-size-24"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title mb-0">Students Results</h5>
                                    <p class="card-text mb-0 opacity-75">Enter scores for each student</p>
                                </div>
                            </div>
                            <div class="badge bg-light text-dark fs-6">
                                <span id="students-count">0</span> Students
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="upload-alerts" class="mx-3 mt-3"></div>
                        
                        <form id="upload-results-form" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" id="form-grade-id" name="grade_id">
                            <input type="hidden" id="form-subject-id" name="subject_id">
                            <input type="hidden" id="form-period-id" name="period_id">
                            <input type="hidden" id="form-term-id" name="term_id">
                            
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60px;">#</th>
                                            <th>Student Name</th>
                                            <th id="score-header" style="width: 150px;">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody id="students-table-body">
                                        <!-- Students will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        <i class="bx bx-info-circle me-1"></i>
                                        <span id="validation-summary">Fill all required fields to submit</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" id="clear-all-btn" class="btn btn-outline-secondary">
                                            <i class="bx bx-eraser me-1"></i>Clear All
                                        </button>
                                        <button type="submit" id="upload-btn" class="btn btn-success btn-lg px-4" disabled>
                                            <i class="bx bx-upload me-2"></i>Upload Results
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Upload Progress Modal -->
                <div class="modal fade" id="uploadProgressModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="bx bx-cloud-upload me-2"></i>Uploading Results
                                </h5>
                            </div>
                            <div class="modal-body text-center py-5">
                                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
                                <h6 class="mb-2">Processing your upload...</h6>
                                <p class="text-muted mb-0">Please wait while we save the results</p>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         style="width: 0%" id="upload-progress"></div>
                                </div>
                                <small class="text-muted mt-2 d-block" id="upload-status">Initializing...</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center py-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <div class="maintenance-img">
                                <img src="{{ asset('images/coming-soon.svg') }}" alt="Upload Disabled" class="img-fluid mx-auto d-block" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-4 text-danger">Upload Currently Disabled</h4>
                    <p class="text-muted">Batch midterm result uploads are temporarily disabled. Please contact the administrator to gain access.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="bx bx-arrow-back me-2"></i>Return to Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endmidUploadEnabled

    @section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        
        .form-select:focus,
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .score-input {
            max-width: 100px;
            text-align: center;
            border-radius: 8px;
        }
        
        .score-input:focus {
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
        
        .student-row {
            transition: background-color 0.2s ease;
        }
        
        .student-row:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        
        .alert {
            border-radius: 10px;
        }
        
        .modal-content {
            border-radius: 15px;
        }
        
        .progress {
            border-radius: 10px;
        }
    </style>
    @endsection

    @section('scripts')
    <script>
        $(document).ready(function() {
            console.log('Batch midterm script loaded');
            
            // State management
            const state = {
                students: [],
                selectedTestType: null,
                maxMark: 0,
            };

            // DOM elements
            const $fetchForm = $('#fetch-students-form');
            const $fetchBtn = $('#fetch-students-btn');
            const $testTypeSection = $('#test-type-section');
            const $testType = $('#test-type');
            const $studentsSection = $('#students-section');
            const $studentsTableBody = $('#students-table-body');
            const $studentsCount = $('#students-count');
            const $scoreHeader = $('#score-header');
            const $uploadForm = $('#upload-results-form');
            const $uploadBtn = $('#upload-btn');
            const $clearAllBtn = $('#clear-all-btn');
            const $uploadProgressModal = $('#uploadProgressModal');
            const $uploadProgress = $('#upload-progress');
            const $uploadStatus = $('#upload-status');

            console.log('Form element found:', $fetchForm.length);

            // Event handlers
            $fetchForm.on('submit', handleFetchStudents);
            $testType.on('change', handleTestTypeChange);
            $uploadForm.on('submit', handleUploadResults);
            $clearAllBtn.on('click', clearAllScores);
            $(document).on('input', '.score-input', validateScoreInput);
            $(document).on('keyup', '.score-input', updateValidationSummary);

            function handleFetchStudents(e) {
                console.log('handleFetchStudents called');
                e.preventDefault();
                
                if (!$fetchForm[0].checkValidity()) {
                    $fetchForm[0].classList.add('was-validated');
                    return;
                }

                const formData = new FormData($fetchForm[0]);
                
                $fetchBtn.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Loading...');
                clearAlerts('#selection-alerts');

                console.log('Making AJAX request to fetch students');

                $.ajax({
                    url: '{{ route("result.batch.midterm.students") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).done(function(response) {
                    console.log('AJAX response:', response);
                    if (response.status) {
                        state.students = response.data;
                        populateHiddenFields();
                        showTestTypeSection();
                        showAlert('#selection-alerts', 'success', 
                            `Successfully loaded ${response.total_students} students for ${response.grade.title} - ${response.subject.title}`);
                    } else {
                        showAlert('#selection-alerts', 'danger', response.message || 'Failed to load students');
                    }
                }).fail(function(xhr) {
                    console.error('AJAX error:', xhr);
                    const message = xhr.responseJSON?.message || 'Failed to load students. Please try again.';
                    showAlert('#selection-alerts', 'danger', message);
                }).always(function() {
                    $fetchBtn.prop('disabled', false).html('<i class="bx bx-search me-2"></i>Load Students');
                });
            }
                
                if (!$fetchForm[0].checkValidity()) {
                    $fetchForm[0].classList.add('was-validated');
                    return;
                }

                const formData = new FormData($fetchForm[0]);
                
                $fetchBtn.prop('disabled', true).html('<i class="bx bx-loader bx-spin me-2"></i>Loading...');
                clearAlerts('#selection-alerts');

                $.ajax({
                    url: '{{ route("result.batch.midterm.students") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).done(function(response) {
                    if (response.status) {
                        state.students = response.data;
                        populateHiddenFields();
                        showTestTypeSection();
                        showAlert('#selection-alerts', 'success', 
                            `Successfully loaded ${response.total_students} students for ${response.grade.title} - ${response.subject.title}`);
                    } else {
                        showAlert('#selection-alerts', 'danger', response.message || 'Failed to load students');
                    }
                }).fail(function(xhr) {
                    const message = xhr.responseJSON?.message || 'Failed to load students. Please try again.';
                    showAlert('#selection-alerts', 'danger', message);
                }).always(function() {
                    $fetchBtn.prop('disabled', false).html('<i class="bx bx-search me-2"></i>Load Students');
                });

            function handleTestTypeChange() {
                const selectedValue = $testType.val();
                
                if (selectedValue) {
                    const selectedOption = $testType.find(':selected');
                    state.selectedTestType = selectedValue;
                    state.maxMark = parseFloat(selectedOption.data('mark')) || 100;
                    
                    const testName = selectedOption.text();
                    $scoreHeader.text(`${testName} (Max: ${state.maxMark})`);
                    
                    renderStudentsTable();
                    showStudentsSection();
                } else {
                    hideStudentsSection();
                }
            }

            function renderStudentsTable() {
                if (!state.students.length) return;

                let html = '';
                state.students.forEach((student, index) => {
                    html += `
                        <tr class="student-row">
                            <td class="fw-bold text-primary">${index + 1}</td>
                            <td>
                                <input type="hidden" name="student_id[]" value="${student.id}">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <span class="text-primary fw-bold">${student.first_name.charAt(0)}${student.last_name.charAt(0)}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">${student.name}</h6>
                                        <small class="text-muted">Student ID: ${student.id}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" 
                                       class="form-control score-input" 
                                       name="${state.selectedTestType}[]" 
                                       placeholder="0"
                                       min="0" 
                                       max="${state.maxMark}" 
                                       step="0.01"
                                       data-student-index="${index}">
                                <div class="invalid-feedback"></div>
                            </td>
                        </tr>
                    `;
                });

                $studentsTableBody.html(html);
                $studentsCount.text(state.students.length);
                updateValidationSummary();
            }

            function validateScoreInput() {
                const $input = $(this);
                const value = parseFloat($input.val());
                const $feedback = $input.siblings('.invalid-feedback');
                
                $input.removeClass('is-invalid');
                $feedback.text('');

                if ($input.val() && (isNaN(value) || value < 0 || value > state.maxMark)) {
                    $input.addClass('is-invalid');
                    $feedback.text(`Score must be between 0 and ${state.maxMark}`);
                }
            }

            function updateValidationSummary() {
                const $inputs = $('.score-input');
                const filledInputs = $inputs.filter(function() { return $(this).val() !== ''; });
                const invalidInputs = $inputs.filter('.is-invalid');
                
                const totalStudents = state.students.length;
                const filledCount = filledInputs.length;
                
                let summary = `${filledCount}/${totalStudents} scores entered`;
                let canSubmit = filledCount > 0 && invalidInputs.length === 0;
                
                if (invalidInputs.length > 0) {
                    summary += ` (${invalidInputs.length} invalid)`;
                    canSubmit = false;
                }
                
                $('#validation-summary').text(summary);
                $uploadBtn.prop('disabled', !canSubmit);
            }

            function handleUploadResults(e) {
                e.preventDefault();
                
                if (!state.selectedTestType) {
                    showAlert('#upload-alerts', 'warning', 'Please select a test type first');
                    return;
                }

                const $inputs = $('.score-input');
                const filledInputs = $inputs.filter(function() { return $(this).val() !== ''; });
                
                if (filledInputs.length === 0) {
                    showAlert('#upload-alerts', 'warning', 'Please enter at least one score');
                    return;
                }

                if ($inputs.filter('.is-invalid').length > 0) {
                    showAlert('#upload-alerts', 'danger', 'Please fix invalid scores before submitting');
                    return;
                }

                // Show progress modal
                $uploadProgressModal.modal('show');
                updateProgressModal(0, 'Preparing upload...');

                const formData = new FormData($uploadForm[0]);
                
                $.ajax({
                    url: '{{ route("result.upload.batch.midterm.score") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                const percentComplete = (evt.loaded / evt.total) * 100;
                                updateProgressModal(percentComplete, 'Uploading results...');
                            }
                        }, false);
                        return xhr;
                    }
                }).done(function(response) {
                    updateProgressModal(100, 'Upload completed successfully!');
                    
                    setTimeout(() => {
                        $uploadProgressModal.modal('hide');
                        if (response.status) {
                            showAlert('#upload-alerts', 'success', response.message || 'Results uploaded successfully!');
                            resetForm();
                        } else {
                            showAlert('#upload-alerts', 'danger', response.message || 'Upload failed');
                        }
                    }, 1000);
                    
                }).fail(function(xhr) {
                    $uploadProgressModal.modal('hide');
                    
                    let message = 'Upload failed. Please try again.';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (Array.isArray(xhr.responseJSON)) {
                            message = xhr.responseJSON.join('<br>');
                        }
                    }
                    
                    showAlert('#upload-alerts', 'danger', message);
                });
            }

            function updateProgressModal(percent, status) {
                $uploadProgress.css('width', `${percent}%`);
                $uploadStatus.text(status);
            }

            function clearAllScores() {
                if (confirm('Are you sure you want to clear all entered scores?')) {
                    $('.score-input').val('').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                    updateValidationSummary();
                    clearAlerts('#upload-alerts');
                }
            }

            function populateHiddenFields() {
                $('#form-grade-id').val($('#grade_id').val());
                $('#form-subject-id').val($('#subject_id').val());
                $('#form-period-id').val($('#period_id').val());
                $('#form-term-id').val($('#term_id').val());
            }

            function showTestTypeSection() {
                $testTypeSection.slideDown();
            }

            function showStudentsSection() {
                $studentsSection.slideDown();
            }

            function hideStudentsSection() {
                $studentsSection.slideUp();
                state.selectedTestType = null;
            }

            function resetForm() {
                $fetchForm[0].reset();
                $fetchForm.removeClass('was-validated');
                $uploadForm[0].reset();
                $testType.val('');
                $testTypeSection.slideUp();
                $studentsSection.slideUp();
                state.students = [];
                state.selectedTestType = null;
                clearAlerts('#selection-alerts');
                clearAlerts('#upload-alerts');
            }

            function showAlert(container, type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        <i class="bx ${getAlertIcon(type)} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                $(container).html(alertHtml);
            }

            function clearAlerts(container) {
                $(container).empty();
            }

            function getAlertIcon(type) {
                const icons = {
                    'success': 'bx-check-circle',
                    'danger': 'bx-error-circle',
                    'warning': 'bx-error',
                    'info': 'bx-info-circle'
                };
                return icons[type] || 'bx-info-circle';
            }
        });
    </script>
    @endsection
</x-app-layout>