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

                    <div class='row' id="main">
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
                                        <tr id="sid{{ $student->id() }}">
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
                                            <td wire:ignore.self>
                                                <a href="javascript:void(0)" class="cursor-pointer" onclick="editReg({{ $student->user->id() }})">{{ $student->user->reg_no }}</a>
                                                {{-- <livewire:components.edit-title :model='$student->user' field='reg_no' :key='$student->user->id()'/> --}}

                                                <div id="editReg" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Update Students Registration Number</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form id="editStudentReg">
                                                                <div class="modal-body">
                                                                    <div class="col-sm-12 mb-3">
                                                                        <input id="id" class="form-control d-none" type="text" name="id" />
                                                                    </div>

                                                                    <div class="col-sm-12 mb-3">
                                                                        <x-form.label for="reg_no" value="{{ __('Reg. Number') }}" />
                                                                        <input id="reg_no" class="form-control" type="text" name="reg_no" />
                                                                        <x-form.error for="reg_no" />
                                                                    </div>

                                                                    <div class="col-sm-12 mb-3">
                                                                        <x-form.label for="house_id" value="{{ __('House') }}" />
                                                                        <select class="form-control" name="house_id">
                                                                            <option>Select</option>
                                                                            @foreach ($houses as $house)
                                                                            <option value="{{ $house->id() }}" {{ ($student->house_id == $house->id()) ? 'selected' : '' }}>{{ $house->title() }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <x-form.error for="house_id" />
                                                                    </div>

                                                                    <div class="col-sm-12 mb-3">
                                                                        <x-form.label for="club_id" value="{{ __('Club') }}" />
                                                                        <select class="form-control" name="club_id">
                                                                            <option>Select</option>
                                                                            @foreach ($clubs as $club)
                                                                            <option value="{{ $club->id() }}" {{ ($student->club_id == $club->id()) ? 'selected' : '' }}>{{ $club->title() }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <x-form.error for="club_id" />
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" id="edit_button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $student->subjects->count() }}
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <button type="button" id="assingSubject" value="{{ $student->id() }}" data-subjects="{{ json_encode($student->subjects)}}">
                                                            <i class="fas fa-compress-arrows-alt"></i>
                                                        </button>

                                                        <!-- <div class="offcanvas offcanvas-start" data-bs-scroll="true"
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
                                                        </div> -->
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

    <div class="modal fade addSubject bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="createSubjects">
                                <x-form.input type="hidden" value="" name="student_id" id="edit_student_id" />
    
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Assign</th>
                                                    <th>Subject Title</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subjects as $subject)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="subjects[]" class="subject-checkbox"
                                                                value="{{ $subject->id() }}" />
                                                        </td>
                                                        <td>{{ $subject->title() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                            class="fa fa-close"></i> Close</button>
                                    <button type="button" id="submit_Sub" class="btn btn-primary btn-flat"><i
                                            class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            function editReg(id){
                $.get('/teacher/student/edit/'+ id, function(response){
                    const {student, user} = response
                    $('#id').val(student.id);
                    $('#reg_no').val(student.reg_no);
                    $('#house_id').val(user.house_id);
                    $('#club_id').val(user.club_id);
                    $('#editReg').modal('toggle');
                });
            }

             $(document).on('submit', '#editStudentReg', function(e){
                e.preventDefault();
                toggleAble('#edit_button', true, 'Submitting...');
                var data = $('#editStudentReg').serializeArray();
                var url = "{{ route('teacher.student.update') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status) {
                        toggleAble('#edit_button', false);
                        toastr.success(res.message, 'Success!');
                        $('#editReg').modal('hide');
                        setInterval(function () {window.location.reload()}, 1000);
                    }else{
                        toggleAble('#edit_button', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#edit_button', false);
                });
             });

            $(document).on('click', '#assingSubject', function(e) {
                e.preventDefault();
                var id = $(this).val();

                var studentSubjects = $(this).data('subjects'); 

                $('#edit_student_id').val(id);

                $('.subject-checkbox').prop('checked', false);

                if (studentSubjects && Array.isArray(studentSubjects)) {
                    studentSubjects.forEach(function (subject) {
                        $('input.subject-checkbox[value="' + subject.id + '"]').prop('checked', true);
                    });
                }

                $('.addSubject').modal('show');
            });

            $(document).on('click', '#submit_Sub', function(e){
                toggleAble($(this), true, 'Submitting...');
                
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
                        setTimeout(function () {window.location.reload()}, 2000);
                    }else{
                        toggleAble('#submit_button', false);
                        toastr.error(res.responseJSON.message, 'Failed!');
                    }
                }).fail((res) => {
                    toggleAble('#submit_button', false);
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
                
            });
        </script>
    @endsection
</div>