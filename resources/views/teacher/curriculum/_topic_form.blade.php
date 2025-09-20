<form id="createTopicForm" method="POST" action="{{ route('teacher.curriculum.topics.store', $curriculum) }}">
    @csrf
    <div class="row">
        <div class="col-md-3 mb-3">
            <label>Week</label>
            <select name="week_id" class="form-control" required>
                @foreach($weeks as $index => $week)
                    <option value="{{ $week->id }}">{{ $index + 1 }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-9 mb-3">
            <label>Title</label>
            <input name="title" class="form-control" placeholder="Enter topic title" required />
        </div>
        <div class="col-md-12 mb-3">
            <label>Objectives</label>
            <textarea name="objectives" class="form-control" placeholder="Describe learning objectives (use rich text formatting)"></textarea>
        </div>
        <div class="col-md-6 mb-3">
            <label>Bloom Level</label>
            <select name="bloom_level" class="form-control" required>
                <option value="" disabled selected>Select Bloom level</option>
                <option value="Remember">Remember</option>
                <option value="Understand">Understand</option>
                <option value="Apply">Apply</option>
                <option value="Analyze">Analyze</option>
                <option value="Evaluate">Evaluate</option>
                <option value="Create">Create</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label>Resources</label>
            <input name="resources" class="form-control" placeholder="e.g., worksheet URL or notes" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Topic</button>
    </div>
</form>
