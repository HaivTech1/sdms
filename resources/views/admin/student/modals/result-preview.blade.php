<!-- Result Preview Modal -->
<div class="modal fade" id="resultPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title">
                    <i class="bx bx-show me-2"></i>Result Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="result-preview-content">
                    <!-- Student Header -->
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <img id="preview-student-photo" src="{{ asset('noImage.png') }}" 
                                 alt="Student Photo" class="rounded img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <h5 id="preview-student-name" class="mb-1">Student Name</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted">Class:</small>
                                    <span id="preview-class" class="fw-semibold ms-1">-</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">Admission No:</small>
                                    <span id="preview-admission" class="fw-semibold ms-1">-</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">Session:</small>
                                    <span id="preview-session" class="fw-semibold ms-1">-</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">Term:</small>
                                    <span id="preview-term" class="fw-semibold ms-1">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Result Type Tabs -->
                    <ul class="nav nav-tabs mb-3" id="preview-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="midterm-tab" data-bs-toggle="tab" 
                                    data-bs-target="#midterm-content" type="button" role="tab">
                                <i class="bx bx-calendar me-1"></i>Midterm Results
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="exam-tab" data-bs-toggle="tab" 
                                    data-bs-target="#exam-content" type="button" role="tab">
                                <i class="bx bx-trophy me-1"></i>Exam Results
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="preview-tab-content">
                        <!-- Midterm Results -->
                        <div class="tab-pane fade show active" id="midterm-content" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th class="text-center">1st Test</th>
                                            <th class="text-center">2nd Test</th>
                                            <th class="text-center">Project</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody id="midterm-results-body">
                                        <!-- Dynamic midterm results -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Exam Results -->
                        <div class="tab-pane fade" id="exam-content" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th class="text-center">CA Score</th>
                                            <th class="text-center">Exam Score</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Grade</th>
                                            <th class="text-center">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam-results-body">
                                        <!-- Dynamic exam results -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Summary -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-primary">Overall Performance</h6>
                                    <h4 id="preview-average" class="text-primary">0.0%</h4>
                                    <small class="text-muted">Average Score</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-success">Class Position</h6>
                                    <h4 id="preview-position" class="text-success">-</h4>
                                    <small class="text-muted">out of <span id="preview-total-students">0</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="preview-loading" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading result preview...</p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Close
                </button>
                <button type="button" class="btn btn-outline-primary" id="edit-from-preview">
                    <i class="bx bx-edit me-1"></i>Edit Result
                </button>
                <button type="button" class="btn btn-primary" id="generate-report">
                    <i class="bx bx-file-blank me-1"></i>Generate Report
                </button>
            </div>
        </div>
    </div>
</div>