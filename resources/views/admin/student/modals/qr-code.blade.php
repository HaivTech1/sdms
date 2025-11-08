<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-dark text-white">
                <h5 class="modal-title">
                    <i class="bx bx-qr me-2"></i>Student QR Code
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Student Information -->
                <div class="mb-4">
                    <img id="qr-student-photo" src="{{ asset('noImage.png') }}" 
                         alt="Student Photo" class="rounded-circle img-thumbnail mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <h5 id="qr-student-name" class="mb-1">Student Name</h5>
                    <p class="text-muted mb-0">
                        <span id="qr-student-class">Class</span> • 
                        <span id="qr-student-admission">Admission No.</span>
                    </p>
                </div>

                <!-- QR Code Display -->
                <div class="qr-code-container mb-4">
                    <div id="qr-code-display" class="d-inline-block p-3 bg-white border rounded shadow-sm">
                        <!-- QR Code will be generated here -->
                        <div id="qr-loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Generating QR Code...</span>
                            </div>
                            <p class="mt-2 text-muted small">Generating QR Code...</p>
                        </div>
                    </div>
                </div>

                <!-- QR Code Information -->
                <div class="bg-light p-3 rounded">
                    <h6 class="text-primary mb-2">
                        <i class="bx bx-info-circle me-1"></i>QR Code Information
                    </h6>
                    <div class="row text-start">
                        <div class="col-6">
                            <small class="text-muted">Student ID:</small>
                            <p id="qr-student-id" class="small fw-semibold mb-1">-</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Generated:</small>
                            <p id="qr-generated-date" class="small fw-semibold mb-1">-</p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">URL:</small>
                            <p id="qr-url" class="small fw-semibold text-break mb-0">-</p>
                        </div>
                    </div>
                </div>

                <!-- Usage Instructions -->
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bx bx-bulb me-1"></i>
                        Scan this QR code to quickly access the student's profile and information.
                    </small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Close
                </button>
                <button type="button" class="btn btn-outline-primary" id="copy-qr-url">
                    <i class="bx bx-copy me-1"></i>Copy URL
                </button>
                <button type="button" class="btn btn-primary" id="download-qr">
                    <i class="bx bx-download me-1"></i>Download QR
                </button>
                <button type="button" class="btn btn-success" id="print-qr">
                    <i class="bx bx-printer me-1"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>