@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Topics for: {{ $curriculum->name }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('teacher.curriculum') }}" class="btn btn-secondary mb-3">Back to Curriculums</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Week</th>
                <th>Title</th>
                <th>Objectives</th>
                <th>Bloom</th>
                <th>Resources</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topics as $topic)
                <tr>
                    <td>{{ optional($topic->week)->name ?? $topic->week_id }}</td>
                    <td>{{ $topic->title }}</td>
                    <td>{{ $topic->objectives }}</td>
                    <td>{{ $topic->bloom_level }}</td>
                    <td>{{ $topic->resources }}</td>
                    <td>
                        <a href="{{ route('teacher.curriculum.topics.edit', [$curriculum, $topic]) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('teacher.curriculum.topics.destroy', [$curriculum, $topic]) }}" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete topic?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr />
    <h4>Add topic</h4>
    <form method="POST" action="{{ route('teacher.curriculum.topics.store', $curriculum) }}">
        @csrf
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Week</label>
                <select name="week_id" class="form-control" required>
                    @foreach($weeks as $week)
                        <option value="{{ $week->id }}">{{ $week->name ?? $week->start_date->format('d M') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-9 mb-3">
                <label>Title</label>
                <input name="title" class="form-control" required />
            </div>
            <div class="col-md-12 mb-3">
                <label>Objectives</label>
                <textarea name="objectives" class="form-control"></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label>Bloom Level</label>
                <input name="bloom_level" class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
                <label>Resources</label>
                <input name="resources" class="form-control" />
            </div>
        </div>
        <button class="btn btn-primary">Add Topic</button>
    </form>
</div>
@endsection