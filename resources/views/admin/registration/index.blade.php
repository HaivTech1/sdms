<x-app-layout>
    @section('title', application('name') . " | Registration Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Registration</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div>
    </x-slot>

    <div>
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Today's Registration</p>
                                                <h4 class="mb-0">{{ count($todayRegistrations) }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Admitted</p>
                                                <h4 class="mb-0">{{ count($admittedRegistrations) }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Unadmitted</p>
                                                <h4 class="mb-0">{{ count($unadmittedRegistrations) }}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-lg-12">
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <select class="form-control select2" name="gender">
                                                    <option value=''>Select Gender</option>
                                                    <option value="male" @if(request('gender') == "male") selected @endif>Male</option>
                                                    <option value="female" @if(request('gender') == "female") selected @endif>Female</option>
                                                </select>

                                            </div>

                                            <div class="col-lg-2">
                                                <select class="form-control select2" name="grade_id">
                                                    <option value=''>Select Grade</option>
                                                    @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id }}" @if(request('grade_id') == $grade->id) selected @endif>{{ $grade->title() }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        
                                            <div class="col-lg-2">
                                                <select class="form-control select2" name="status">
                                                    <option value=''>Status</option>
                                                    <option value="1" @if(request('status') == "1") selected @endif>Accepted</option>
                                                    <option value="0" @if(request('status') == "0") selected @endif>Unaccepted</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <button class="btn btn-sm btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </diV>
                            </div>

                            <div class="accordion-item mt-2">
                                <h2 class="accordion-header" id="headingOne">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne"
                                        aria-expanded="true"
                                        aria-controls="collapseOne"
                                    >
                                        Action Tab
                                    </button>
                                </h2>

                                <div
                                    id="collapseOne"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body">
                                        <div class="row mt-2">
                                            <div class="col-sm-2">
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button id="acceptAll" type="button"
                                                        class="btn btn-outline-success w-sm">
                                                        <i class="bx bx-check"></i>
                                                        Accept All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button id="deleteAll" type="button"
                                                        class="btn btn-outline-danger w-sm">
                                                        <i class="bx bx-trash"></i>
                                                        Delete All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button data-bs-toggle="modal" data-bs-target=".downloadRegistrationForm" class="btn btn-sm btn-primary"><i
                                                        class="bx bx-cog"></i> Download Form </button>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button type="button" id="compare" class="btn btn-primary w-xs"><i class="mdi mdi-thumb-up"></i></button>
                                                    <button type="button" id="syncParent" class="btn btn-danger w-xs"><i class="fa fa-users"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <th class="align-middle"> Name </th>
                                            <th class="align-middle"> Class </th>
                                            <th class="align-middle"> Status </th>
                                            <th class="align-middle"> Submitted at </th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registrations as $key => $registration)
                                            <tr>
                                                <td>
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" data-rows-group-id='registrations' value="{{ $registration->id() }}"
                                                            type="checkbox" id="{{ $registration->id() }}"
                                                            data-id="{{ $registration->id }}"
                                                        >
                                                        <label class="form-check-label" for="{{ $registration->id() }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript: void(0);" class="text-body fw-bold">{{ $key + 1
                                                        }}</a>
                                                </td>
                                                <td>
                                                    {{ $registration->firstName() }} {{ $registration->lastName() }}
                                                </td>
                                                <td>
                                                    {{ $registration?->grade?->title() }}
                                                </td>
                                                <td>
                                                    @if ($registration->status === true)
                                                        <span class="badge badge-soft-success">Admitted</span>
                                                    @else
                                                        <span class="badge badge-soft-danger">Not Admitted</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $registration->createdAt() }}
                                                </td>
                                                <td>
                                                     <div class="row">
                                                        <div class="col-sm-4">
                                                            <a class="btn btn-sm btn-secondary"
                                                                href="{{ url('show/registration', $registration) }}"><i
                                                                    class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <button data-id="{{ $registration->id() }}" class="btn btn-sm btn-danger" id="delete"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $registrations->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @section('scripts')
        <script>
            $('#acceptAll').on('click', function(){
                var button = $(this);
                let selectedIds = [];

                $('input:checkbox[data-rows-group-id="registrations"]:checked').each(function () {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length < 1) {
                    alert("Please select at lease one row", "error");
                    return;
                }

                 Swal.fire({
                    title: "Accept Registration",
                    text: 'Are you sure you want to accept the registration',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, proceed!",
                    cancelButtonText: "No, cancel",
                }).then((result) => {
                    var _token = "{{ csrf_token() }}";
                    if (result.isConfirmed) {
                       $.ajax({
                            url: "{{ route('admin.registration.acceptAll')}}",
                            type: "POST",
                            data: {
                                _token: _token,
                                ids: selectedIds
                            },
                            beforeSend: function () {
                                button.LoadingOverlay("show");
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "Application Accepted",
                                    text: data.message,
                                    icon: 'success'
                                });
                            },
                            error: function (data) {
                                button.LoadingOverlay("hide");
                                Swal.fire({
                                    title: "Action Failed!",
                                    text: data.responseJSON.message,
                                    icon: 'error',
                                });
                            },
                            complete: function (xhr, textStatus) {
                                button.LoadingOverlay("hide");
                            },
                        });
                    }
                });
            });

            $('#deleteAll').on('click', function(){
                var button = $(this);
                let selectedIds = [];

                $('input:checkbox[data-rows-group-id="registrations"]:checked').each(function () {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length < 1) {
                    alert("Please select at lease one row", "error");
                    return;
                }

                Swal.fire({
                    title: "Delete Registration",
                    text: 'Are you sure you want to delete the registration',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, proceed!",
                    cancelButtonText: "No, cancel",
                }).then((result) => {
                    var _token = "{{ csrf_token() }}";
                    if (result.isConfirmed) {
                       $.ajax({
                            url: "{{ route('admin.registration.deleteAll')}}",
                            type: "POST",
                            data: {
                                _token: _token,
                                ids: selectedIds
                            },
                            beforeSend: function () {
                                button.LoadingOverlay("show");
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "Application Deleted",
                                    text: data.message,
                                    icon: 'success'
                                });

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            },
                            error: function (data) {
                                button.LoadingOverlay("hide");
                                Swal.fire({
                                    title: "Action Failed!",
                                    text: data.responseJSON.message,
                                    icon: 'error',
                                });
                            },
                            complete: function (xhr, textStatus) {
                                button.LoadingOverlay("hide");
                            },
                        });
                    }
                });
            });
        </script>
    @endsection

</x-app-layout>