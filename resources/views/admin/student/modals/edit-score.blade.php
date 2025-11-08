<!-- Edit Score Modal -->
<div class="modal fade" id="editScore" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-warning text-white">
                <h5 class="modal-title">
                    <i class="bx bx-edit me-2"></i>Edit Student Scores
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modalError"></div>

                <!-- Student Information -->
                <div class="card border-info mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <img id="edit-student-photo" src="{{ asset('noImage.png') }}" 
                                     alt="Student Photo" class="rounded-circle img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-md-10">
                                <h6 id="edit-student-name" class="mb-1">Student Name</h6>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Class:</small>
                                        <span id="edit-student-class" class="fw-semibold ms-1">-</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Admission:</small>
                                        <span id="edit-student-admission" class="fw-semibold ms-1">-</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Session:</small>
                                        <span id="edit-current-session" class="fw-semibold ms-1">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Score Editing Form -->
                <form id="editScoreForm">
                    @csrf
                    <input type="hidden" id="edit_student_id" name="student_id">
                    <input type="hidden" id="edit_result_type" name="result_type">

                    <!-- Result Type Selector -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bx bx-category me-1"></i>Result Type
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="result_type_radio" id="edit-midterm-radio" value="midterm" autocomplete="off">
                            <label class="btn btn-outline-primary" for="edit-midterm-radio">
                                <i class="bx bx-calendar me-1"></i>Midterm Results
                            </label>

                            <input type="radio" class="btn-check" name="result_type_radio" id="edit-exam-radio" value="exam" autocomplete="off">
                            <label class="btn btn-outline-primary" for="edit-exam-radio">
                                <i class="bx bx-trophy me-1"></i>Exam Results
                            </label>
                        </div>
                    </div>

                    <!-- Scores Input Area -->
                    <div id="scores-container">
                        <!-- Midterm Scores -->
                        <div id="midterm-scores" style="display: none;">
                            <h6 class="text-primary mb-3">
                                <i class="bx bx-list-ul me-1"></i>Midterm Assessment Scores
                            </h6>
                            <div id="midterm-subjects-container">
                                <!-- Dynamic midterm subjects will be loaded here -->
                            </div>
                        </div>

                        <!-- Exam Scores -->
                        <div id="exam-scores" style="display: none;">
                            <h6 class="text-success mb-3">
                                <i class="bx bx-award me-1"></i>Examination Scores
                            </h6>
                            <div id="exam-subjects-container">
                                <!-- Dynamic exam subjects will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Score Calculation Summary -->
                    <div id="score-summary" class="mt-4" style="display: none;">
                        <div class="card border-light bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-muted mb-3">Score Summary</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h5 id="total-subjects" class="text-primary mb-1">0</h5>
                                            <small class="text-muted">Subjects</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h5 id="total-points" class="text-success mb-1">0</h5>
                                            <small class="text-muted">Total Points</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h5 id="average-points" class="text-info mb-1">0.0</h5>
                                            <small class="text-muted">Average</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h5 id="grade-summary" class="text-warning mb-1">-</h5>
                                            <small class="text-muted">Grade</small>
                                        </div>
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
                <button type="button" class="btn btn-outline-info" id="calculate-scores">
                    <i class="bx bx-calculator me-1"></i>Calculate
                </button>
                <button type="submit" form="editScoreForm" class="btn btn-warning">
                    <i class="bx bx-save me-1"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>