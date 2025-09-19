@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Topic - {{ $topic->title }}</h3>

    <form method="POST" action="{{ route('teacher.curriculum.topics.update', [$curriculum, $topic]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Week</label>
            <select name="week_id" class="form-control">
                @foreach($weeks as $week)
                    <option value="{{ $week->id }}" @if($week->id == $topic->week_id) selected @endif>{{ $week->name ?? $week->start_date->format('d M') }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title', $topic->title) }}" />
        </div>

        <div class="mb-3">
            <label>Objectives</label>
            <textarea name="objectives" class="form-control">{{ old('objectives', $topic->objectives) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Bloom Level</label>
            <input name="bloom_level" class="form-control" value="{{ old('bloom_level', $topic->bloom_level) }}" />
        </div>

        <div class="mb-3">
            <label>Resources</label>
            <input name="resources" class="form-control" value="{{ old('resources', $topic->resources) }}" />
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('teacher.curriculum.topics', $curriculum) }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection