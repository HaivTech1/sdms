<!-- Generate List Modal -->
<div class="modal fade generateStudentList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-list-ul me-2"></i>Generate Student List
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generate-list-form" action="{{ route('student.download-pdf') }}" method="post" target="_blank">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="select_class" class="form-label fw-semibold">
                                <i class="bx bx-book me-1"></i>Class
                            </label>
                            <select id="select_class" name="grade_id" class="form-select" required>
                                <option value="">Select Class</option>
                                @foreach(($grades ?? []) as $grade)
                                    <option value="{{ $grade->id() }}">{{ $grade?->title() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="list_type" class="form-label fw-semibold">
                                <i class="bx bx-file me-1"></i>List Type
                            </label>
                            <select id="list_type" name="type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option selected value="name_list">Name List</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i>Cancel
                </button>
                <button type="submit" form="generate-list-form" class="btn btn-success">
                    <i class="bx bx-download me-1"></i>Generate & Download
                </button>
            </div>
        </div>
    </div>
</div>