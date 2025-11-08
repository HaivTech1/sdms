<!-- View Results Modal -->
<div class="modal fade" id="resultPreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title">
                    <i class="bx bx-chart-square me-2"></i>Student Results
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Student Info Sidebar -->
                        <div class="col-lg-3 bg-light border-end p-4">
                            <div class="text-center mb-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <img id="result-student-photo" src="{{ asset('noImage.png') }}" 
                                         alt="Student Photo" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <h6 id="result-student-name" class="mb-1">Student Name</h6>
                                <p id="result-student-class" class="text-muted small mb-0">Class</p>
                            </div>

                            <div class="student-info">
                                <div class="mb-3">
                                    <label class="small text-muted">Admission Number</label>
                                    <p id="result-admission-no" class="fw-semibold mb-0">-</p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Session</label>
                                    <p id="result-session" class="fw-semibold mb-0">-</p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Term</label>
                                    <p id="result-term" class="fw-semibold mb-0">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Results Content -->
                        <div class="col-lg-9 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h6 class="mb-1">Academic Performance</h6>
                                    <small class="text-muted">Detailed subject scores and analysis</small>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="view-midterm">
                                        <i class="bx bx-calendar me-1"></i>Midterm
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="view-exam">
                                        <i class="bx bx-trophy me-1"></i>Exam
                                    </button>
                                </div>
                            </div>

                            <!-- Results Table -->
                            <div id="results-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Subject</th>
                                                <th class="text-center">CA Score</th>
                                                <th class="text-center">Exam Score</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Grade</th>
                                                <th class="text-center">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody id="results-table-body">
                                            <!-- Dynamic content will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Summary Stats -->
                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <div class="card border-success">
                                            <div class="card-body text-center">
                                                <h5 id="total-score" class="text-success mb-1">0</h5>
                                                <small class="text-muted">Total Score</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-info">
                                            <div class="card-body text-center">
                                                <h5 id="average-score" class="text-info mb-1">0.0</h5>
                                                <small class="text-muted">Average</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-warning">
                                            <div class="card-body text-center">
                                                <h5 id="class-position" class="text-warning mb-1">-</h5>
                                                <small class="text-muted">Position</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-primary">
                                            <div class="card-body text-center">
                                                <h5 id="grade-level" class="text-primary mb-1">-</h5>
                                                <small class="text-muted">Grade</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loading State -->
                            <div id="results-loading" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted">Loading results...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="print-result">
                    <i class="bx bx-printer me-1"></i>Print Result
                </button>
                <button type="button" class="btn btn-success" id="download-result">
                    <i class="bx bx-download me-1"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>