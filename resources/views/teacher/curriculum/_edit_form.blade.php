<form id="editCurriculumForm" method="POST" action="{{ route('teacher.curriculum.update', $curriculum) }}" data-current-subject="{{ $curriculum->subject_id }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ old('name', $curriculum->name) }}" required />
    </div>

    <div class="mb-3">
        <label class="form-label">Grade</label>
        <select name="grade_id" id="edit_grade_id" class="form-control" required>
            @foreach($grades as $g)
                <option value="{{ $g->id }}" {{ $g->id == $curriculum->grade_id ? 'selected' : '' }}>{{ $g->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Subject</label>
        <select name="subject_id" id="edit_subject_id" class="form-control" required>
            {{-- will be populated by JS from gradeSubjectsMap --}}
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Period</label>
        <select name="period_id" class="form-control" required>
            @foreach($periods as $p)
                <option value="{{ $p->id }}" {{ $p->id == $curriculum->period_id ? 'selected' : '' }}>{{ $p->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Term</label>
        <select name="term_id" class="form-control" required>
            @foreach($terms as $t)
                <option value="{{ $t->id }}" {{ $t->id == $curriculum->term_id ? 'selected' : '' }}>{{ $t->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $curriculum->description) }}</textarea>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Save</button>
    </div>
</form>

<script>
    // The index view will expose a global `gradeSubjects` map (provided on the page) and a helper populateSubjects.
    // Here, just wire up change handler and set initial value; the actual populateSubjects function
    // will be used from the index page's scope.
    $(function(){
        try {
            const $select = $('#edit_subject_id');
            const currentGrade = $('#edit_grade_id').val();

            // Prefer the shared helper if present
            if (typeof populateSubjectsFor === 'function') {
                populateSubjectsFor(currentGrade, '#edit_subject_id');
            } else {
                const subs = (window.gradeSubjects && window.gradeSubjects[currentGrade]) || [];
                $select.empty();
                if (subs.length === 0) {
                    $select.append($('<option>').text('No subjects for selected grade').attr('value',''));
                    $select.prop('disabled', true);
                } else {
                    $select.prop('disabled', false);
                    $select.append($('<option>').text('-- Select subject --').attr('value',''));
                    subs.forEach(function(s){ $select.append($('<option>').attr('value', s.id).text(s.title)); });
                }
            }

            // set initial value from data attribute on the form
            $select.val($('#editCurriculumForm').data('current-subject'));

            $('#edit_grade_id').on('change', function(){
                const gradeId = $(this).val();
                if (typeof populateSubjectsFor === 'function') {
                    populateSubjectsFor(gradeId, '#edit_subject_id');
                    return;
                }
                const items = (window.gradeSubjects && window.gradeSubjects[gradeId]) || [];
                $select.empty();
                if (items.length === 0) {
                    $select.append($('<option>').text('No subjects for selected grade').attr('value',''));
                    $select.prop('disabled', true);
                } else {
                    $select.prop('disabled', false);
                    $select.append($('<option>').text('-- Select subject --').attr('value',''));
                    items.forEach(function(s){ $select.append($('<option>').attr('value', s.id).text(s.title)); });
                }
            });
        } catch (e) { console.log(e); }
    });
</script>
