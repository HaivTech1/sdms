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
                                                    @admin
                                                        @if (affectives($student, $term_id, $period_id) === false || psychomotors($student, $term_id, $period_id) === false)
                                                            <button type="button" data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasWithBothOptions{{ $student->id() }}"
                                                                aria-controls="offcanvasWithBothOptions">
                                                                <i class="fas fa-compress-arrows-alt"></i>
                                                            </button>
                                                        @endif
                                                    @endadmin
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
                                                                        
                                                                        <form id="CreateAffective" action="{{ route('result.affective.upload') }}" method="POST">
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

                                                                        <form id="CreatePsychomotor" action="{{ route('result.psychomotor.upload') }}" method="POST">
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
                
                $('#CreateAffective').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button1', true, 'Submitting...');

                    var data = $('#CreateAffective').serializeArray();
                    var url = "{{ route('result.affective.upload') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data,
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button2', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button2', false);
                            toastr.error(res.message, 'Success!');
                        }
                       
                        resetForm('#CreateAffective')
                        window.location.reload()
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
                    });
                })
                
                $('#CreatePsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button1', true, 'Submitting...');

                    var data = $('#CreatePsychomotor').serializeArray();
                    var url = "{{ route('result.psychomotor.upload') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button1', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button1', false);
                            toastr.error(res.message, 'Failed!');
                        }
                       
                        resetForm('#CreatePsychomotor');
                        window.location.reload();
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button1', false);
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
