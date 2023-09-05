<div>
    <x-loading />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-search />
                                </div>
                                <div class=" col-sm-6">
                                    <div class="text-sm-end">
                                        <a href="{{ route('student.create') }}"
                                            class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                                class="mdi mdi-plus me-1"></i> Add Student</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="gender">
                                                <option value=''>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Others</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="grade">
                                                <option value=''>Select Grade</option>
                                                @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->title() }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="sortBy">
                                                <option value=''>Sort By</option>
                                                <option value="asc">ASC</option>
                                                <option value="desc">DESC</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="orderBy">
                                                <option value=''>Order By</option>
                                                <option value="first_name">First Name</option>
                                                <option value="last_name">Last Name</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="status">
                                                <option value=''>Status</option>
                                                <option value="1">Active</option>
                                                <option value="false">Inactive</option>
                                            </select>
                                        </div>

                                         <div class="col-lg-2">
                                            <select class="form-control select2" wire:model="gender">
                                                <option value=''>Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </diV>

                                <div class="col-lg-12 mt-2">
                                    <div>
                                        <button data-bs-toggle="modal" data-bs-target=".generateStudentList" class="btn btn-sm btn-primary"><i class="bx bx-cog"></i> Generate Student List </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            @if ($selectedRows)
                                <div class="row mt-2">
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="activateAll" type="button"
                                                class="btn btn-outline-primary w-sm">
                                                <i class="bx bx-trash"></i>
                                                Activate All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="deleteAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-trash"></i>
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="sendAllDetails" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-caret-right"></i>
                                                Send Credentials
                                            </button>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="repeatAll" type="button"
                                                class="btn btn-outline-danger w-sm">
                                                <i class="bx bx-caret-left"></i>
                                                Repeat All
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            @endif
                        </diV>
                    </div>

                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        wire:model="selectPageRows">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle"></th>
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Class </th>
                                            <th class="align-middle"> Reg. No </th>
                                            <th class="align-middle"> Subjects </th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $student->id() }}"
                                                        type="checkbox" id="{{ $student->id() }}"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $student->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                    }}</a>
                                            </td>
                                            <td>
                                                <img 
                                                class="rounded-circle avatar-xs uploadImage"
                                                data-id="{{ $student->id() }}"
                                                src="{{ $student->image() ? asset('storage/'.$student->image()) : asset('noImage.png') }}"
                                                alt="{{ $student->firstName() }}">
                                            </td>
                                            <td>
                                                {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                            </td>
                                            <td>
                                                {{ $student->grade->title() }}
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$student->user' field='reg_no' :key='$student->user->id()'/>
                                            </td>
                                            <td>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading{{ $student->id() }}">
                                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $student->id() }}" aria-expanded="true" aria-controls="collapse{{ $student->id() }}">
                                                                Click to expand
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $student->id() }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $student->id() }}" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <ul class="list-group">
                                                                    @foreach ($student->subjects as $subject)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                            {{ $subject->title() }}
                                                                            <button type="button" class="btn btn-sm btn-danger delete-subject"  data-student-id="{{ $student->id() }}" data-subject-id="{{ $subject->id }}">
                                                                                <i class="bx bx-x"></i>
                                                                            </button>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$student' field='status'
                                                    :key='$student->id()' />
                                            </td>
                                            <td>
                                                @if ($student->status == true)
                                                    <div class="dropdown">
                                                        <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="{{ route('student.show', $student) }}"><i class="fa fa-eye"></i> Show</a>
                                                            <a class="dropdown-item" href="{{ route('student.edit', $student) }}"><i class="fa fa-edit"></i> Edit</a>
                                                            <button class="dropdown-item btn btn-sm btn-primary" wire:click.prevent="sendDetails('{{ $student ->id()}}')">
                                                                <i class="fa fa-envelope"></i> Credentals
                                                            </button>
                                                            <button class="dropdown-item" type="button" id="assingSubject" value="{{ $student->id() }}">
                                                                <i class="fas fa-compress-arrows-alt"></i> Assign Subject
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
                                                @endif
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

    <div class="modal fade updatePassport" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload passport photograph</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <form id="upload" enctype="multipart/form-data">
                        @csrf

                        <input id="student_passport_id" name="student_id" type="hidden" />

                        <div class="row" style="display: flex; justify-content: center; align-items: center">
                            <div class="col-sm-6">
                                <x-form.label for="image" value="{{ __('Passport Photograph') }}" />
                                <x-form.input id="image" class="block w-full mt-1" type="file" name="image"/>
                            </div>

                            <div class="col-sm-6">
                                <canvas style="border-radius: 5px; margin: 5px; width: 150px; height: 150px" id="img-show" class="img-thumbnail img-response"></canvas>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <button type="submit" id="submit_passport" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade generateStudentList" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate student list</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('student.download-pdf') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <select class="form-control" name="grade_id" id="grade_id">
                                        <option value=''>Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="d-flex justify-content-center flex-wrap mt-2">
                                    <button id="excel_upload_button" type="submit"
                                        class="btn btn-primary block waves-effect waves-light pull-right">
                                        Generate List
                                    </button>
                                </div>
                            </div>
                        </form>
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

            $(document).on('click', '.uploadImage', function(e){
                var id = $(this).data('id');
                $('#student_passport_id').val(id);
                $('.updatePassport').modal('toggle');
            });

            var input = document.querySelector('input[type=file]');
            input.onchange = function () {
                var file = input.files[0];
                drawOnCanvas(file); 
                // displayAsImage(file);
            };

            function drawOnCanvas(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var dataURL = e.target.result,
                        c = document.querySelector('#img-show'), // see Example 4
                        ctx = c.getContext('2d'),
                        img = new Image();

                    $('#img-show-container').show()

                    img.onload = function() {
                    c.width = img.width;
                    c.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    };
                    img.src = dataURL;
                };
                reader.readAsDataURL(file);
            }

            $(document).on('click', '#assingSubject', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var button = $(this);
                toggleAble(button, true);

                $.ajax({
                    url: "/student/subjects/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        toggleAble(button, false);

                        $.each(response.data, function(index, subject) {
                            $('#subjects option[value="' + subject.id + '"]').prop('selected', true);
                        });

                        $('#student_id').val(id);
                        $('.addSubject').modal('show');
                    }
                });
            });

            $(document).on('submit', '#createSubjects', function(e){
                e.preventDefault();
                toggleAble('#submit_Sub', true, 'Submitting...');
                var data = $('#createSubjects').serializeArray();
                var url = "{{ route('student.assignSubject') }}";

                $.ajax({
                    type: "POST",
                    url,
                    data
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#submit_Sub', false);
                        toastr.success(res.message, 'Success!');
                        resetForm('#createSubjects');
                        $('.addSubject').modal('toggle');
                        setTimeout(function () {
                            window.location.reload()
                        }, 1000);
                    }else{
                        toggleAble('#submit_Sub', false);
                        toastr.error(res.message, 'Failed!');
                    }
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#submit_button', false);
                });
                
            });

            $(document).on('click', '.delete-subject', function() {
                var studentId = $(this).data('student-id');
                var subjectId = $(this).data('subject-id');

                toggleAble($(this), true);

                $.ajax({
                    url: '/student/' + studentId + '/subject/' + subjectId,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response here
                        toggleAble($(this), false);
                        toastr.success(response.message, 'Success!');
                        setTimeout(function () {window.location.reload()}, 1500);
                    },
                    error: function(xhr, status, error) {
                        toggleAble($(this), false);
                        toastr.error(xhr.responseText, 'Failed!');
                    }
                });
            });

             $(document).on('submit', '#upload', function (e) {
                e.preventDefault();
                let formData = new FormData($('#upload')[0]);
                toggleAble('#submit_passport', true, 'Submitting...');
                var url = "/student/upload/passport";

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    toggleAble('#submit_passport', false);
                    toastr.success(res.message, 'Success!');
                    $('#img-show-container').hide();
                    $('.updatePassport').modal('toggle');
                    resetForm('#upload')

                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#submit_passport', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });
        </script>
        
    @endsection
</div>