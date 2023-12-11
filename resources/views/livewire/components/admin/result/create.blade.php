<div>
    <x-loading />

    @midUploadEnabled
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="fetchData">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select class="form-control select2" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control select2" wire:model.defer="subject_id">
                                        <option value=''>Subject</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="col-lg-2">
                                    <select class="form-control " wire:model.defer="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                        @endforeach
                                    </select>
        
                                </div>
        
                                <div class="col-lg-2">
                                    <select class="form-control select2" wire:model.defer="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                        @endforeach
                                    </select>
        
                                </div>

                                <div class="col-lg-2">
                                    <div class="float-end">
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
                                                <span>Subject:
                                                    @if ($selectedSubject)
                                                    {{ $selectedSubject->title() }}
                                                    @else
                                                    Nil
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            @if ($selectedGrade)
                                <div class='col-sm-12'>
                                    @if (count($results) > 0)
                                        <div class='table-responsive'> 
                                            <table class="table align-middle table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>CA1</th>
                                                        <th>CA2</th>
                                                        <th>CA3</th>
                                                        <th>Examination</th>
                                                        <th>Student Name</th>
                                                        <th>Student Id</th>
                                                        <th>Uploaded by</th>
                                                        <th>Uploaded Date</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($results as $index => $result)
                                                    <tbody wire:ignore>
                                                        <tr id='{{ $result->id() }}'>
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
                                                                <livewire:components.edit-title :model='$result' field='exam' :key='$result->id()' />
                                                            </td>
                                                            <td>
                                                                {{ $result->student->firstName() }} {{ $result->student->lastName() }}
                                                            </td>
                                                            <td>{{ $result->student->user->code() }}</td>
                                                            <td>{{ $result->author()->name() }}</td>
                                                            <td>{{ $result->createdAt() }}</td>
                                                            {{-- <td>
                                                                <a href="{{ route('result.show', $result) }}" class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td> --}}
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                        {{ $results->links('pagination::custom-pagination')}}
                                    @else
                                        <form id="uploadPrimary" action="{{ route('result.store') }}" method="POST">
                                            @csrf
                                            <div class='table-responsive'>
                                                @php
                                                    $exam_format = get_settings('exam_format');
                                                @endphp
                                                <table class="table align-middle table-nowrap table-check">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Student Name</th>
                                                            @foreach ($exam_format as $key => $value)
                                                                <th>{{ $value['full_name'] }}</th>
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                        <tr>
                                                            <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                name='period_id' value="{{ $period_id }}" autofocus />
                                                            <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                name='term_id' value="{{ $term_id }}" autofocus />
                                                            <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                name='grade_id' value="{{ $grade_id }}" autofocus />
                                                            <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                name='subject_id' value="{{ $subject_id }}" autofocus />
                                                            @foreach ($students as $index => $student)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>
                                                                        <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                            name='student_id[]' value="{{  $student->id() }}" autofocus />
                                                                        {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                                                    </td>
                                                                    @foreach ($exam_format as $key => $mark)
                                                                        <td>
                                                                            <x-form.input style='width: 70px' class="text-center required" type='number'
                                                                                name='{{ $key }}[]' value="" step="0.01" onblur="validateInput(this, {{ $mark['mark'] }})" />
                                                                            <div class="invalid-feedback"></div>
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                <button id="uploadResult" type="submit"
                                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                                    @if (count($results) > 0)
                                                    Update
                                                    @else
                                                    Upload
                                                    @endif
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
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
    @endmidUploadEnabled

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
                    toggleAble('#uploadResult', false)
                    toastr.success(res.message, 'Success!');
                    resetForm('#uploadPrimary');
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }).fail((res) => {
                    toggleAble('#uploadResult', false)
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });
        </script>
    @endsection
</div>