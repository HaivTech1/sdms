<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    <x-search />
                                </div>

                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="gender">
                                                <option value=''>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Others</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="grade">
                                                <option value=''>Select Grade</option>
                                                @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->title() }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="sortBy">
                                                <option value=''>Sort By</option>
                                                <option value="asc">ASC</option>
                                                <option value="desc">DESC</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <select class="form-control select2" wire:model="orderBy">
                                                <option value=''>Order By</option>
                                                <option value="first_name">First Name</option>
                                                <option value="last_name">Last Name</option>
                                            </select>
                                        </div>
                                    </div>
                                </diV>
                            </div>
                        </div>
                    </div>

                    <div class='row'>

                        <div class='col-sm-12'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Class </th>
                                            <th class="align-middle"> Reg. No </th>
                                            <th class="align-middle"> Subjects </th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                        <tr>
                                            <td>
                                                <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                    }}</a>
                                            </td>
                                            <td>
                                                {{ $student->firstName() }} {{ $student->lastName() }}
                                            </td>
                                            <td>
                                                {{ $student->grade->title() }}
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$student->user' field='reg_no' :key='$student->user->id()'/>
                                            </td>
                                            <td>
                                                {{ $student->subjects->count() }}
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button" id="assingSubject" value="{{ $student->id() }}">
                                                            <i class="fas fa-compress-arrows-alt"></i>
                                                        </button>

                                                        <div class="offcanvas offcanvas-start" data-bs-scroll="true"
                                                            tabindex="-1"
                                                            id="offcanvasWithBothOptions{{ $student->id() }}"
                                                            aria-labelledby="offcanvasWithBothOptionsLabel">
                                                            <div class="offcanvas-header">
                                                                <button type="button" class="btn-close text-reset"
                                                                    data-bs-dismiss="offcanvas"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="offcanvas-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h4>Assign Subjects for {{  $student->fullName() }}</h4>
                                                                        <form id="assignSubjects">
                                                                            @csrf
                                                                            <x-form.input type="hidden"
                                                                                value="{{ $student->id() }}"
                                                                                name="student_id" />

                                                                            <div class="col-sm-12 mt-2">
                                                                                
                                                                                <select name="subjects[]"
                                                                                    class="form-control select2-multiple"
                                                                                    multiple>
                                                                                    @foreach ($subjects as $subject)
                                                                                    <option
                                                                                        value="{{ $subject->id() }}">
                                                                                        {{ $subject->title() }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <x-form.error for="subjects" />
                                                                            </div>

                                                                            <div class="col-sm-12 mt-2">
                                                                                <div class="float-right">
                                                                                    <button id="submit_button" type="submit"
                                                                                        class="btn btn-primary">Add</button>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>

                                                                    <div class="col-sm-12 mt-4">
                                                                        <h1>List of subjects assigned</h1>

                                                                        <ul>
                                                                            @foreach ($student->subjects as $subject)
                                                                                <li><span class="badge badge-soft-info">{{ $subject->title() }}</span></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    
                                                                    </div>
                                                                </div>
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
                            {{ $students->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.add_subject')

    @section('scripts')
        <script>

            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $(document).on('click', '#assingSubject', function(e) {
                e.preventDefault();
                var id = $(this).val();

                $('#student_id').val(id);
                $('.addSubject').modal('show');
            });

            $(document).on('submit', '#createSubjects', function(e){
                e.preventDefault();
                toggleAble('#submit_button', true, 'Submitting...');
                var data = $('#createSubjects').serializeArray();
                var url = "{{ route('student.assignSubject') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#submit_button', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createSubjects');
                        setInterval(function () {window.location.reload()}, 2000);
                    }else{
                        toggleAble('#submit_button', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#submit_button', false);
                });
                
            });
        </script>
        
    @endsection
</div>