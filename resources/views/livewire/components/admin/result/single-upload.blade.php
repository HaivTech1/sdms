<div>
    <x-loading />

    @examUploadEnabled
        <div class="row">
            <div class="col-sm-12">
                <div class="card-body">            
                    <form wire:submit.prevent='selectStudent'>
                        <div class="row">
                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mt-2">
                                <select class="form-control select2" wire:model="student_id">
                                    <option value=''>Select Student</option>
                                    @foreach ($students as $student)
                                    <option value="{{  $student->id() }}">
                                        {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                    </option>
                                    @endforeach
                                    <x-form.error for="student_id" />
                                </select>
                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                    @endforeach
                                    <x-form.error for="period_id" />
                                </select>

                            </div>

                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                    @endforeach
                                    <x-form.error for="term_id" />
                                </select>

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

                    <div class='row mt-4'>
                        {{-- <div class='col-xs-12 col-sm-12 col-md-12 text-center mb-4'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <span>Session:
                                                @if ($selectedPeriod)
                                                {{ $selectedPeriod->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Term:
                                                @if ($selectedTerm)
                                                {{ $selectedTerm->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Class:
                                                @if ($selectedGrade)
                                                {{ $selectedGrade->title() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-sm-3">
                                            <span>Student:
                                                @if ($selectedStudent)
                                                {{ $selectedStudent->firstName() }} {{ $selectedStudent->lastName() }}
                                                @else
                                                Nil
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        @if ($selectedTerm)
                            @php
                                $exam_format = get_settings('exam_format');
                            @endphp

                            @if ($exam_format !== null)
                                @if (count($results) > 0)
                                    <div class='col-sm-12'>
                                
                                        <x-form.input style='width: 50px' class="text-center" type='hidden' name='period_id'
                                            value="{{ $selectedPeriod->id() }}" autofocus />
                                        <x-form.input style='width: 50px' class="text-center" type='hidden' name='term_id'
                                            value="{{ $selectedTerm->id() }}" autofocus />
                                        <x-form.input style='width: 50px' class="text-center" type='hidden' name='grade_id'
                                            value="{{ $grade_id }}" autofocus />
                                        <x-form.input style='width: 50px' class="text-center" type='hidden' name='student_id'
                                            value="{{  $selectedStudent->id() }}" autofocus />

                                        <div class='table-responsive'>
                                            <table class="table table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Subjects</th>
                                                        @foreach ($exam_format as $key => $value)
                                                            <th>{{ $value['full_name'] }}</th>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        @foreach ($exam_format as $key => $value)
                                                            <th>{{ $value['mark'] }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody wire:ignore>
                                                    @foreach ($results as $result)
                                                    <tr>
                                                        <td>
                                                            {{ $result->subject->title() }}
                                                        </td>
                                                        @foreach ($exam_format as $key => $value)
                                                            <td>
                                                                <livewire:components.edit-title :model='$result' field='{{ $key }}' :key='$result->id()' />
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <form id="uploadPrimary" action="{{ route('result.storeSinglePrimaryUpload') }}" method="POST">
                                        @csrf
                                    
                                            <x-form.input style='width: 50px' class="text-center" type='hidden' name='period_id'
                                                value="{{ $selectedPeriod->id() }}" autofocus />
                                            <x-form.input style='width: 50px' class="text-center" type='hidden' name='term_id'
                                                value="{{ $selectedTerm->id() }}" autofocus />
                                            <x-form.input style='width: 50px' class="text-center" type='hidden' name='grade_id'
                                                value="{{ $grade_id }}" autofocus />
                                            <x-form.input style='width: 50px' class="text-center" type='hidden' name='student_id'
                                                value="{{  $selectedStudent->id() }}" autofocus />

                                            <div class='table-responsive'>
                                                <table class="table align-middle table-nowrap ">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Subjects</th>
                                                            @foreach ($exam_format as $key => $value)
                                                                <th>{{ $value['full_name'] }}</th>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            @foreach ($exam_format as $key => $value)
                                                                <th style="text-align: center; width: 70px">{{ $value['mark'] }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($selectedStudent->subjects as $subject)
                                                        <tr>
                                                            <td>
                                                                {{ $subject->title() }}
                                                                <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                    name='subject_id[]' value="{{ $subject->id() }}" autofocus />
                                                            </td>
                                                             @foreach ($exam_format as $key => $mark)
                                                                <td>
                                                                    <x-form.input style='width: 70px' class="text-center required" type='number' name='{{ $key }}[]' value="" step="0.01"
                                                                        onblur="validateInput(this, {{ $mark['mark'] }})" />
                                                                    <div class="invalid-feedback"></div>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                                <button type="submit" id="uploadResult"
                                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                                    Upload Result
                                                </button>
                                            </div>
                                    </form>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="row justify-content-center mt-5">
                        <div class="col-sm-4">
                            <div class="maintenance-img">
                                <img src="{{ asset('images/coming-soon.svg') }}" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-5">Uploadng disabled</h4>
                    <p class="text-muted">Please contact the administrator to gain access to this.</p>
                </div>
            </div>
        </div>
    @endexamUploadEnabled

    @include('partials.affectiveModal')
    @include('partials.psychomotorModal')
    @include('partials.commentModal')
</div>

@section('scripts')
        <script>
            function validateInput(input, mark) {
                if (input.value > mark) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = 'Value cannot be greater than ' + mark;
                } else {
                    input.nextElementSibling.textContent = '';
                    input.classList.remove('is-invalid');
                }
            }
        </script>

        <script>
            $(document).on('submit', '#uploadPrimary', function (e) {
                e.preventDefault();
                toggleAble('#uploadResult', true, 'Submitting...')

                let inputs = $('#uploadPrimary .required');
                let invalid = false;

                inputs.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').html('This field is required.');
                        invalid = true;
                    }
                });

                if (invalid) {
                    toggleAble('#uploadResult', false);
                    toastr.error('Please fill in all required fields.', 'Validation Error!');
                    return;
                }
                
                var data = $(this).serializeArray();
                var url = $(this).attr('action');
                var type = $(this).attr('method')

                $.ajax({
                    type,
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        const { data } = res;

                        $('#student_uuid').val(data.student_uuid);
                        $('#period_id').val(data.period_id);
                        $('#term_id').val(data.term_id);

                        toggleAble('#uploadResult', false)
                        toastr.success(res.message, 'Success!');
                        resetForm('#uploadPrimary');
                        $('#affective').modal('toggle');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#uploadResult', false)
                });
                
            });



            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                var student_uuid = $("input[name=student_uuid]").val();
                var period_id = $("input[name=period_id]").val();
                var term_id = $("input[name=term_id]").val();
                
                $('#createAffective').submit(function (e){
                    e.preventDefault();
                    toggleAble('#submit_affective', true, 'Submitting...');

                    var data = $(this).serializeArray();
                    var url = $(this).attr('action');
                    var type = $(this).attr('method')

                    $.ajax({
                        type,
                        url,
                        data,
                    }).done((res) => {
                        if(res.status === true) {
                            const { data } = res;

                            $('#student').val(data.student_uuid);
                            $('#period').val(data.period_id);
                            $('#term').val(data.term_id);

                            toggleAble('#submit_affective', false);
                            toastr.success(res.message, 'Success!');
                            $('#affective').modal('toggle');
                            resetForm('#createAffective');
                            $('#psychomotor').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_affective', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    });
                })
                
                $('#createPsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_psychomotor', true, 'Submitting...');

                    var data = $('#createPsychomotor').serializeArray();
                    var url = '/result/psychomotor/upload';
                    var type = $(this).attr('method')

                    $.ajax({
                        type: 'POST',
                        url,
                        data
                    }).done((res) => {
                        if(res.status === true) {
                             const { data } = res;

                            $('#comment_student').val(data.student_uuid);
                            $('#comment_period').val(data.period_id);
                            $('#comment_term').val(data.term_id);

                            toggleAble('#submit_psychomotor', false);
                            toastr.success(res.message, 'Success!');
                            $('#psychomotor').modal('toggle');
                            resetForm('#createPsychomotor');
                            $('#comment').modal('toggle');
                        }
                    }).fail((res) => {
                        toggleAble('#submit_psychomotor', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
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
            });
        </script>
        <script>
            $('#psychomotorBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#student').val(studentId);
                $('#period').val(periodId);
                $('#term').val(termId);
                $('#affective').modal('toggle');
                $('#psychomotor').modal('toggle');
            });

            $('#affectiveBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#student').val(studentId);
                $('#period').val(periodId);
                $('#term').val(termId);
                
                $('#psychomotor').modal('toggle');
                $('#affective').modal('toggle');
            });

            $('#commentBtn').on('click', function(){
                const currentUrl = window.location.href;
                const searchParams = new URLSearchParams(currentUrl.split('?')[1]);
                const periodId = searchParams.get('period_id');
                const termId = searchParams.get('term_id');
                const studentId = searchParams.get('student_id');

                $('#comment_student').val(studentId);
                $('#comment_period').val(periodId);
                $('#comment_term').val(termId);

                $('#psychomotor').modal('toggle');
                $('#comment').modal('toggle');
            });
        </script>
    @endsection

