<table class="table table-striped">
    <thead>
        <tr>
            <th>Week</th>
            <th>Title</th>
            <th>Duration</th>
            <th>Objectives</th>
            <th>Bloom</th>
            <th>Resources</th>
            <th>Questions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($topics as $topic)
            <tr data-id="{{ $topic->id }}">
                <td>{{ optional($topic->week)->name ?? $topic->week_id }}</td>
                <td class="topic-title">{{ $topic->title }}</td>
                <td class="topic-duration">{{ $topic->test_duration }} minutes</td>
                <td class="topic-objectives">{{ \Str::limit(strip_tags($topic->objectives), 100) }}</td>
                <td class="topic-bloom">{{ $topic->bloom_level }}</td>
                <td class="topic-resources">{{ $topic->resources }}</td>
                <td class="topic-questions">
                    @php $count = $topic->questions_count ?? $topic->questions()->count(); @endphp
                    <a href="{{ route('teacher.curriculum.topics.questions', [$curriculum, $topic]) }}">Questions ({{ $count }})</a>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-topic" data-url="{{ route('teacher.curriculum.topics.edit', [$curriculum, $topic]) }}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-topic" data-url="{{ route('teacher.curriculum.topics.destroy', [$curriculum, $topic]) }}">Delete</button>
                    <button class="btn btn-sm btn-success generate-questions">Questions</button>
                    <a href="{{ route('teacher.curriculum.topics.attempts', [$curriculum, $topic]) }}" class="btn btn-sm btn-info">View Attempts</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No topics found</td></tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{-- If topics is a LengthAwarePaginator this will render links; otherwise nothing --}}
    @if(method_exists($topics, 'links'))
        {!! $topics->links() !!}
    @endif
</div>
