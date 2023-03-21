<div>

    <x-loading />

    <div class="row mb-2">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <x-search />
                              @if($search)
                                <button wire:click.prevent="resetSearch" type=" button"
                                    class="btn btn-danger waves-effect btn-label waves-light">
                                    <i class="bx bx-brush-alt label-icon "></i>
                                </button>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control select2" wire:model="type">
                                <option value="">Filter by type</option>
                                <option value="2">Administrator</option>
                                <option value="3">Teachers</option>
                                <option value="5">Bursar</option>
                                <option value="6">Workers</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-check font-size-16">
                            <input class="form-check-input" type="checkbox" id="checkAll"
                                wire:model="selectPageRows">
                                <label class="form-check-label" for="checkAll">all</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        @if($selectedRows)
                        <div class="col-6">
                            <div class="btn-group btn-group-example mb-3" role="group">
                                <button wire:click.prevent="deleteAll" type="button"
                                    class="btn btn-outline-danger btn-sm w-sm" title="delete all employess">
                                    <i class="bx bx-trash"></i>
                                </button>
                                <button wire:click.prevent="disableAll" type="button"
                                    class="btn btn-outline-primary btn-sm w-sm">
                                    <i class="bx bx-check-double"></i>
                                </button>
                                <button wire:click.prevent="undisableAll" type="button"
                                    class="btn btn-outline-primary btn-sm w-sm">
                                    <i class="bx bx-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </diV>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="text-sm-end">
                <button type="button" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".createEmployee">
                    <i class="mdi mdi-plus me-1"></i> Add Employee
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($employees as $employee)
            <div class="col-xl-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                                <img class="rounded-circle avatar-xs"
                                src="{{ asset('storage/'.$employee->image()) }}"
                                alt="{{ $employee->name() }}">
                            </span>
                        </div>
                        <h5 class="font-size-15 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $employee->name() }}</a></h5>
                        <p class="text-muted">{{ $employee->user_type }}</p>
                        <p class="text-muted">{{ $employee->code() }}</p>

                        <div>
                            @if ($employee->type  == 3 && isset($employee->gradeClassTeacher))
                                @forelse ($employee->gradeClassTeacher as $grade)
                                    <span class="badge badge-soft-primary font-size-11 m-">{{ $grade->title() }}</span>
                                @empty
                                    <span class="badge badge-soft-danger font-size-11 m-">Assign Class</span>
                                @endforelse
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="form-check font-size-16">
                                <input class="form-check-input" value="{{ $employee->id() }}" type="checkbox"
                                    id="{{ $employee->id() }}" wire:model="selectedRows">
                                <label class="form-check-label" for="{{ $employee->id() }}"></label>
                            </div>
                            <div class="flex-fill">
                                <a href="javascript: void(0);"><i class="bx bx-message-square-dots"></i></a>
                            </div>
                            @if(count($employee->gradeClassTeacher) > 0)
                                @if ($employee->type  == 3)
                                    <div class="flex-fill" title="Assign class for teacher">
                                        <button type="button" value="{{ $employee->id() }}" data-class="{{ $employee->gradeClassTeacher[0]->id() }}" id="assignClass"><i class="bx bx-dialpad-alt"></i></button>
                                    </div>
                                @endif
                            @else
                                @if ($employee->type  == 3)
                                    <div class="flex-fill" title="Assign class for teacher">
                                        <button type="button" value="{{ $employee->id() }}" id="assignClass"><i class="bx bx-dialpad-alt"></i></button>
                                    </div>
                                @endif
                            @endif
                                
                            <div class="flex-fill">
                                @if(!isset($employee->profile))
                                    <button type="button" id="addProfile" value="{{ $employee->id() }}"><i class="bx bx-user-x text-danger"></i></button>
                                @else
                                    <button type="button" id="edit_btn{{ $employee->profile->id }}" onclick="editProf({{ $employee->profile->id }})"><i class="bx bx-user-check text-success"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <p>No data found!</p>
            </div>
        @endforelse

        {{ $employees->links('pagination::custom-pagination')}}
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Account information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="submitProfile" action="{{ route('staff.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="employee_id" name="employee_id">
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="col-form-label">Salary:</label>
                            <input type="text" class="form-control" id="salary" name="salary">
                        </div>
                        <div class="mb-3">
                            <label for="bank_code">Banks</label>
                            <select class="form-control" id="bank_code" name="bank_code">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="account_number" class="col-form-label">Account Number:</label>
                            <input type="text" class="form-control" id="account_number" name="account_number">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="bank_name" name="bank_name">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="create_profile" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfile" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Update employee's profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEmployeeProfile" action="{{ route('staff.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-sm-12 mb-3">
                            <input id="profile_id" class="form-control" type="hidden" name="profile_id" />
                        </div>

                        <div class="col-sm-12  mb-3">
                            <label for="salary" class="col-form-label">Salary:</label>
                            <input type="text" class="form-control" id="edit_salary" name="edit_salary">
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="edit_account_number" value="{{ __('Account Number') }}" />
                            <input id="edit_account_number" class="form-control" type="text" name="edit_account_number" />
                            <x-form.error for="edit_account_number" />
                        </div>

                        <div class="col-sm-12 mb-3">
                            <x-form.label for="edit_bank_code" value="{{ __('Bank') }}" />
                            <select class="form-control" name="edit_bank_code" id="edit_bank_code">
                                
                            </select>
                            <x-form.error for="edit_bank_code" />
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="edit_bank_name" name="edit_bank_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="update_button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createEmployee" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Create a new employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="modalErrorr"></div>

                    <form id="employeeForm" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="title" value="{{ __('Title') }}" />
                                        <select class="form-control select2" name="title" value="old('title')">
                                            <option>Select</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss.</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                        </select>
                                        <x-form.error for="title" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="name" value="{{ __('Name') }}" />
                                        <x-form.input id="name" class="block w-full mt-1" type="text" name="name"
                                            id="name" :value="old('name')" />
                                        <x-form.error for="name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="email" value="{{ __('Email') }}" />
                                        <x-form.input id="email" class="block w-full mt-1" type="text" name="email"
                                            id="email" :value="old('email')" autocomplete="off" />
                                        <x-form.error for="email" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone_number"
                                             name="phone_number" :value="old('phone_number')" required>
                                        <x-form.error for="phone_number" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="password" value="{{ __('Password') }}" />
                                        <input type="password" class="form-control" id="password"
                                         name="password" autocomplete="off">
                                        <x-form.error for="password" />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="row justify-content-center align-items-center g-2">
                                            <div class="col">
                                                <x-form.label for="image" value="{{ __('Image') }}" />
                                                <x-form.input id="image" class="block w-full mt-1" placeholder="image"
                                                    type="file" name="image" />
                                                <x-form.error for="image" />
                                            </div>
                                            <div class="col">
                                             <div class="image" id="img-show-container" style="display: none; width:50px; height: 50px; border-radius: 50%">
                                                <div class="bx bx-trash-alt btn delete" onclick="resetImgUpl()"></div>
                                                <canvas id="img-show" class="img-thumbnail img-response"></canvas>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-form.label for="type" value="{{ __('Type') }}" />
                                        <select class="form-control select2" name="type" value="old('type')">
                                            <option>Select</option>
                                            <option value="2">Administrator</option>
                                            <option value="3">Teacher</option>
                                            <option value="5">Bursar</option>
                                            <option value="6">Worker</option>
                                        </select>
                                        <x-form.error for="type" />
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="d-flex justify-content-center flex-wrap">
                            <button type="submit" id="create_employee" class="btn btn-primary block waves-effect waves-light pull-right">Save
                                Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.add_class')
    @section('scripts')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $(document).on('click', '#assignClass', function(e) {
            e.preventDefault();
            var id = $(this).val();
            var class_id = $(this).attr('data-class');

            $('#user_id').val(id);
            $('#grade_id').val(class_id);
            $('.addClass').modal('toggle');
        });

        $(document).on('submit', '#assignClasses', function (e) {
            e.preventDefault();
            toggleAble('#submit_button', true, 'Submitting...');
            var data = $('#assignClasses').serializeArray();
            var url = "{{ route('teacher.assignClass') }}";

            $.ajax({
                type: "POST",
                url,
                data
            }).done((res) => {
                if (res.status) {
                    toggleAble('#submit_button', false);
                    toastr.success(res.message, 'Success!');
                    $('.addClass').modal('toggle');
                    setInterval(function () {window.location.reload()}, 1000);
                } else {
                    toggleAble('#submit_button', false);
                    toastr.error(res.message, 'Failed!');
                }
                resetForm('#assignClasses');
            }).fail((res) => {
                console.log(res.responseJSON.message);
                toastr.error(res.responseJSON.message, 'Failed!');
                toggleAble('#submit_button', false);
            });
        })

        $(document).on('click', '#addProfile', function() {
            toggleAble($(this), true);
            var id = $(this).attr('value');
            $('#employee_id').val(id);

            $.ajax({
                url: "/staff/bank/list",
                method: 'GET',
            }).done((res) => {
                $('#bank_code').empty();
                $.each(res.data, function(index, bank) {
                    $('#bank_code').append('<option value="' + bank.code + '">' + bank.name + '</option>');
                });
                toggleAble($(this), false);
                $('#profileModal').modal('toggle');
            }).fail((e) => {
                console.log(e);
            })
        });

        $('#bank_code').on('change', function() {
            var code = $(this).val();

            $.ajax({
                url: '/staff/bank/single/'+ code,
                method: 'GET',
            }).done((response) => {
                console.log(response[0].name);
                $('#bank_name').val(response[0].name);
            }).fail((err) => {
                console.log(err);
            });
        });

         $('#edit_bank_code').on('change', function() {
            var code = $(this).val();

            $.ajax({
                url: '/staff/bank/single/'+ code,
                method: 'GET',
            }).done((response) => {
                console.log(response[0].name);
                $('#edit_bank_name').val(response[0].name);
            }).fail((err) => {
                console.log(err);
            });
        });

        function editProf(id){

            toggleAble('#edit_btn'+id, true);
            $.get('/staff/profile/edit/'+ id, function(response){
                const {data, banks} = response
                console.log(data);
                $('#profile_id').val(data.id);
                $('#edit_salary').val(data.salary);
                $('#edit_bank_code').val(data.bank_code);
                $('#edit_bank_name').val(data.bank_name);
                $('#edit_account_number').val(data.account_number);

                $.each(banks.data, function(index, bank) {
                    $('#edit_bank_code').append('<option value="' + bank.code + '">' + bank.name + '</option>');
                });
                toggleAble('#edit_btn'+id, false);
                $('#editProfile').modal('toggle');
            });
        }

        $(document).on('submit', '#submitProfile', function(e){
            e.preventDefault();
            toggleAble('#create_profile', true, 'Submitting...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            var type = $(this).attr('method');

             $.ajax({
                url, 
                data, 
                type 
            }).done((res) => {
                if (res.status == true) {
                    resetForm('#submitProfile');
                    toggleAble('#create_profile', false);
                    $('#profileModal').modal('toggle');
                    Swal.fire({
                        title: "Success!",
                        text: "Success! " + res.message + "",
                        icon: "success",
                        confirmButtonColor: "#556ee6",
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: " Sorry! " + res.message + "",
                        icon: "error",
                        confirmButtonColor: "#556ee6",
                    });
                    toggleAble('#create_profile', false);
                }
            }).fail((e) => {
                    console.log(e);
                    Swal.fire({
                        title: "Oops!",
                        text: "There was a server error",
                        icon: "question",
                        confirmButtonColor: "#556ee6",
                    });
                    toggleAble('#create_profile', false);
            });
           
        })

        $(document).on('submit', '#editEmployeeProfile', function(e){
            e.preventDefault();
            toggleAble('#update_button', true, 'Updating...');
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            var type = $(this).attr('method');

             $.ajax({
                url, 
                data, 
                type 
            }).done((res) => {
                if (res.status == true) {
                    toggleAble('#update_button', false);
                    $('#editProfile').modal('toggle');
                    Swal.fire({
                        title: "Success!",
                        text: "Success! " + res.message + "",
                        icon: "success",
                        confirmButtonColor: "#556ee6",
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: " Sorry! " + res.message + "",
                        icon: "error",
                        confirmButtonColor: "#556ee6",
                    });
                }
            }).fail((e) => {
                    toggleAble('#update_button', false);
                    console.log(e);
                    Swal.fire({
                        title: "Oops!",
                        text: "There was a server error",
                        icon: "question",
                        confirmButtonColor: "#556ee6",
                    });
            });
           
        })

        $(document).on('submit', '#employeeForm', function(e){
            e.preventDefault();

            let formData = new FormData($('#employeeForm')[0]);
            toggleAble('#create_employee', true, 'Submitting...');
            var url = $(this).attr('action');

                $.ajax({
                    method: "POST",
                    url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done((res) => {
                    if(res.status === true) {
                        toggleAble('#create_employee', false);
                        toastr.success(res.message, 'Success!');
                        $('.createEmployee').modal('toggle');
                        setInterval(function () {window.location.reload()}, 1000);
                    }else{
                        toggleAble('#create_employee', false);
                        toastr.error(res.message, 'Failed!');
                    }
                    resetForm('#employeeForm')
                }).fail((err) => {
                    console.log(err);
                    toggleAble('#create_employee', false);
                    let allErrors = Object.values(err.responseJSON.errors).map(el => (
                            el = `<li>${el}</li>`
                        )).reduce((next, prev) => ( next = prev + next ));

                    const setErrors = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>${allErrors}</ul>
                                        </div>
                                        `;

                    $('.modalErrorr').html(setErrors);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
        })
    </script>

    @endsection
</div>
