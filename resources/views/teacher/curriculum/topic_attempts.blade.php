@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Assessment Attempts for Topic: {{ $topic->title }}</h3>
    <h5>Curriculum: {{ $curriculum->name }}</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Attempts</th>
            </tr>
        </thead>
        <tbody>
        @forelse($students as $row)
            <tr>
                <td>{{ $row['student'] ? $row['student']->name : 'Unknown' }}</td>
                <td>
                    @foreach($row['attempts'] as $attemptId => $answers)
                        <div class="mb-2">
                            <strong>Attempt #{{ $attemptId }}</strong>
                            <ul>
                                @foreach($answers as $ans)
                                    <li>Q#{{ $ans->question_id }}: Selected {{ $ans->answer_index }}, Correct: {{ $ans->is_correct ? 'Yes' : 'No' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </td>
            </tr>
        @empty
            <tr><td colspan="2">No attempts found for this topic.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
