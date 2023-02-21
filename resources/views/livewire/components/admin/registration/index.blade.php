<div>
    <x-loading />

     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <x-search />
                                </div>

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
                                            <div class="btn-group btn-group-example mb-3" role="group">
                                                <button type="button" id="compare" class="btn btn-primary w-xs"><i class="mdi mdi-thumb-up"></i></button>
                                                <button type="button" class="btn btn-danger w-xs"><i class="mdi mdi-thumb-down"></i></button>
                                            </div>
                                        </div>
                                    </div>     
                                </diV>
                            </div>
                            @if ($selectedRows)
                                <div class="row mt-2">
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="acceptAll" type="button"
                                                class="btn btn-outline-success w-sm">
                                                <i class="bx bx-check"></i>
                                                Accept All
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
                                </div>
                            @endif
                        </div>

                    </div>

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
                                                    <input class="form-check-input" value="{{ $registration->id() }}"
                                                        type="checkbox" id="{{ $registration->id() }}"
                                                        wire:model="selectedRows">
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
                                                {{ $registration->grade->title() }}
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
                            {{ $registrations->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.compare')
</div>


@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#delete').on('click', function() {
                if(confirm(`Are you sure want to remove this?`)){
                    var id = $(this).data('id');
                    $.ajax({
                        url:"/delete/registration" +'/'+ id,
                        type:"DELETE",
                        dataType:'json',
                        success:function(response)
                        {
                            toastr.success(response.message, 'Success!');
                        },
                        error:function(error)
                        {
                            console.log(error);
                            toastr.error(error, 'Failed!');
                        },
                    });
                }
            })
        });

        $('#compare').on('click', function(){
            toggleAble('#compare', true, 'Fetching...');
            $.get("/compare/registration", function(response){
                const { data, message } = response;
                if(response.status){
                    toggleAble('#compare', false);
                     var rows = "";
                    $.each(data, function(key, value) {
                        rows += "<tr>";
                        rows += "<td><input type='checkbox' name='selected[]' value='" + value.id + "'></td>";
                        rows += "<td>" + value.first_name + ' ' + value.last_name + ' ' + value.other_name +"</td>";
                        rows += "<td><button class='btn btn-secondary' id='accept' data-id='" + value.id + "'>Accept</button></td>";
                        rows += "</tr>";
                    });
                    $("#table-body").append(rows);
                    $(".message").append(message);
                    $('.compareRegistration').modal('toggle');
                }
            });
        });

        $(document).on('click', '#table-body button', function() {
            var id = $(this).data('id');
            toggleAble('#accept', true);
            $.ajax({
                url:"/accept/student" +'/'+ id,
                type:"GET",
                dataType:'json',
                success:function(response)
                {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#accept', false);
                    $('.compareRegistration').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error:function(error)
                {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#accept', false);
                },
            });
        });

        $(document).on('click', '#select-all', function() {

            var cherker = document.getElementById('select-all');
            var sendBtn = document.getElementById('submit_button');

            cherker.onchange = function(){
                if(this.checked){
                    sendBtn.disabled = false;
                }else{
                    sendBtn.disabled = true;
                }
            }

            $('input[name="selected[]"]').prop('checked', $(this).prop('checked'));
        });

        $(document).on('click', 'input[name="selected[]"]', function() {

            var cherker = document.querySelector('input[name="selected[]"]');
            var sendBtn = document.getElementById('submit_button');

            cherker.onchange = function(){
                if(this.checked){
                    sendBtn.disabled = false;
                }else{
                    sendBtn.disabled = true;
                }
            }

            var allChecked = $('input[name="selected[]"]').length === $('input[name="selected[]"]:checked').length;
            $('#select-all').prop('checked', allChecked);
        });

        $(document).on('submit', '#accpeptAllStudents', function(e) {
            e.preventDefault();
            toggleAble('#submit_button', true, 'Submitting');
            var selected = $('input[name="selected[]"]:checked').map(function() {
                return this.value;
            }).get();

            var formData = new FormData();
            formData.append('selected', selected);

            $.ajax({
                url: "/accept/student/all",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message, 'Success!');
                    toggleAble('#submit_button', false);
                    $('.compareRegistration').modal('toggle');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    toastr.error(error, 'Failed!');
                    toggleAble('#submit_button', false);
                }
            });
        });
    </script>
@endsection