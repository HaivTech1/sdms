<div>
    <x-loading />

    @midUploadEnabled
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="fetchData">
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="subject_id">
                                        <option value=''>Subject</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="col-lg-6">
                                    <select class="form-control " wire:model.defer="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="col-lg-6">
                                    <select class="form-control" wire:model.defer="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                        @endforeach
                                    </select>
        
                                </div>

                                <div class="col-lg-6 mt-2">
                                    <div class="float-end">
                                        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                            <i class="bx bx-search-alt" style="background-color: white; color: red; border-radius: 50%; padding: 3px"></i> Students
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @php
                            $midterm = get_settings('midterm_format');
                        @endphp

                        <div class="mt-4">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-bullseye-arrow me-2"></i>
                                Select test type only after selecting the session, term, class and subject!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <select id="format-select" class="form-control">
                                <option value="">Select test type</option>
                                @foreach ($midterm as $key => $value)
                                    <option value="{{ $key }}">{{ $value['full_name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($selectedGrade)
                            <div class='row mt-4'>
                                <div class='col-sm-12'>
                                    <form id="midFormSubmit" method="POST">
                                        @csrf
                                        <div class='table-responsive'>
                                            
                                            <table class="table align-middle table-nowrap table-check">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th></th>
                                                        {{-- @foreach ($midterm as $key => $value)
                                                            <th>{{ $value['full_name'] }}</th>
                                                        @endforeach --}}
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

                                                        {{-- @foreach ($students as $index => $student)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                        name='student_id[]' value="{{  $student->id() }}" autofocus />
                                                                    {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                                                </td>
                                                                @foreach ($midterm as $key => $mark)
                                                                    <td>
                                                                        <x-form.input style='width: 70px' class="text-center required" type='number'
                                                                            name='{{ $key }}[]' value="" step="0.01" onblur="validateInput(this, {{ $mark['mark'] }})" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach --}}
                                                        @foreach ($students as $index => $student)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                        name='student_id[]' value="{{  $student->id() }}" autofocus />
                                                                    {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                                                </td>
                                                                {{-- @foreach ($midterm as $key => $mark) --}}
                                                                    <td>
                                                                        <x-form.input style='width: 70px' class="text-center required midterm-input" type='number'
                                                                            name='' value="" step="0.01" onblur="validateInput(this)" disabled/>
                                                                        <div class="invalid-feedback"></div>
                                                                    </td>
                                                                {{-- @endforeach --}}
                                                            </tr>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            <button id="submit_button" type="submit"
                                                class="btn btn-primary block waves-effect waves-light pull-right">
                                                Upload Result
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    @endmidUploadEnabled

    @section('scripts')
        <script>

            $(document).ready(function(){
                $('.midterm-input').prop('disabled', true);

                $('#format-select').on('change', function() {
                    var selectedFormat = $(this).val();
                    $('.midterm-input').prop('disabled', true); // Disable all inputs
                    
                    if (selectedFormat !== '') {
                        $('.midterm-input').prop('disabled', false); // Enable inputs
                        $('.midterm-input').attr('name', selectedFormat + '[]');
                        } else {
                        $('.midterm-input').attr('name', ''); // Clear name attribute
                    }
                });
            });

            function validateInput(input) {
                var selectedFormat = $('#format-select').val();
                var marks = JSON.parse('{!! json_encode($midterm) !!}');
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

            $(document).on('submit', '#midFormSubmit', function (e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Submitting...');
                var selectedFormat = $('#format-select').val();

                if (selectedFormat === '') {
                    toastr.info('Please select the score type', 'Note!');
                    toggleAble('#submit_button', false);
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
                        toggleAble('#submit_button', false);
                        toastr.error('Please fill in all required fields.', 'Validation Error!');
                        return;
                    }

                    var url = "{{ route('result.upload.batch.midterm.score') }}";
                    var data = $('#midFormSubmit').serializeArray();
                    data.push({ name: 'format', value: selectedFormat });

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        toggleAble('#submit_button', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#midFormSubmit');
                    }).fail((err) => {
                        toggleAble('#submit_button', false);
                        let allErrors = Object.values(err.responseJSON).map(el => (
                        el = `<li>${el}</li>`
                        )).reduce((next, prev) => (next = prev + next));

                        const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>`;

                        $('.modalErrorr').html(setErrors);
                        console.log(err.responseJSON.message);
                    });
                }
            });
        </script>
    @endsection
</div>