<!-- Passport Upload Modal -->
<div class="modal fade updatePassport" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-camera me-2"></i>Upload Passport Photograph
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modalErrorr"></div>

                <form id="upload" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input id="student_passport_id" name="student_id" type="hidden" />

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="bx bx-image me-1"></i>Select Photo
                                </label>
                                <input id="image" class="form-control" type="file" name="image" accept="image/*"/>
                                <div class="form-text">Supported formats: JPG, PNG, GIF (Max: 2MB)</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-center">
                                <label class="form-label fw-semibold">Preview</label>
                                <div id="img-show-container" style="display: none;">
                                    <canvas style="border-radius: 8px; width: 150px; height: 150px; border: 2px solid #dee2e6;" 
                                            id="img-show" class="img-thumbnail"></canvas>
                                </div>
                                <div id="no-preview" class="border rounded p-4 bg-light">
                                    <i class="bx bx-image font-size-48 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">No image selected</p>
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
                <button type="submit" id="submit_passport" form="upload" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i>Save Photo
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\primary\resources\views/admin/student/modals/passport-upload.blade.php ENDPATH**/ ?>