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
                                                    <button wire:click.prevent="promoteAll" type="button"
                                                        class="btn btn-outline-success w-sm">
                                                        <i class="bx bx-caret-right"></i>
                                                        Promote All
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button wire:click.prevent="repeatAll" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-caret-left"></i>
                                                        Repeat All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                      
                                </diV>
                            </div>
                        </div>

                        <div class=" col-sm-4">
                            <div class="text-sm-end">
                                <a href="{{ route('student.create') }}"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i
                                        class="mdi mdi-plus me-1"></i> Add Student</a>
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
                                                {{ $student->firstName() }} {{ $student->lastName() }}
                                            </td>
                                            <td>
                                                {{ $student->grade->title() }}
                                            </td>
                                            <td>
                                                {{ $student->user->code() }}
                                            </td>
                                            <td>
                                                {{ $student->subjects->count() }}
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$student' field='status'
                                                    :key='$student->id()' />
                                            </td>
                                            <td>
                                                @if ($student->status == true)
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <a class="dropdown-item"
                                                                href="{{ route('student.show', $student) }}"><i
                                                                    class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <a class="dropdown-item"
                                                                href="{{ route('student.edit', $student) }}"><i
                                                                    class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <button type="button" data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasWithBothOptions{{ $student->id() }}"
                                                                aria-controls="offcanvasWithBothOptions">
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
                                                                            <form
                                                                                id="assignSubjects">
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
                                                                                        <button id="submit_button1" type="submit"
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

    @section('scripts')

        <script>
            $('#assignSubjects').submit((e) => {
                    toggleAble('#submit_button1', true, 'Submitting...');
                    e.preventDefault()
                    var data = $('#assignSubjects').serializeArray();
                    var url = "{{ route('student.assignSubject') }}";

                    $.ajax({
                        type: "POST",
                        url,
                        data
                    }).done((res) => {
                        if(res.status === 'success') {
                            toggleAble('#submit_button1', false);
                            toastr.success(res.message, 'Success!');
                        }else{
                            toggleAble('#submit_button1', false);
                            toastr.error(res.message, 'Failed!');
                        }
                        resetForm('#assignSubjects');
                        setInterval(function () {window.location.reload()}, 2000);
                        
                    }).fail((res) => {
                        console.log(res.responseJSON.message);
                        toastr.error(res.responseJSON.message, 'Failed!');
                        toggleAble('#submit_button1', false);
                    });
                })
        </script>
        
    @endsection
</div>