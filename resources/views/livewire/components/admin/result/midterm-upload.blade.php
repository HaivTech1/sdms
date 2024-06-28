<div>
    <x-loading />

    @midUploadEnabled
        <div class="row">
            <div class="col-12">
                <div class="card-body">            
                        <div class="card-header">
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
                                        @if (isset($students))
                                            <select class="form-control select2" wire:model="student_id">
                                                <option value=''>Select Student</option>
                                                @foreach ($students as $student)
                                                <option value="{{  $student->id() }}">
                                                    {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                                </option>
                                                @endforeach
                                                <x-form.error for="student_id" />
                                            </select>
                                        @endif
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

                                    <div class="col-lg-3 mt-2">
                                        <div class="d-flex justify-content-center align-self-center">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                                <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i>
                                                Student
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if ($selectedTerm)
                            <div class="card mt-4">
                                    <div class='row mt-4'>
                                        @php
                                            $midterm = get_settings('midterm_format');
                                        @endphp

                                        {{-- @if (count($results) > 0)
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
                                                            <tr class="">
                                                                <th>Subject</th>
                                                                @foreach ($midterm as $key => $value)
                                                                    <th>{{ $value['full_name'] }}</th>
                                                                @endforeach
                                                                <th>Created</th>
                                                                <th></th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                @foreach ($midterm as $key => $value)
                                                                    <th>{{ $value['mark'] }}</th>
                                                                @endforeach
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody wire:ignore>
                                                            @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                                                @foreach ($results as $result)
                                                                    <tr id='{{ $result->id() }}'>
                                                                        <td>
                                                                            {{ $result->subject?->title() }}
                                                                        </td>
                                                                        @foreach ($midterm as $key => $value)
                                                                            <td>
                                                                                <livewire:components.edit-title :model='$result' field='{{ $key }}' :key='$result->id()' />
                                                                            </td>
                                                                        @endforeach
                                                                        <td>{{ $result->createdAt() }}</td>
                                                                        <td>
                                                                            <button wire:ignore.self type="button" class="btn btn-danger delete-score" data-session="{{ $result->period?->id() }}" data-term="{{ $result->term?->id() }}" data-student="{{ $selectedStudent?->id() }}" data-subject="{{ $result->subject?->id() }}">
                                                                                <i class="bx bx-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                @foreach ($results->where('author_id', auth()->id()) as $result)
                                                                    <tr id='{{ $result->id() }}'>
                                                                        <td>
                                                                            {{ $result->subject?->title() }}
                                                                        </td>
                                                                        @foreach ($midterm as $key => $value)
                                                                            <td>
                                                                                <livewire:components.edit-title :model='$result' field='{{ $key }}' :key='$result->id()' />
                                                                            </td>
                                                                        @endforeach
                                                                        <td>{{ $result->createdAt() }}</td>
                                                                        <td>
                                                                            <button wire:ignore.self type="button" class="btn btn-danger delete-score" data-session="{{ $result->period?->id() }}" data-term="{{ $result->term?->id() }}" data-student="{{ $selectedStudent?->id() }}" data-subject="{{ $result->subject?->id() }}">
                                                                                <i class="bx bx-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else --}}
                                            <form id="midFormSubmit" method="POST">
                                                @csrf

                                                <div class="modalErrorr"></div>

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
                                                                <tr class="">
                                                                    <th></th>
                                                                    @foreach ($midterm as $key => $value)
                                                                        <th>{{ $value['full_name'] }}</th>
                                                                    @endforeach
                                                                    <th>Total</th>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    @foreach ($midterm as $key => $value)
                                                                        <th>{{ $value['mark'] }}</th>
                                                                    @endforeach
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($selectedStudent->subjects as $subject)
                                                                <tr>
                                                                    <td>
                                                                        {{ $subject->title() }}
                                                                        <x-form.input style='width: 50px' class="text-center" type='hidden'
                                                                            name='subject_id[]' value="{{ $subject->id() }}" />
                                                                    </td>
                                                                    <?php $total = 0; ?>
                                                                    @foreach ($midterm as $key => $mark)
                                                                        <td>
                                                                            <x-form.input style='width: 70px' class="text-center required" type='number' name='{{ $key }}[]' value="" step="0.01"
                                                                                onblur="validateInput(this, {{ $mark['mark'] }})" />
                                                                            <div class="invalid-feedback"></div>
                                                                            <?php $total += $mark['mark']; ?>
                                                                        </td>
                                                                    @endforeach
                                                                    <td>{{ $total }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                                        <button id="submit_button" type="submit"
                                                            class="btn btn-primary block waves-effect waves-light pull-right">
                                                            Upload Result
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        {{-- @endif --}}
                                    </div>
                            </div>
                        @endif
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
            {{-- document.querySelectorAll('.delete-score').forEach(button => {
                button.addEventListener('click', () => {
                    var button  = $(this);
                    toggleAble(button, true);
                    const sessionId = button.getAttribute('data-session');
                    const termId = button.getAttribute('data-term');
                    const studentId = button.getAttribute('data-student');
                    const subjectId = button.getAttribute('data-subject');

                    fetch(`/result/midterm/delete/${sessionId}/${termId}/${studentId}/${subjectId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.status) {
                            toggleAble(button, false);
                            const row = button.closest('tr');
                            row.parentNode.removeChild(row);
                            toastr.success(response.message, 'Success!');
                        } else {
                            toggleAble(button, false);
                            toastr.error('Unable to delete score', 'Failed');
                        }
                    })
                    .catch(error => {
                        toggleAble(button, false);
                        console.error(error);
                        toastr.error('An error occurred while deleting the score', 'Failed');
                    });
                });
            }); --}}

            $('.delete-score').on('click', function(){
                alert();
            })
        </script>

        <script>
            $(document).on('submit', '#midFormSubmit', function (e) {
                e.preventDefault();
                toggleAble('#submit_button', true, 'Submitting...');

                {{-- let inputs = $('#midFormSubmit .required');
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
                } --}}

                var url = "{{ route('result.upload.midterm.score') }}";
                var data = $('#midFormSubmit').serializeArray();

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    toggleAble('#submit_button', false);
                    toastr.success(res.message, 'Success!');
                    resetForm('#midFormSubmit');
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }).fail((err) => {
                    toggleAble('#submit_button', false);
                    let allErrors = Object.values(err.responseJSON).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>${allErrors}</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    `;
                    $('.modalErrorr').html(setErrors);
                });
            });

        </script>
        
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
    @endsection
</div>