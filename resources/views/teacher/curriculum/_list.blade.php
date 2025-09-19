<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Grade</th>
            <th>Subject</th>
            <th>Period</th>
            <th>Term</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($curriculums as $curriculum)
            <tr>
                <td>{{ $curriculum->name }}</td>
                <td>{{ optional($curriculum->grade)->name }}</td>
                <td>{{ optional($curriculum->subject)->title }}</td>
                <td>{{ optional($curriculum->period)->name }}</td>
                <td>{{ optional($curriculum->term)->name }}</td>
                <td>
                    <a href="{{ route('teacher.curriculum.edit', $curriculum) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <a href="{{ route('teacher.curriculum.topics', $curriculum) }}" class="btn btn-sm btn-info">Topics</a>
                    <form method="POST" action="{{ route('teacher.curriculum.destroy', $curriculum) }}" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete curriculum?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No curriculums found</td></tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $curriculums->links() !!}
</div>