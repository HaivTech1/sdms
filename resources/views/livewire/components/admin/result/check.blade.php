<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.grade_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control " wire:model.defer="state.period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.period_id" />
                            </div>

                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="state.term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                </select>
                                <x-form.error for="state.term_id" />
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($period_id && $term_id && $grade_id)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    @admin
                                                    <th scope="col" class="text-center">Name of Student</th>
                                                    @endadmin
                                                    <th scope="col" class="text-center">
                                                        Class
                                                    </th>
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
                                                    @admin
                                                    <td class='text-left'>{{ $student->firstName() }} {{ $student->lastName() }}</td>
                                                    @endadmin
                                                    <td class='text-center'>{{ $student->grade->title() }}</td>
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
                                                                {{ $student->results->where('term_id', $term_id)->where('period_id', $period_id)->count() }} <i class="mdi mdi-chevron-right"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @foreach ($student->results as $result)
                                                                    <p class="dropdown-item">{{ $result->subject->title() }}</p>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                   
                                                    <td class='d-flex justify-content-center align-items-center gap-2'>
                                                        <a href="{{ route('result.show', $student) }}?grade_id={{$grade_id}}&period_id={{$period_id}}&term_id={{$term_id}}"
                                                            type="button"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Click to view result">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @admin
                                                            @if (!$cognitives->count() > 0 || !$psychomotors->count() > 0)
                                                                <button type="button" data-bs-toggle="offcanvas"
                                                                    data-bs-target="#offcanvasWithBothOptions{{ $student->id() }}"
                                                                    aria-controls="offcanvasWithBothOptions">
                                                                    <i class="fas fa-compress-arrows-alt"></i>
                                                                </button>
                                                            @endif
                                                        @endadmin
                                                        @admin
                                                            <button type="button" id='cummulative' onClick="publish('{{ $student->id() }}, {{ $period_id }}, {{ $term_id }}, {{ $grade_id }}')">
                                                                <i class="mdi mdi-upload d-block font-size-16"></i> Publish
                                                            </button>
                                                        @endadmin
                                                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions{{ $student->id() }}"
                                                                    aria-labelledby="offcanvasWithBothOptionsLabel">
                                                            <div class="offcanvas-header">
                                                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                            </div>

                                                            <div class="offcanvas-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6" id="psychings">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Psychomotor</h1>(<span class="text-danger font-size-5 text-center"> 1 - 5 </span>) 
                                                                        <form id="CreatePsychomotor">
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
                                                                                    <input type="hidden" name="title[]" value="Politeness" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Politeness</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Honesty" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Honesty</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Punctuality" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Punctuality</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button1" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>

                                                                    <div class="col-sm-6" id="cogniting">
                                                                        <h1 class="font-size-5 text-center mb-1">Student's Cognitive</h1>(<span class="text-danger font-size-5 text-center"> 1 - 5 </span>)

                                                                        <form id="CreateCognitive">
                                                                            @csrf

                                                                            <input type="hidden" name="student_uuid" value="{{ $student->id() }}" />
                                                                            <input type="hidden" name="period_id" value="{{ $period_id }}" />
                                                                            <input type="hidden" name="term_id" value="{{ $term_id }}" />
                                                                            
                                                                            <div class="row mt-2">
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Listening" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Listening</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Handwriting" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Handwriting</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Spoken English" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Spoken English</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Reading skills" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Reading</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Homework" />
                                                                                        <div class="input-group">
                                                                                        <div class="input-group-text">Homework</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Outdoor games" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Outdoor games</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="title[]" value="Vocational skills" />
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-text">Vocational</div>
                                                                                        <input style='width: 50px' type="number" class="form-control" maxlength="1" name="rate[]" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button id="submit_button2" class="btn btn-primary mt-2" type="submit" value="Button">Submit</button>
                                                                        </form>
                                                                    </div>
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
                        </div> <!-- end col -->
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

                $.ajax({
                    type: "GET",
                    url: "psychomotor/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    psy = data
                    if(data.length > 0){
                        $("#psychings").css("display", "none");
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "cognitive/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    if(data.length > 0){
                        $("#cogniting").css("display", "none");
                    }
                })

                 $.ajax({
                    type: "GET",
                    url: "cummulative/get",
                    data: {student_uuid, period_id, term_id }
                }).done((res) => {
                    var data = res.data
                    if(data.length > 0){
                        $("#cummulative").css("display", "none");
                    }
                })
                
                
                $('#CreatePsychomotor').submit((e) => {
                    toggleAble('#submit_button1', true, 'Submitting...');
                    e.preventDefault()
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
                       
                        console.log(res)
                        resetForm('#CreatePsychomotor');
                        location.reload()
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button1', false);
                    });
                })

                $('#CreateCognitive').submit((e) => {
                    toggleAble('#submit_button2', true, 'Submitting...');
                    e.preventDefault()
                    var data = $('#CreateCognitive').serializeArray();
                    var url = "{{ route('result.cognitive.upload') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button2', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button2', false);
                            toastr.error(res.message, 'Success!');
                        }
                       
                        console.log(res)
                        resetForm('#CreateCognitive')
                        location.reload()
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
                    });
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

                $.ajax({
                    url: 'publish/cummulative' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#cummulative', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#cummulative', false);
                            toastr.error(res.message, 'Success!');
                        }
                        console.log(res)
                        location.reload()
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative', false);
                });
            }
        </script>
    @endsection

</div>
