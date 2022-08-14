@if ($student_details)
<div id="details" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true"
    wire:ignore>
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalFullscreenLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>Assign Subject</h1>

                                <form action="{{ route('student.assignSubject') }}" method="POST">
                                    @csrf

                                    <x-form.input type="hidden" value="{{ $student_details->id() }}"
                                        name="student_id" />

                                    <div class="col-sm-12 mt-2">
                                        <x-form.label for='subjects' value="{{ __('Classes') }}" />
                                        <select name="subjects[]" class="form-control select2-multiple" multiple>
                                            @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id() }}">{{ $subject->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="subjects" />
                                    </div>

                                    <div class="col-sm-12 mt-2">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-secondary">Add</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="col-sm-6">
                                <h1>Assigned Subjects</h1>
                                <ul>
                                    @foreach ($student_details->subjects as $subject)
                                    <li>{{ $subject->title() }}</li>
                                    @endforeach
                                </ul>
                                @if ($student_details->subjects )
                                <button class="btn btn-primar waves-effect">Update Subjects</button>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>
@endif