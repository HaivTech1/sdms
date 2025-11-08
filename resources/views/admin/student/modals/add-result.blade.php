<!-- Add Result Modal -->
<div class="modal fade" id="addResult" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-plus-circle me-2"></i>Add New Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modalError"></div>

                <form id="addResultForm">
                    @csrf
                    <input type="hidden" id="add_student_id" name="student_id">

                    <!-- Student Information Panel -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="bx bx-user me-1"></i>Student Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <img id="add-student-photo" src="{{ asset('noImage.png') }}" 
                                         alt="Student Photo" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-md-10">
                                    <h5 id="add-student-name" class="mb-2">Student Name</h5>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <small class="text-muted">Class:</small>
                                            <span id="add-student-class" class="fw-semibold ms-1">-</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted">Admission:</small>
                                            <span id="add-student-admission" class="fw-semibold ms-1">-</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted">Session:</small>
                                            <span id="add-current-session" class="fw-semibold ms-1">-</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <small class="text-muted">Term:</small>
                                            <span id="add-current-term" class="fw-semibold ms-1">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Result Configuration -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="bx bx-cog me-1"></i>Result Configuration
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="add_result_type" class="form-label fw-semibold">
                                        <i class="bx bx-category me-1"></i>Result Type
                                    </label>
                                    <select id="add_result_type" name="result_type" class="form-select" required>
                                        <option value="">Select Type</option>
                                        <option value="midterm">Midterm Assessment</option>
                                        <option value="exam">Examination</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="add_session" class="form-label fw-semibold">
                                        <i class="bx bx-calendar me-1"></i>Academic Session
                                    </label>
                                    <select id="add_session" name="session" class="form-select" required>
                                        <option value="">Select Session</option>
                                        @foreach($allSessions as $session)
                                            <option value="{{ $session->session }}" 
                                                {{ $session->session == $currentSession ? 'selected' : '' }}>
                                                {{ $session->session }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="add_term" class="form-label fw-semibold">
                                        <i class="bx bx-book me-1"></i>Term
                                    </label>
                                    <select id="add_term" name="term" class="form-select" required>
                                        <option value="">Select Term</option>
                                        <option value="First">First Term</option>
                                        <option value="Second">Second Term</option>
                                        <option value="Third">Third Term</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects and Scores -->
                    <div class="card border-warning">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="bx bx-list-ul me-1"></i>Subject Scores
                                </h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="load-subjects">
                                    <i class="bx bx-refresh me-1"></i>Load Subjects
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Midterm Score Template -->
                            <div id="midterm-template" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="width: 30%;">Subject</th>
                                                <th class="text-center" style="width: 17.5%;">1st Test (20)</th>
                                                <th class="text-center" style="width: 17.5%;">2nd Test (20)</th>
                                                <th class="text-center" style="width: 17.5%;">Project (10)</th>
                                                <th class="text-center" style="width: 17.5%;">Total (50)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="midterm-subjects-list">
                                            <!-- Dynamic content -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Exam Score Template -->
                            <div id="exam-template" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-success">
                                            <tr>
                                                <th style="width: 35%;">Subject</th>
                                                <th class="text-center" style="width: 21.67%;">CA Score (40)</th>
                                                <th class="text-center" style="width: 21.67%;">Exam Score (60)</th>
                                                <th class="text-center" style="width: 21.67%;">Total (100)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="exam-subjects-list">
                                            <!-- Dynamic content -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Initial Message -->
                            <div id="no-subjects" class="text-center py-5">
                                <i class="bx bx-info-circle font-size-48 text-muted"></i>
                                <p class="text-muted mt-3">Select result type and click "Load Subjects" to begin entering scores.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Score Summary -->
                    <div id="add-score-summary" class="mt-4" style="display: none;">
                        <div class="card border-info bg-light">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h5 id="add-total-subjects" class="text-primary mb-1">0</h5>
                                        <small class="text-muted">Total Subjects</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 id="add-total-score" class="text-success mb-1">0</h5>
                                        <small class="text-muted">Total Score</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 id="add-average-score" class="text-info mb-1">0.0</h5>
                                        <small class="text-muted">Average Score</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 id="add-overall-grade" class="text-warning mb-1">-</h5>
                                        <small class="text-muted">Overall Grade</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-outline-primary" id="preview-result">
                    <i class="bx bx-show me-1"></i>Preview
                </button>
                <button type="button" class="btn btn-info" id="calculate-totals">
                    <i class="bx bx-calculator me-1"></i>Calculate
                </button>
                <button type="submit" form="addResultForm" class="btn btn-success">
                    <i class="bx bx-save me-1"></i>Save Result
                </button>
            </div>
        </div>
    </div>
</div>