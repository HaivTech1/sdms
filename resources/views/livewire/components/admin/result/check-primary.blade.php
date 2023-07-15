<div>
    <x-loading />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                            <div class="d-flex gap-2">
                                @admin
                                    <div>
                                        <button data-bs-toggle="modal" data-bs-target=".refreshResultModal" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Reset Midterm Result</button>
                                    </div>
                                 @endadmin
                                <div class="">
                                    <button class="btn btn-sm btn-secondary" 
                                        data-bs-toggle="modal"
                                        data-bs-target=".excelResultModal" 
                                    >
                                        <i class="bx bxs-file-doc"></i> 
                                        Upload Excel Result
                                    </button>
                                </div>
                                @superadmin
                                    <div>
                                        <button data-bs-toggle="modal" data-bs-target=".generateResultModal" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Generate Midterm Result</button>
                                    </div>
                                @endsuperadmin
                            </div>
                        <div class="mt-2">
                            <form id="fetchResultForm">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-control" id="grade_id" name="grade_id">
                                            <option value=''>Class</option>
                                            @foreach ($grades as $grade)
                                            <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <select class="form-control" id="period_id" name="period_id">
                                            <option value=''>Select Session</option>
                                            @foreach ($periods as $period)
                                            <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="period_id" />
                                    </div>

                                    <div class="col-lg-3">
                                        <select class="form-control" id="term_id" name="term_id">
                                            <option value=''>Select Term</option>
                                            @foreach ($terms as $term)
                                            <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-form.error for="term_id" />
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <button type="submit" id="fetchResultButton" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 py-4">
                            <div class="table-responsive">
                                <table id="result-data" class="table table-bordered table-striped table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Name of Student</th>
                                            <th scope="col" class="text-center">
                                                Recorded Subjects
                                            </th>
                                            <th scope="col" class="text-center" id="action">
                                                Action
                                            </th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>

                                    {{-- <tbody wire:ignore>
                                        @foreach ($students as $student)
                                        <tr>
                                            <td class='text-center'>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                            <td class='text-center'>
                                                {{ $student->primaryResults->where('term_id', $term_id)->where('period_id', $period_id)->count() }}
                                            </td>
                                            @php
                                                $comments = \App\Models\Cognitive::where([
                                                    'student_uuid' => $student->id(),
                                                    'term_id' => $term_id,
                                                    'period_id' => $period_id
                                                ])->first()
                                            @endphp
                                            
                                            <td class='d-flex justify-content-center align-items-center gap-2'>
                                                
                                                <button 
                                                    wire:key="{{ $student->id() }}"
                                                    type="button"
                                                    class="btn btn-sm btn-secondary recorded"
                                                    data-student="{{ $student->id() }}"
                                                    data-grade="{{ $grade_id }}"
                                                    data-period="{{ $period_id }}"
                                                    data-term="{{ $term_id }}"
                                                >
                                                    <i class="fa fa-cogs"></i> View Recorded
                                                </button>
                                                <button 
                                                            wire:key="{{ $student->id() }}"
                                                            type="button"
                                                            wire:ignore class="btn btn-sm btn-info editCom"
                                                            data-id="{{$student->id()}}" 
                                                            data-term="{{$term_id}}"
                                                            data-period="{{$period_id}}"
                                                            data-total="{{$comments->attendance_duration ?? ''}}"
                                                            data-present="{{$comments->attendance_present ?? ''}}"
                                                            data-comment="{{$comments->comment ?? ''}}"
                                                    >
                                                        Comment
                                                </button>
                                                @if (affectives($student, $term_id, $period_id) === false)
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" class="btn btn-sm btn-secondary uploadAffective" 
                                                        data-student="{{ $student->id() }}"
                                                        data-period="{{ $period_id }}"
                                                        data-term="{{ $term_id }}"
                                                    >
                                                        <i class="fas fa-compress-arrows-alt"></i>
                                                        Affective
                                                    </button>
                                                @endif
                                                @if (psychomotors($student, $term_id, $period_id) === false)
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" 
                                                        class="btn btn-sm btn-secondary uploadPsychomotor"
                                                        data-student="{{ $student->id() }}"
                                                        data-period="{{ $period_id }}"
                                                        data-term="{{ $term_id }}"
                                                    >
                                                        <i class="fas fa-compress-arrows-alt"></i>
                                                        Psychomotor
                                                    </button>
                                                @endif
                                                <a class="btn btn-sm btn-success" href="{{ route('result.primary.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Click to view result">
                                                    <i class="bx bx-show"></i>
                                                    Show
                                                </a>
                                                @admin
                                                    @if (publishExamState($student->id(), $period_id, $term_id))
                                                        <div class="d-flex gap-2">
                                                            <button type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                <span class="badge bg-success"><i class="bx bx-upload"></i> Published</span>
                                                            </button>
                                                            <form action="{{ route('result.exam.pdf') }}" method="POST">
                                                                @csrf

                                                                <input type="hidden" name="student_id" value="{{ $student->id() }}" />
                                                                <input type="hidden" name="grade_id" value="{{ $student->grade->id() }}" />
                                                                <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                <input type="hidden" name="term_id" value="{{ $term_id }}" />

                                                                <button class="btn btn-sm btn-info" type="submit">
                                                                    <i class="bx bxs-file-pdf"></i> PDF
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-primary" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                            <i class="bx bx-upload"></i> Publish
                                                        </button>
                                                    @endif
                                                    <button 
                                                        wire:key="{{ $student->id() }}"
                                                        type="button" 
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteResultModal"
                                                        wire:click="deleteResult('{{ $student->id() }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                @endadmin
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade excelResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload excel result sheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="excelResultUpload" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <select class="form-control" name="grade_id" id="excel_grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 student-select">
                                    <select class="form-control" name="student_id">
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control " name="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="col-lg-2">
                                    <select class="form-control select2" name="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>

                                <div class="col-lg-2">
                                    <x-form.input id="excel" class="block w-full" type="file" name="excel_file"/>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="excel_upload_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createCommentModal" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comment and Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12 mt-4">

                                <form id="createComment" method="POST">
                                    @csrf
                                    <input type="hidden" name="student_uuid" id="student" />
                                    <input type="hidden" name="period_id" id="periodC" />
                                    <input type="hidden" name="term_id" id="termC" />

                                    <div class="row mt-2">
                                        <div class="col-sm-6 mb-3">
                                            <x-form.label for="attendance_duration" value="{{ __('Total times school openned') }}" />
                                            <x-form.input id="attendance_duration" class="block w-full mt-1" type="text" name="attendance_duration"
                                                :value="old('attendance_duration')" id="attendance_duration" autofocus />
                                            <x-form.error for="attendance_duration" />
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <x-form.label for="attendance_present" value="{{ __('Total times present') }}" />
                                            <x-form.input id="attendance_present" class="block w-full mt-1" type="text" name="attendance_present"
                                                :value="old('attendance_present')" id="attendance_present" autofocus />
                                            <x-form.error for="attendance_present" />
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-form.label for="comment" value="{{ __('Comment on result') }}" />
                                                    <textarea class="form-control" name="comment" id="attendance_comment"></textarea>
                                            <x-form.error for="comment" />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button id="submit_comment" type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createAffectiveModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Affective domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12">

                                <form id="createAffective" action="{{ route('result.affective.upload') }}" method="POST">
                                    @csrf

                                    <input type="hidden" id="affective_student_id" name="student_uuid" />
                                    <input type="hidden" id="affective_period_id" name="period_id" />
                                    <input type="hidden" id="affective_term_id" name="term_id" />

                                    @php
                                        $affectives = get_settings('affective_domain');
                                        $psychomotors = get_settings('psychomotor_domain');
                                    @endphp
                                            
                                    <div class="row mt-2">
                                        @if ($affectives)
                                            @foreach ($affectives as $key => $affectives)
                                                <div class="col-sm-12 mb-2">
                                                    <input type="hidden" name="title[]" value="{{ $affectives }}" />
                                                    <div class="input-group">
                                                        <div class="input-group-text">{{ $affectives }}</div>
                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                    <div class="row justify-content-center align-items-center mt-2">
                                        <button id="affective_button" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createPsychomotorModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Psychomotor domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-xl-12">

                                <form id="createPsychomotor" action="{{ route('result.psychomotor.upload') }}" method="POST">
                                    @csrf

                                    <input type="hidden" id="psychomotor_student_id" name="student_uuid" />
                                    <input type="hidden" id="psychomotor_period_id" name="period_id" />
                                    <input type="hidden" id="psychomotor_term_id" name="term_id" />
                                    
                                    <div class="row mt-2">
                                        @if ($psychomotors)
                                            
                                        @endif
                                        @foreach ($psychomotors as $psychomotor)
                                            <div class="col-sm-12 mb-2">
                                                <input type="hidden" name="title[]" value="{{ $psychomotor }}" />
                                                    <div class="input-group">
                                                    <div class="input-group-text">{{ $psychomotor }}</div>
                                                    <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row justify-content-center align-items-center mt-2">
                                        <button id="psychomotor_button" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteResultModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirm Delete Result!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modal-title">Are you sure you want to delete this result?</p>
                </div>
                 <div class="modal-footer">
                    <form wire:submit.prevent="destroyResult">
                        <div class="">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" type="submit">Yes delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade previewResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Result Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                            <div class="row">

                                <div class="card">
                                    <div class="card-header">
                                        <button data-student-id="" class="btn btn-sm btn-secondary addResult" ><i class="bx bx-plus"></i> Add Result</button>
                                    </div>
                                </div>

                                <input name="result_id" id="result_id" type="hidden" />

                                <div class="col-sm-12 mb-2">
                                    @php
                                        $examForm = get_settings('exam_format');
                                    @endphp
                                    <div class="table-responsive">
                                        <table id="students-result" class="table table-borderless">

                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    @foreach ($examForm as $key => $value)
                                                        <th>{{ $value['full_name'] }}</th>
                                                    @endforeach
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" id="scoreInput" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveScoreBtn">Save</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade addResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="resultUpload" method="POST">
                            @csrf
                            <input name="student_id" id="add_student_id" type="hidden" />

                            @php
                                $examForm = get_settings('exam_format');
                                $subjects = \App\Models\Subject::all();
                            @endphp

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="subject_id">
                                        <option value=''>Subject</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select id="format-select" class="form-control">
                                        <option value="">Select test type</option>
                                        @foreach ($examForm as $key => $value)
                                            <option value="{{ $key }}">{{ $value['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <x-form.input style='width: 70px' class="text-center required exam-input" type='number'
                                        name='' value="" step="0.01" onblur="validateInput(this)" disabled/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="submit_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade refreshResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset midterm scores for class exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="refreshResult" method="POST">
                            @csrf
                            @php
                                $grades = \App\Models\Grade::all();
                                $periods = \App\Models\Period::all();
                                $terms = \App\Models\Term::all();
                            @endphp

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id">
                                        <option value=''>Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id">
                                        <option value=''>Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="refresh_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Refresh Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade generateResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate midterm scores from midterm exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="generateResult" method="POST">
                            @csrf
                            @php
                                $grades = \App\Models\Grade::all();
                                $periods = \App\Models\Period::all();
                                $terms = \App\Models\Term::all();
                            @endphp

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-4">
                                    <select class="form-control" name="period_id">
                                        <option value=''>Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select class="form-control" name="term_id">
                                        <option value=''>Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="generate_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Generate Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    <script>

        $('#fetchResultForm').on('submit', function(e){
            e.preventDefault();
            var button = $('#fetchResultButton');
            toggleAble(button, true, 'Fetching...');

            var grade = $('#grade_id').val();
            var period = $('#period_id').val();
            var term = $('#term_id').val();

            $.ajax({
                url: '{{ route("result.check.exam", ["period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':grade_id', grade),
                type: 'GET',
                dataType: 'json',
            }).done((response) => {
                toggleAble(button, false);
                var students = response.students;

                var html = '';

                $.each(students, function(index, student) {
                    html += '<tr>';
                    html += '<td class="text-center">' + student.name + '</td>';
                    html += '<td class="text-center">' + student.recorded_subjects + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-secondary recorded" data-grade="'+response.grade+'" data-period="'+response.period+'" data-term="'+response.term+'" data-student="' + student.id + '"><i class="fa fa-cogs"></i> View Recorded</button>';
                    html += '<button class="btn btn-sm btn-info editCom" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '"><i class="bx bx-conversation"></i> Comment</button>';
                    html += '<a href="{{ route('result.primary.show', ['student' => ':student']) }}'.replace(':student', student.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                    html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()): ?>';                   
                    html += '<button class="btn btn-sm btn-secondary uploadAffective" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                    html += '<i class="fas fa-compress-arrows-alt"></i> Affective';
                    html += '</button>';
                    html += '<?php endif; ?>';
                    html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->gradeClassTeacher()->exists()): ?>';                   
                    html += '<button class="btn btn-sm btn-secondary uploadPsychomotor gap-2" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + student.id + '">';
                    html += '<i class="fas fa-compress-arrows-alt"></i> Psychomotor';
                    html += '</button>';
                    html += '<?php endif; ?>';
                    html += '<div class="d-flex gap-2">';
                    html += '<?php if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin()): ?>';
                    html += '<?php if (publishMidState(' + student.id + ', ' + response.period + ', ' + response.term + ')): ?>';
                    html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + '\', ' + response.period + ', ' + response.term + ', ' + response.grade + ')">';
                    html += '<span>Publish</span>';
                    html += '</button>';
                    html += '<form action="{{ route('result.exam.pdf') }}" method="POST">';
                    html += '@csrf';
                    html += '<input type="hidden" name="student_id" value="' + student.id + '" />';
                    html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                    html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                    html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                    html += '<button class="btn btn-sm btn-info" type="submit">';
                    html += '<i class="bx bxs-file-pdf"></i> PDF';
                    html += '</button>';
                    html += '</form>';
                    html += '<?php else: ?>';
                    html += '<button class="btn btn-sm btn-primary" type="button" id="cummulative' + student.id + '" onClick="publish(\'' + student.id + '\', ' + response.period + ', ' + response.term + ', ' + response.grade + ')">';
                    html += '<i class="mdi mdi-upload d-block font-size-16"></i> Publish';
                    html += '</button>';
                    html += '<?php endif; ?>';
                    html += '<?php endif; ?>';
                    html += '</div>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#result-data tbody').html(html);

                $('.recorded').on('click', function(e){
                    var button = $(this);
                    toggleAble(button, true)

                    var id = $(this).data('student');
                    var classId = $(this).data('grade');
                    var sessionId = $(this).data('period');
                    var termId = $(this).data('term');


                    $.ajax({
                        url: '{{ route("result.fetch.exam", ["student_id" => ":student_id",  "period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':student_id', id).replace(':period_id', sessionId).replace(':term_id', termId).replace(':grade_id', classId),
                        type: 'GET',
                        dataType: 'json',
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;

                        var html = '';
                        $.each(results, function(index, result) {
                        html += '<tr>';
                        html += '<td>' + result.subject_name + '</td>';

                        var resultScores = results;
                        var examFormat = JSON.parse('<?php echo json_encode($examForm); ?>');

                        $.each(examFormat, function(examKey, examValue) {
                            var score = '-';
                            if (examKey in result) {
                                score = result[examKey];
                            }
                            html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="' + examKey + '">' + score + '</td>';
                        });

                        html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + result.result_id + '"><i class="bx bx-trash"></button></td>';
                        html += '</tr>';
                        });

                        $('#students-result tbody').html(html);
                        $('.addResult').data('student-id', id)
                        $('.previewResultModal').modal('toggle');

                        $('.score-cell').click(function() {
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var examKey = $(this).data('exam-key');
                            var currentScore = $(this).text();
                            $('#scoreInput').val(currentScore);
                            $('#saveScoreBtn').data('result-id', resultId);
                            $('#saveScoreBtn').data('subject-id', subjectId);
                            $('#saveScoreBtn').data('exam-key', examKey);
                            $('#editModal').modal('show');
                        });

                        $('#saveScoreBtn').click(function() {
                            var button = $(this);
                            toggleAble(button, true, 'Updating...');
                            var resultId = $(this).data('result-id');
                            var subjectId = $(this).data('subject-id');
                            var examKey = $(this).data('exam-key');
                            var editedScore = $('#scoreInput').val();

                            Swal.fire({
                                title: 'Confirm Submission',
                                text: 'Are you sure you want to update the score?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#502179',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Update'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                    });
                                    
                                    $.ajax({
                                        url: '{{ route('result.update.exam') }}',
                                        type: 'POST',
                                        data: {result_id: resultId, subject_id: subjectId, field: examKey, score: editedScore},
                                    }).done((response) => {
                                        toggleAble(button, false);
                                        Swal.fire('Updated!', response.message, 'success');
                                        $('.score-cell[data-subject-id="' + subjectId + '"][data-exam-key="' + examKey + '"]').text(editedScore);
                                        $('#editModal').modal('toggle');
                                    }).fail((error) => {
                                        toggleAble(button, false);
                                        console.log(error);
                                        toastr.error(error.responseJSON.message, 'Failed!');
                                    });
                                }else{
                                    toggleAble(button, false);
                                }
                            });
                        });

                        $('.addResult').click(function(){
                            $('.previewResultModal').modal('toggle');
                            var student = $(this).data('student-id');
                            document.getElementById('add_student_id').value = student;
                            $('.addResultModal').modal('toggle');
                        });

                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                        console.log(error);
                    });

                });

                $(".editCom").click(function(e) {
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');
                    
                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.student.comment', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        console.log(response.comment);
                        if(response.comment != undefined || response.comment != null){
                            var total = response.comment.total;
                            var present = response.comment.present;
                            var comment = response.comment.comment;

                            document.getElementById('attendance_duration').value=total;
                            document.getElementById('attendance_present').value=present;
                            document.getElementById('attendance_comment').value=comment;
                        }else{
                            document.getElementById('attendance_duration').value = ' ';
                            document.getElementById('attendance_present').value = '';
                            document.getElementById('attendance_comment').value = '';
                        }

                        document.getElementById("student").value=id;
                        document.getElementById('periodC').value=period;
                        document.getElementById('termC').value=term;
                        $("#createCommentModal").modal('toggle');

                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                $(".uploadAffective").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createAffectiveModal").modal('toggle');

                    document.getElementById("affective_student_id").value = student;
                    document.getElementById('affective_period_id').value = period;
                    document.getElementById('affective_term_id').value = term;
                });

                $(".uploadPsychomotor").click(function(e) {
                    e.preventDefault();

                    var student = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $("#createPsychomotorModal").modal('toggle');

                    document.getElementById("psychomotor_student_id").value = student;
                    document.getElementById('psychomotor_period_id').value = period;
                    document.getElementById('psychomotor_term_id').value = term;
                });

            }).fail((error) => {
                toggleAble(button, false);
                toastr.error(error.responseJSON.message);
                console.log(error);
            });
        });

        $(document).ready(function(){
            $('.exam-input').prop('disabled', true);

            $('#format-select').on('change', function() {
                var selectedFormat = $(this).val();
                $('.exam-input').prop('disabled', true);
                
                if (selectedFormat !== '') {
                    $('.exam-input').prop('disabled', false);
                    $('.exam-input').attr('name', selectedFormat);
                    } else {
                    $('.exam-input').attr('name', '');
                }
            });
        });

        function validateInput(input) {
            var selectedFormat = $('#format-select').val();
            var marks = JSON.parse('{!! json_encode($examForm) !!}');
            var mark = parseFloat(marks[selectedFormat].mark);
            var value = parseFloat(input.value);

            if (value > mark) {
                input.classList.add('is-invalid');
                input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
            } else {
                input.nextElementSibling.textContent = '';
                input.classList.remove('is-invalid');
            }
        }
        
    </script>

    <script>
        $(document).ready(function() {
            var student_uuid = $("input[name=student_uuid]").val();
            var period_id = $("input[name=period_id]").val();
            var term_id = $("input[name=term_id]").val();
            
            $('#createAffective').submit((e) => {
                e.preventDefault();
                toggleAble('#affective_button', true, 'Submitting...');

                var data = $('#createAffective').serializeArray();
                var url = "{{ route('result.affective.upload') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data,
                }).done((res) => {
                    toggleAble('#affective_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createAffective');
                     $("#createAffectiveModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#affective_button', false);
                });
            });

            $('#createPsychomotor').submit((e) => {
                e.preventDefault();
                toggleAble('#psychomotor_button', true, 'Submitting...');

                var data = $('#createPsychomotor').serializeArray();
                var url = "{{ route('result.psychomotor.upload') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#psychomotor_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#createPsychomotor');
                    $("#createPsychomotorModal").modal('toggle');

                    setTimeout(()=> {
                        window.location.reload();
                    }, 1000)
                }).fail((res) => {
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#psychomotor_button', false);
                });

                
            });

            $('#createComment').submit((e) => {
                e.preventDefault();
                toggleAble('#submit_comment', true, 'Submitting...');

                var data = $('#createComment').serializeArray();
                var url = '/result/cognitive/upload';
                var type = $(this).attr('method')

                $.ajax({
                    type: 'POST',
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit_comment', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createComment');
                        $("#createCommentModal").modal('toggle');
                        {{-- setTimeout(function(){
                            window.location.reload();
                        }, 1000); --}}
                    }
                }).fail((res) => {
                    toggleAble('#submit_comment', false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            });

            $.ajax({
                type: "GET",
                url: "{{ route('result.psychomotor.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                psy = data
                if(data.length > 0){
                    $("#psychomoting").css("display", "none");
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ route('result.affective.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#affecting").css("display", "none");
                }
            })

            $.ajax({
                type: "GET",
                url: "{{ route('result.cummulative.get') }}",
                data: {student_uuid, period_id, term_id }
            }).done((res) => {
                var data = res.data
                if(data.length > 0){
                    $("#cummulative").css("display", "none");
                }
            })
            
        });
    </script>

    <script>
        function publish(student){
            var data = student.split(",");
            var student_id = data[0];
            var period_id = data[1];
            var term_id = data[2];
            var grade_id = data[3];
            
            toggleAble('#cummulative'+ student_id, true);

            $.ajax({
                url: '{{ route('result.primary.publish') }}' ,
                method: 'GET',
                data: {student_id, period_id, term_id, grade_id }
            }).done((res) => {
                toggleAble('#cummulative'+ student_id, false);
                toastr.success(res.message, 'Success!');
            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#cummulative'+ student_id, false);
            });
        }
    </script>

    <script>
       
        $(document).on('click', '.remove', function(e) {
            e.preventDefault();
            var button = $(this);
            toggleAble(button, true);
            var resultId = $(this).data('id');
            var row = $(this).closest('tr');

            Swal.fire({
                    title: 'Confirm Deletion',
                    text: 'Are you sure you want to delete this item?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });

                    $.ajax({
                        url: "{{ route('result.delete.exam', ["result_id" => ":result_id"]) }}".replace(':result_id', resultId),
                        method: 'DELETE',
                        success: function(response) {
                            toggleAble(button, false);
                            Swal.fire('Deleted!', response.message, 'success');
                            row.remove();
                            setTimeout(function(){
                                window.location.reload();
                            },1000)
                        },
                        error: function(response) {
                            toggleAble(button, false);
                            console.log(response.responseJSON.message);
                        }
                    });
                    
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#resultUpload').on('submit', function(event) {
            event.preventDefault();
            var button = $('#submit_button')
            toggleAble(button, true, 'Submitting...');
            var selectedFormat = $('#format-select').val();

            if (selectedFormat === '') {
                toastr.info('Please select the score type', 'Note!');
                toggleAble(button, false);
                return;
            }else{
                let inputs = $('.midterm-input.required');
                let invalid = false;

                inputs.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').html('This field is required.');
                        invalid = true;
                    }
                });

                if (invalid) {
                    toggleAble(button, false);
                    toastr.error('Please fill in all required fields.', 'Validation Error!');
                    return;
                }

                var url = "{{ route('result.add.exam') }}";
                var data = $('#resultUpload').serializeArray();

                var period = $('#period_id').val();
                var term = $('#term_id').val();

                data.push({ 
                    name: 'format', value: selectedFormat,
                });

                data.push({ 
                    name: 'period_id', value: period,
                });

                data.push({ 
                    name: 'term_id', value: term,
                });

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#resultUpload');
                }).fail((err) => {
                    toggleAble(button, false);
                    let allErrors = Object.values(err.responseJSON).map(el => (
                    el = `<li>${el}</li>`
                    )).reduce((next, prev) => (next = prev + next));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>${allErrors}</ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;

                    $('.modalErrorr').html(setErrors);
                });
            }
        })

        $('#refreshResult').on('submit', function(e){
            e.preventDefault();
            var button = $('#refresh_button');
            toggleAble(button, true, 'Refreshing...');

            var url = "{{ route('result.add.exam') }}";
            var data = $('#refreshResult').serializeArray();

            Swal.fire({
                title: 'Confirm Refreshing',
                text: 'Are you sure you want to refresh the scores?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Refresh'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    
                    $.ajax({
                        url: '{{ route('result.refresh') }}',
                        type: 'POST',
                        data,
                    }).done((response) => {
                        toggleAble(button, false);
                        Swal.fire('Updated!', response.message, 'success');
                        resetForm('#refreshResult');
                        $('.refreshResultModal').modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $('#generateResult').on('submit', function(e){
            e.preventDefault();
            var button = $('#generate_button');
            toggleAble(button, true, 'Refreshing...');

            var url = "{{ route('result.generate.midterm') }}";
            var data = $('#generateResult').serializeArray();

            Swal.fire({
                title: 'Confirm Refreshing',
                text: 'Are you sure you want to generate the scores?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#502179',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Generate'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    
                    $.ajax({
                        url,
                        type: 'POST',
                        data,
                    }).done((response) => {
                        toggleAble(button, false);
                        Swal.fire('Updated!', response.message, 'success');
                        resetForm('#refreshResult');
                        $('.generateResultModal').modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error);
                        toastr.error(error.responseJSON.message, 'Failed!');
                    });
                }else{
                    toggleAble(button, false);
                }
            });
        });

        $(document).on('submit', '#excelResultUpload', function (e) {
                e.preventDefault();
                var button = $('#excel_upload_button')
                let formData = new FormData($('#excelResultUpload')[0]);
                toggleAble(button, true, 'Uploading Result...');

                Swal.fire({
                    title: 'Confirm Uploading of Result',
                    text: 'Are you sure you want to upload the file?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#502179',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Upload'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        });

                        $.ajax({
                            method: "POST",
                            url: "{{ route('result.excel.exam.upload') }}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                        }).done((res) => {
                            toggleAble(button, false);
                            resetForm('#excelResultUpload')
                            $('.excelResultModal').modal('toggle');
                            Swal.fire('Uploaded!', res.message, 'success');
                        }).fail((err) => {
                            console.log(err);
                            toggleAble(button, false);
                            toastr.error(err.responseJSON.message, 'Failed!');
                        });
                    }else{
                        toggleAble(button, false);
                    }
                });
            });

            $('#excel_grade_id').change(function(){
                var grade = $(this).val();
                var select = $('.student-select select');
                select.empty();

                $.ajax({
                    url: "{{ route("result.get.students",["grade_id" => ":grade_id"]) }}".replace(':grade_id', grade),
                    method: 'GET',
                    success: function(response) {
                        var students = response;
                        select.empty();
                        $.each(students, function (index, student) {
                            var option = $('<option>');
                            option.attr('value', student.uuid);
                            option.text(student.last_name + ' ' + student.first_name + ' ' + student.other_name);
                            select.append(option);
                        });

                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            });
    </script>
    @endsection

</div>
