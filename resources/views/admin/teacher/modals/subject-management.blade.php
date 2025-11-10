<!-- Teacher Subject Management Modal -->
<div class="modal fade" id="teacherSubjectManagementModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-book-bookmark me-2"></i>Manage Student Subjects
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Student Information -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <span id="teacher-subject-modal-student-initials" class="text-primary fw-bold fs-4">??</span>
                                    </div>
                                    <div>
                                        <h6 id="teacher-subject-modal-student-name" class="mb-1 fw-bold">Student Name</h6>
                                        <p class="text-muted mb-0">
                                            <i class="bx bx-book me-1"></i>Class: <span id="teacher-subject-modal-student-class">-</span>
                                            <i class="bx bx-id-card ms-3 me-1"></i>ID: <span id="teacher-subject-modal-student-reg">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Container -->
                <div id="teacher-subject-modal-alerts"></div>

                <!-- Subject Management -->
                <div class="row">
                    <!-- Current Subjects -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bx bx-check-circle me-2"></i>Assigned Subjects
                                    <span class="badge bg-white text-success ms-2" id="assigned-count">0</span>
                                </h6>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                <div id="teacher-current-subjects-list">
                                    <!-- Current subjects will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Subjects -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="bx bx-plus-circle me-2"></i>Available Subjects
                                    <span class="badge bg-white text-info ms-2" id="available-count">0</span>
                                </h6>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                <div id="teacher-available-subjects-list">
                                    <!-- Available subjects will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-info-circle me-2"></i>
                                <div>
                                    <strong>Instructions:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Click <i class="bx bx-plus text-success"></i> to assign a subject to the student</li>
                                        <li>Click <i class="bx bx-trash text-danger"></i> to remove a subject from the student</li>
                                        <li>Changes are applied immediately</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields -->
                <input type="hidden" id="teacher-subject-modal-student-id" value="">
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" id="teacher-refresh-table-btn">
                    <i class="bx bx-refresh me-1"></i>Refresh Table
                </button>
            </div>
        </div>
    </div>
</div>