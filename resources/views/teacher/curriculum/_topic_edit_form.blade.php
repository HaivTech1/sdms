<form id="editTopicForm" method="POST" action="{{ route('teacher.curriculum.topics.update', [$curriculum, $topic]) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Week</label>
        <select name="week_id" class="form-control">
            @foreach($weeks as $index => $week)
                <option value="{{ $week->id }}" @if($week->id == $topic->week_id) selected @endif>{{ $index +1 }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input name="title" class="form-control" value="{{ old('title', $topic->title) }}" placeholder="Enter topic title" />
    </div>

    <div class="mb-3">
        <label>Objectives</label>
        <textarea name="objectives" class="form-control">{{ old('objectives', $topic->objectives) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Bloom Level</label>
        <select name="bloom_level" class="form-control" required>
            <option value="" disabled {{ old('bloom_level', $topic->bloom_level) ? '' : 'selected' }}>Select Bloom level</option>
            @foreach(['Remember','Understand','Apply','Analyze','Evaluate','Create'] as $level)
                <option value="{{ $level }}" {{ old('bloom_level', $topic->bloom_level) == $level ? 'selected' : '' }}>{{ $level }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Resources</label>
        <input name="resources" class="form-control" value="{{ old('resources', $topic->resources) }}" />
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
