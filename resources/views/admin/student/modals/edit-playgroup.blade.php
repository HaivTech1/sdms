<!-- Edit Playgroup Modal -->
<div class="modal fade" id="editPlaygroup" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title">
                    <i class="bx bx-child me-2"></i>Edit Playgroup Assessment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modalError"></div>

                <!-- Student Information -->
                <div class="card border-info mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img id="playgroup-student-photo" src="{{ asset('noImage.png') }}" 
                                     alt="Student Photo" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <h5 id="playgroup-student-name" class="mb-2">Student Name</h5>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Class:</small>
                                        <span id="playgroup-student-class" class="fw-semibold ms-1">-</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Admission:</small>
                                        <span id="playgroup-student-admission" class="fw-semibold ms-1">-</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Age:</small>
                                        <span id="playgroup-student-age" class="fw-semibold ms-1">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="editPlaygroupForm">
                    @csrf
                    <input type="hidden" id="playgroup_student_id" name="student_id">
                    <input type="hidden" id="playgroup_session" name="session">
                    <input type="hidden" id="playgroup_term" name="term">

                    <!-- Assessment Areas -->
                    <div class="row g-4">
                        <!-- Cognitive Development -->
                        <div class="col-md-6">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="bx bx-brain me-1"></i>Cognitive Development
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="numeracy" class="form-label">Numeracy Skills</label>
                                        <select id="numeracy" name="numeracy" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="literacy" class="form-label">Literacy Skills</label>
                                        <select id="literacy" name="literacy" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="memory" class="form-label">Memory & Recall</label>
                                        <select id="memory" name="memory" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Development -->
                        <div class="col-md-6">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">
                                        <i class="bx bx-group me-1"></i>Social Development
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="cooperation" class="form-label">Cooperation</label>
                                        <select id="cooperation" name="cooperation" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sharing" class="form-label">Sharing</label>
                                        <select id="sharing" name="sharing" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="leadership" class="form-label">Leadership</label>
                                        <select id="leadership" name="leadership" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Physical Development -->
                        <div class="col-md-6">
                            <div class="card border-warning h-100">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">
                                        <i class="bx bx-run me-1"></i>Physical Development
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="gross_motor" class="form-label">Gross Motor Skills</label>
                                        <select id="gross_motor" name="gross_motor" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fine_motor" class="form-label">Fine Motor Skills</label>
                                        <select id="fine_motor" name="fine_motor" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="coordination" class="form-label">Coordination</label>
                                        <select id="coordination" name="coordination" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Creative Development -->
                        <div class="col-md-6">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="bx bx-palette me-1"></i>Creative Development
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="creativity" class="form-label">Creativity</label>
                                        <select id="creativity" name="creativity" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="arts_crafts" class="form-label">Arts & Crafts</label>
                                        <select id="arts_crafts" name="arts_crafts" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="music_rhythm" class="form-label">Music & Rhythm</label>
                                        <select id="music_rhythm" name="music_rhythm" class="form-select">
                                            <option value="">Select Rating</option>
                                            <option value="Excellent">Excellent</option>
                                            <option value="Very Good">Very Good</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- General Comments -->
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bx bx-message-dots me-1"></i>Teacher's Comments & Recommendations
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="teacher_comment" class="form-label">General Comment</label>
                                        <textarea id="teacher_comment" name="teacher_comment" class="form-control" rows="4" 
                                                  placeholder="Write your observations about the child's overall development and behavior..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recommendations" class="form-label">Recommendations for Improvement</label>
                                        <textarea id="recommendations" name="recommendations" class="form-control" rows="3" 
                                                  placeholder="Suggest areas where the child can improve and activities that can help..."></textarea>
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
                <button type="button" class="btn btn-outline-primary" id="playgroup-preview">
                    <i class="bx bx-show me-1"></i>Preview Assessment
                </button>
                <button type="submit" form="editPlaygroupForm" class="btn btn-info">
                    <i class="bx bx-save me-1"></i>Save Assessment
                </button>
            </div>
        </div>
    </div>
</div>