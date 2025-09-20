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
                <td>{{ optional($curriculum->grade)->title }}</td>
                <td>{{ optional($curriculum->subject)->title }}</td>
                <td>{{ optional($curriculum->period)->title }}</td>
                <td>{{ optional($curriculum->term)->title }}</td>
                <td>
                    @php $me = auth()->user(); @endphp
                    @if($me->isAdmin() || $curriculum->isAuthoredBy($me))
                        <button type="button" class="btn btn-sm btn-primary edit-curriculum" data-url="{{ route('teacher.curriculum.edit', $curriculum) }}"><i class="bx bx-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete-curriculum" type="button" data-url="{{ route('teacher.curriculum.destroy', $curriculum) }}"><i class="bx bx-trash"></i></button>
                    @endif
                    <a href="{{ route('teacher.curriculum.topics', $curriculum) }}" class="btn btn-sm btn-info">Topics</a>
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