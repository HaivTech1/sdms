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
                                    @if ($selectedRows)
                                        <div class="row justify-content-center align-items-center g-2 mt-2">
                                            <div class="col-sm-4">
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button wire:click.prevent="deleteAll" type="button"
                                                        class="btn btn-outline-danger w-sm">
                                                        <i class="bx bx-trash"></i>
                                                        Delete All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button wire:click.prevent="acceptAll" type="button"
                                                        class="btn btn-outline-success w-sm">
                                                        <i class="bx bx-check"></i>
                                                        Accept All
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                      
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
                                                        <button value="{{ $registration->id() }}" class="btn btn-sm btn-danger" id="delete"><i class="fa fa-trash"></i></button>
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
                    var id = $(this).val();
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
    </script>
@endsection