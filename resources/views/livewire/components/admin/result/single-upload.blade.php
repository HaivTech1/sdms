<div>
    <x-loading />

    <div class="row">
        <div class="col-sm-12">
            <div class="card-body">            
                <form wire:submit.prevent='selectStudent'>
                    <div class="row">
                        @admin
                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else 
                            <div class="col-lg-2 mt-2">
                                <select class="form-control select2" wire:model="grade_id">
                                    <option value=''>Class</option>
                                    @foreach (auth()->user()->gradeClassTeacher as $grade)
                                    <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endadmin

                        <div class="col-lg-3 mt-2">
                            <select class="form-control select2" wire:model.defer="student_id">
                                <option value=''>Select Student</option>
                                @foreach ($students as $student)
                                <option value="{{  $student->id() }}">{{ $student->firstName() }} {{
                                    $student->lastName() }}
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
                    <div class='col-xs-12 col-sm-12 col-md-12 text-center mb-4'>
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
                    </div>
                    @if ($selectedTerm)
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
                                    <table class="table align-middle table-nowrap table-check">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>CA1</th>
                                                <th>CA2</th>
                                                <th>CA3</th>
                                                <th>Project</th>
                                                <th>Examination</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>20</th>
                                                <th>20</th>
                                                <th>10</th>
                                                <th>10</th>
                                                <th>40</th>
                                            </tr>
                                        </thead>
                                        <tbody wire:ignore>
                                            @foreach ($results as $result)
                                            <tr>
                                                <td>
                                                    {{ $result->subject->title() }}
                                                </td>
                                                <td>
                                                    <livewire:components.edit-title :model='$result' field='ca1' :key='$result->id()' />
                                                </td>
                                                <td>
                                                    <livewire:components.edit-title :model='$result' field='ca2' :key='$result->id()' />
                                                </td>
                                                <td>
                                                    <livewire:components.edit-title :model='$result' field='ca3' :key='$result->id()' />
                                                </td>
                                                <td>
                                                    <livewire:components.edit-title :model='$result' field='pr' :key='$result->id()' />
                                                </td>
                                                <td>
                                                    <livewire:components.edit-title :model='$result' field='exam' :key='$result->id()' />
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <form id="uploadPrimary" action="{{ route('result.storeSinglePrimaryUpload') }}" method="POST">
                                @csrf

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
                                        <table class="table align-middle table-nowrap table-check">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th>CA1</th>
                                                    <th>CA2</th>
                                                    <th>CA3</th>
                                                    <th>Project</th>
                                                    <th>Examination</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>20</th>
                                                    <th>20</th>
                                                    <th>10</th>
                                                    <th>10</th>
                                                    <th>40</th>
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
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca1[]' step="0.01" value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca2[]' step="0.01" value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='ca3[]' step="0.01" value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='pr[]' step="0.01" value="" autofocus />
                                                    </td>
                                                    <td>
                                                        <x-form.input style='width: 50px' class="text-center" type='number'
                                                            name='exam[]' step="0.01" value="" autofocus />
                                                    </td>
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
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.affectiveModal')
    @include('partials.psychomotorModal')
</div>

@section('scripts')
        <script>
            $(document).on('submit', '#uploadPrimary', function (e) {
                e.preventDefault();
                toggleAble('#uploadResult', true, 'Submitting...')
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
                    toggleAble('#submit_button1', true, 'Submitting...');

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
                            console.log(data)

                            $('#student').val(data.student_uuid);
                            $('#period').val(data.period_id);
                            $('#term').val(data.term_id);

                            toggleAble('#submit_button2', false);
                            toastr.success(res.message, 'Success!');
                            $('#affective').modal('toggle');
                            resetForm('#createAffective');
                            $('#psychomotor').modal('toggle');
                        }
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
                    });
                })
                
                $('#createPsychomotor').submit((e) => {
                    e.preventDefault();
                    toggleAble('#submit_button2', true, 'Submitting...');

                    var data = $('#createPsychomotor').serializeArray();
                    var url = '/result/psychomotor/upload';
                    var type = $(this).attr('method')

                    $.ajax({
                        type: 'POST',
                        url,
                        data
                    }).done((res) => {
                        if(res.status === true) {
                            toggleAble('#submit_button2', false);
                            toastr.success(res.message, 'Success!');
                            resetForm('#createPsychomotor');
                            $('#psychomotor').modal('toggle');
                        }
                    }).fail((res) => {
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button2', false);
                    });
                });
            });
        </script>
    @endsection

