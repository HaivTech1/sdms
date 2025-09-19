@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Curriculum</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('teacher.curriculum.update', $curriculum) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name', $curriculum->name) }}" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $curriculum->description) }}</textarea>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('teacher.curriculum') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection