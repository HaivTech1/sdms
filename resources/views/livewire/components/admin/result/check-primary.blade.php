<div>
    <x-loading />

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                             @admin
                                <div class="col-lg-3 mt-2">
                                    <select class="form-control select2" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else 
                                <div class="col-lg-3 mt-2">
                                    <select class="form-control select2" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        @foreach (auth()->user()->gradeClassTeacher as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endadmin

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="period_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="term_id" />
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex justify-content-center align-self-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 py-4">
                            @if ($grade_id)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Name of Student</th>
                                                {{-- <th scope="col" class="text-center">
                                                    Class
                                                </th> --}}
                                                <th scope="col" class="text-center">
                                                    Total Subjects
                                                </th>
                                                <th scope="col" class="text-center">
                                                    Recorded Subjects
                                                </th>

                                                <th scope="col" class="text-center" id="action">
                                                    Action
                                                </th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($students as $student)
                                            <tr>
                                                <td class='text-center'>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                                {{-- <td class='text-center'>{{ $student->grade->title() }}</td> --}}
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->totalSubjects() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->subjects as $subject)
                                                                <p class="dropdown-item">{{ $subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class='text-center'>
                                                    <div class="btn-group dropend">
                                                        <button type="button" class="btn dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                            {{ $student->primaryResults->where('term_id', $term_id)->where('period_id', $period_id)->count() }} <i class="mdi mdi-chevron-right"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($student->primaryResults as $result)
                                                                <p class="dropdown-item">{{ $result->subject->title() }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class='d-flex justify-content-center align-items-center gap-2'>
                                                    @if (affectives($student, $term_id, $period_id) === true && psychomotors($student, $term_id, $period_id) === true)
                                                        <a class="btn btn-sm btn-success" href="{{ route('result.primary.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                            type="button"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Click to view result">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    {{-- @admin --}}
                                                        @if (affectives($student, $term_id, $period_id) === false || psychomotors($student, $term_id, $period_id) === false || cognitives($student, $term_id, $period_id) === false )
                                                            <button type="button" data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasWithBothOptions{{ $student->id() }}"
                                                                aria-controls="offcanvasWithBothOptions">
                                                                <i class="fas fa-compress-arrows-alt"></i>
                                                            </button>
                                                        @endif
                                                    {{-- @endadmin --}}
                                                    @admin
                                                        @admin
                                                        @if (publishExamState($student->id(), $period_id, $term_id))
                                                            <button type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                <span class="badge bg-success">Published</span>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-primary" type="button" id='cummulative{{ $student->id() }}' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                Activate
                                                            </button>
                                                        @endif
                                                        @endadmin
                                                        {{-- @if (affectives($student, $term_id, $period_id) === true && psychomotors($student, $term_id, $period_id) === true && cummulatives($student, $term_id, $period_id, $grade_id) == false)
                                                            <button type="button" class="btn btn-sm btn-primary" id='cummulative' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                Cummulate
                                                            </button>
                                                        @endif --}}
                                                    @endadmin
                                                    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions{{ $student->id() }}"
                                                                aria-labelledby="offcanvasWithBothOptionsLabel" wire:ignore.self>
                                                        <div class="offcanvas-header">
                                                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>

                                                        <div class="offcanvas-body">
                                                            <div class="row">
                                                                @if (affectives($student, $term_id, $period_id) == false)
                                                                    <p class="mb-2 text-center">Please rate on a scale of 1 - 5</p>
                                                                    <div class="col-sm-6" id="affecting">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Affective</h1> 
                                                                        
                                                                        <form id="createAffective" action="{{ route('result.affective.upload') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="student_uuid" value="{{ $student->id() }}" />
                                                                            <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                            <input type="hidden" name="term_id" value="{{ $term_id }}" />
                                                                                    
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Attentiveness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Attentiveness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Neatness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Neatness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Initiative" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Initiative</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Organization" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Organization</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Perseverance" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Perseverance</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Politeness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Politeness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Self Control" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Self Control</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Co-operation" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Co-operation</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Reliability" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Reliability</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button1" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                @if (psychomotors($student, $term_id, $period_id) == false)
                                                                    <div class="col-sm-6" id="psychomoting">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Psychomotor</h1>

                                                                        <form id="createPsychomotor" action="{{ route('result.psychomotor.upload') }}" method="POST">
                                                                            @csrf

                                                                            <input type="hidden" name="student_uuid" value="{{ $student->id() }}" />
                                                                            <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                            <input type="hidden" name="term_id" value="{{ $term_id }}" />
                                                                            
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Handwriting" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Handwriting</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Creativity" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Creativity</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Games/Sport" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Games/Sport</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Verbal Fluency" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Verbal Fluency</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                    <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Handling of tools" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Handling</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button2" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                @if (cognitives($student, $term_id, $period_id) == false)
                                                                    <div class="col-xl-12 mt-4">
                                                                        <h4 class="text-primary">Comment and Attendance</h4>
                                                                        <p class="text-muted font-size-14 mb-4">Add comment to result and attendance</p>

                                                                        <form id="createComment" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="student_uuid" value="{{ $student->id() }}" />
                                                                            <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                            <input type="hidden" name="term_id" value="{{ $term_id }}" />
                                                                                    
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
                                                                                            <textarea class="form-control" name="comment">{{ old('comment') }}</textarea>
                                                                                    <x-form.error for="comment" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button id="submit_comment" type="submit" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>                                
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $students->links('pagination::custom-pagination')}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                var student_uuid = $("input[name=student_uuid]").val();
                var period_id = $("input[name=period_id]").val();
                var term_id = $("input[name=term_id]").val();
                
                $('#createAffective').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button1', true, 'Submitting...');

                    var data = $('#createAffective').serializeArray();
                    var url = "{{ route('result.affective.upload') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data,
                    }).done((res) => {
                        toggleAble('#submit_button1', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createAffective')
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button1', false);
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
                            $('#comment').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_comment', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    });
                });

                $('#createPsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button2', true, 'Submitting...');

                    var data = $('#createPsychomotor').serializeArray();
                    var url = "{{ route('result.psychomotor.upload') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        toggleAble('#submit_button2', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createPsychomotor');
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
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
                        if(res.status === true) {
                            toggleAble('#cummulative'+ student_id, false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative'+ student_id, false);
                            toastr.error(res.message, 'Success!');
                        }
                        console.log(res)
                        location.reload()
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative'+ student_id, false);
                });
            }
        </script>
    @endsection

</div>
