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
                                                    <option value="{{ $grade->id }}}">{{  $ }}grade->title()}}</option> 
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

                                        @if ($selectedRows)
                                            <div class="col-6">
                                                <div class="btn-group btn-group-example mb-3" role="group">
                                                    <button wire:click.prevent="deleteAll" type="button"
                                                        class="btn btn-outline-primary w-sm">
                                                        <i class="bx bx-block"></i>
                                                        Delete All
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
                                            <th class="align-middle"> Gender </th>
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
                                                        <label class="form-check-label"
                                                            for="{{ $student->id() }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript: void(0);"
                                                        class="text-body fw-bold">{{ $key + 1 }}</a>
                                                </td>
                                                <td>
                                                    {{ $student->firstName() }} {{ $student->lastName() }}
                                                </td>
                                                <td>
                                                    {{ $student->grade->title() }}
                                                </td>
                                                <td>
                                                    {{ $student->gender() }}
                                                </td>
                                                <td>
                                                    <livewire:components.toggle-button :model='$student'
                                                        field='status' :key='$student->id()' />
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a class="dropdown-item" href="{{ route('student.show', $student) }}"><i
                                                            class="fa fa-eye"></i></a>
                                                            <a class="dropdown-item" href="{{ route('student.edit', $student) }}"><i
                                                                class="fa fa-edit"></i></a>
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
</div>
