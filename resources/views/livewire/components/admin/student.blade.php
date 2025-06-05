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
                                                <option value="{{ $grade->id }}">{{ $grade?->title() }}</option>
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
                                    <div class="col-sm-2">
                                        <div class="btn-group btn-group-example" role="group">
                                            <button wire:click.prevent="syncRole" type="button"
                                                class="btn btn-outline-primary w-sm">
                                                <i class="bx bx-caret-left"></i>
                                                Sync Role
                                            </button>
                                        </div>
                                    </div>
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
                                            <th class="align-middle"> Priviledge </th>
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
                                                src="{{ $student->image() ? asset('storage/' . $student->image()) : asset('noImage.png') }}"
                                                alt="{{ $student->firstName() }}">
                                            </td>
                                            <td>
                                                {{ $student->lastName() }} {{ $student->firstName() }} {{ $student->otherName() }}
                                            </td>
                                            <td>
                                                {{ $student?->grade?->title() }}
                                            </td>
                                            <td>
                                                @foreach($student->user->roles as $role)
                                                    {{ $role?->title() }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <livewire:components.edit-title :model='$student->user' field='reg_no' :key='$student->user->id()'/>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>{{ $student->subjects->count() }}</p>
                                                </div>
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
                                                                            {{ $subject?->title() }}
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
                                                            <button class="dropdown-item btn btn-sm btn-primary" wire:click.prevent="sendDetails('{{ $student->id()}}')">
                                                                <i class="fa fa-envelope"></i> Credentals
                                                            </button>

                                                            <button class="dropdown-item" type="button" id="assingSubject" value="{{ $student->id() }}">
                                                                <i class="fas fa-compress-arrows-alt"></i> Assign Subject
                                                            </button>

                                                            <button class="dropdown-item" type="button" id="viewResult" value="{{ $student->id() }}">
                                                                <i class="fas fa-compress-arrows-alt"></i> View Results
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
                                                                                <input type="text"
                                                                                    value="{{ $student->id() }}"
                                                                                    name="student_id" />

                                                                                <div class="col-sm-12 mt-2">
                                                                                    
                                                                                    <select name="subjects[]"
                                                                                        class="form-control select2-multiple"
                                                                                        multiple>
                                                                                        @foreach ($subjects as $subject)
                                                                                        <option
                                                                                            value="{{ $subject->id() }}">
                                                                                            {{ $subject?->title() }}</option>
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
                                                                                    <li><span class="badge badge-soft-info">{{ $subject?->title() }}</span></li>
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
                                        <option value="{{  $grade->id() }}">{{ $grade?->title() }}</option>
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

    <div class="modal fade viewStudentResult" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View student results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div data-repeater-list="group-a">
                                <form id="fetchResultForm">
                                    <div data-repeater-item class="row">
                                        <input id="student_result_id" type="hidden" name="student_result_id" />
                                        <div class="mb-3 col-lg-3">
                                            <label for="name">Grade</label>
                                            <select id="result_grade_id" class="form-control " name="grade_id">
                                                <option value=''>Choose...</option>
                                                @foreach ($grades as $grade)
                                                    <option value="{{  $grade->id() }}">{{ $grade?->title() }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-lg-3">
                                            <label for="name">Session</label>
                                            <select id="period_id" class="form-control " name="period_id">
                                                <option value=''>Choose...</option>
                                                @foreach ($periods as $id => $period)
                                                <option value="{{  $id }}">{{ $period }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-lg-3">
                                            <label for="email">Term</label>
                                            <select id="term_id" class="form-select" name="term_id">
                                                <option selected>Choose...</option>
                                                @foreach ($terms as $id => $term)
                                                <option value="{{ $id }}">{{ $term }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3 align-self-center">
                                            <div class="d-grid">
                                                <button id="fetchResultButton" data-repeater-delete type="submit" class="btn btn-primary">
                                                    Fetch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="cols-lg-12">
                            <div class="table-responsive">
                                <table id="result-data" class="table table-bordered table-striped table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Name</th>
                                            <th scope="col" class="text-center">
                                                Present Class
                                            </th>
                                            <th scope="col" class="text-center">
                                                 Class Result
                                            </th>
                                             <th scope="col" class="text-center">
                                                Recorded Subjects
                                            </th>
                                            <th scope="col" class="text-center" id="action">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade previewResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Result Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                            <div class="row">

                                <div class="card">
                                    <div class="card-header">
                                        <button data-student-id="" class="btn btn-sm btn-secondary addResult" ><i class="bx bx-plus"></i> Add Result</button>
                                    </div>
                                </div>

                                <input name="result_id" id="result_id" type="hidden" />

                                <div class="col-sm-12 mb-2">
                                    @php
$examForm = get_settings('exam_format');
$midtermForm = get_settings('midterm_format');
                                    @endphp
                                    <div class="table-responsive">
                                        <table id="students-result" class="table table-borderless">

                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>CA1</th>
                                                    <th>CA2</th>
                                                    <th>CA3</th>
                                                    <th>Project</th>
                                                    @foreach ($examForm as $key => $value)
                                                        <th>{{ $value['full_name'] }}</th>
                                                    @endforeach
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" id="scoreInput" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveScoreBtn">Save</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade addResultModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="resultUpload" method="POST">
                            @csrf
                            <input name="student_id" id="add_student_id" type="hidden" />

                            @php
$examForm = get_settings('exam_format');
$subjects = \App\Models\Subject::all();
                            @endphp

                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="form-control" name="subject_id">
                                        <option value=''>Subject</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{  $subject->id() }}">{{  $subject?->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <select id="format-select" class="form-control">
                                        <option value="">Select test type</option>
                                        @foreach ($examForm as $key => $value)
                                            <option value="{{ $key }}">{{ $value['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <x-form.input style='width: 70px' class="text-center required exam-input" type='number'
                                        name='' value="" step="0.01" onblur="validateInput(this)" disabled/>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap mt-2">
                                <button id="submit_button" type="submit"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Upload Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade editPlayModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div class="row">
                        <form id="uploadPlaygroupResult" action="{{ route('result.playgroup.store') }}" method="POST">
                            @csrf

                            <input type="hidden" id="edit_playgroup_student" value="" name="student_id" />
                            <input type="hidden" id="edit_playgroup_period" value="" name="period_id" />
                            <input type="hidden" id="edit_playgroup_term" value="" name="term_id" />
                        
                            <div class='table-responsive'>
                                <table class="table align-middle table-nowrap" id="edit-play-result">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subjects</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm 12 d-flex justify-content-center flex-wrap gap-2">
                                <button type="submit" id="upload_playgroup_btn"
                                    class="btn btn-primary block waves-effect waves-light pull-right">
                                    Update Result
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('scripts')
        <script>

            function publish(student){
                var data = student.split(",");
                var student_id = data[0];
                var period_id = data[1];
                var term_id = data[2];
                var grade_id = data[3];
                
                toggleAble('#cummulative'+ student_id, true);

                $.ajax({
                    url: '{{ route('result.primary.publish') }}' ,
                    method: 'GET',
                    data: {student_id, period_id, term_id, grade_id }
                }).done((res) => {
                    toggleAble('#cummulative'+ student_id, false);
                    toastr.success(res.message, 'Success!');
                }).fail((res) => {
                    console.log(res.responseJSON.message);
                    toastr.error(res.responseJSON.message, 'Failed!');
                    toggleAble('#cummulative'+ student_id, false);
                });
            }
            
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

            $(document).on('click', '#viewResult', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $('#student_result_id').val(id);
                $('.viewStudentResult').modal('show');
            });

            $('#fetchResultForm').on('submit', function(e){
                e.preventDefault();
                var button = $('#fetchResultButton');
                toggleAble(button, true, 'Fetching...');

                var grade = $('#result_grade_id').val();
                var period = $('#period_id').val();
                var term = $('#term_id').val();
                var student = $('#student_result_id').val();

                $.ajax({
                    type: 'GET',
                    url: '{{ route("result.check.single.exam", ["student_id" => ":student_id", "grade_id" => ":grade_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':student_id', student).replace(':grade_id', grade).replace(':period_id', period).replace(':term_id', term),
                    dataType: 'json',
                }).done((response) => {
                    toggleAble(button, false);
                    var result = response.result;

                    var html = '';
                    if (response.grade_name === 'Playgroup') {
                        html += '<tr>';
                            html += '<td class="text-center">' + result.name + '</td>';
                            html += '<td class="text-center">' + response.current_class + '</td>';
                            html += '<td class="text-center">' + response.grade_name + '</td>';
                            html += '<td class="text-center">' + result.recorded_subjects + '</td>';
                            html += '<td>';
                            html += '<button class="btn btn-sm btn-danger editPlayResult" data-period="'+response.period+'" data-term="'+response.term+'" data-id="' + result.id + '"><i class="bx bx-edit"></i> Edit</button>';
                            html += '<a target="_blank" href="{{ route('result.playgroup.show', ['student' => ':student']) }}'.replace(':student', result.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                            html += '<div class="d-flex gap-2">';
                            html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + result.id + '" onClick="publish(\'' + result.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                            html += '<span>Publish</span>';
                            html += '</button>';
                            html += '<form action="{{ route('result.playgroup.pdf') }}" method="POST">';
                            html += '@csrf';
                            html += '<input type="hidden" name="student_id" value="' + result.id + '" />';
                            html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                            html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                            html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                            html += '<button class="btn btn-sm btn-info" type="submit">';
                            html += '<i class="bx bxs-file-pdf"></i> PDF';
                            html += '</form>';
                            html += '</div>';
                            html += '</td>';
                        html += '</tr>';
                    } else {
                        html += '<tr>';
                            html += '<td class="text-center">' + result.name + '</td>';
                            html += '<td class="text-center">' + response.current_class + '</td>';
                            html += '<td class="text-center">' + response.grade_name + '</td>';
                            html += '<td class="text-center">' + result.recorded_subjects + '</td>';
                            html += '<td>';
                            html += '<button class="btn btn-sm btn-secondary recorded" data-grade="'+response.grade+'" data-period="'+response.period+'" data-term="'+response.term+'" data-student="' + result.id + '"><i class="fa fa-cogs"></i> View Recorded</button>';
                            html += '<a target="_blank" href="{{ route('result.primary.show', ['student' => ':student']) }}'.replace(':student', result.id) + '?grade_id=' + response.grade + '&period_id=' + response.period + '&term_id=' + response.term + '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view result" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View Result</a>';
                            html += '<div class="d-flex gap-2">';
                            html += '<button type="button" class="btn-sm btn-warning" id="cummulative' + result.id + '" onClick="publish(\'' + result.id + ',' + response.period + ',' + response.term + ',' + response.grade + '\')">';
                            html += '<span>Publish</span>';
                            html += '</button>';
                            html += '<form action="{{ route('result.exam.pdf') }}" method="POST">';
                            html += '@csrf';
                            html += '<input type="hidden" name="student_id" value="' + result.id + '" />';
                            html += '<input type="hidden" name="grade_id" value="' + response.grade + '" />';
                            html += '<input type="hidden" name="period_id" value="' + response.period + '" />';
                            html += '<input type="hidden" name="term_id" value="' + response.term + '" />';
                            html += '<button class="btn btn-sm btn-info" type="submit">';
                            html += '<i class="bx bxs-file-pdf"></i> PDF';
                            html += '</form>';
                            html += '</div>';
                            html += '</td>';
                        html += '</tr>';
                    }

                    $('#result-data tbody').html(html);

                    $('.recorded').on('click', function(e){
                        var button = $(this);
                        toggleAble(button, true)

                        var id = $(this).data('student');
                        var classId = $(this).data('grade');
                        var sessionId = $(this).data('period');
                        var termId = $(this).data('term');
                        console.log(id, classId, sessionId, termId);

                        $.ajax({
                            url: '{{ route("result.fetch.exam", ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id", "grade_id" => ":grade_id"]) }}'.replace(':student_id', id).replace(':period_id', sessionId).replace(':term_id', termId).replace(':grade_id', classId),
                            type: 'GET',
                            dataType: 'json',
                        }).done((response) => {
                            toggleAble(button, false);
                            var results = response.results;

                            var html = '';
                            $.each(results, function(index, result) {
                                html += '<tr>';
                                html += '<td>' + result.subject_name + '</td>';
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="ca1">' + (result.ca1 ? result.ca1 : "-") + '</td>';
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="ca2">' + (result.ca2 ? result.ca2 : "-") + '</td>';
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="ca3">' + (result.ca3 ? result.ca3 : "-") + '</td>';
                                html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="pr">' + (result.pr ? result.pr : "-") + '</td>';

                                var examFormat = JSON.parse('<?php echo json_encode($examForm); ?>');
                                $.each(examFormat, function(examKey, examValue) {
                                    var score = '-';
                                    if (examKey in result) {
                                        score = result[examKey];
                                    }
                                    html += '<td class="score-cell" data-result-id="' + result.result_id + '" data-subject-id="' + result.subject_id + '" data-exam-key="' + examKey + '">' + score + '</td>';
                                });

                                html += '<td>' + result.total + '</td>';
                                html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + result.result_id + '"><i class="bx bx-trash"></button></td>';
                                html += '</tr>';
                            });

                            $('#students-result tbody').html(html);
                            $('.addResult').data('student-id', id)
                            $('.previewResultModal').modal('toggle');

                            $('.score-cell').click(function() {
                                var resultId = $(this).data('result-id');
                                var subjectId = $(this).data('subject-id');
                                var examKey = $(this).data('exam-key');
                                var currentScore = $(this).text();
                                $('#scoreInput').val(currentScore);
                                $('#saveScoreBtn').data('result-id', resultId);
                                $('#saveScoreBtn').data('subject-id', subjectId);
                                $('#saveScoreBtn').data('exam-key', examKey);
                                $('#editModal').modal('show');
                            });

                            $('#saveScoreBtn').click(function() {
                                var button = $(this);
                                toggleAble(button, true, 'Updating...');
                                var resultId = $(this).data('result-id');
                                var subjectId = $(this).data('subject-id');
                                var examKey = $(this).data('exam-key');
                                var editedScore = $('#scoreInput').val();

                                Swal.fire({
                                    title: 'Confirm Submission',
                                    text: 'Are you sure you want to update the score?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#502179',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Update'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                        });
                                        
                                        $.ajax({
                                            url: '{{ route('result.update.exam') }}',
                                            type: 'POST',
                                            data: {result_id: resultId, subject_id: subjectId, field: examKey, score: editedScore},
                                        }).done((response) => {
                                            toggleAble(button, false);
                                            Swal.fire('Updated!', response.message, 'success');
                                            $('.score-cell[data-subject-id="' + subjectId + '"][data-exam-key="' + examKey + '"]').text(editedScore);
                                            $('#editModal').modal('toggle');
                                        }).fail((error) => {
                                            toggleAble(button, false);
                                            console.log(error);
                                        });
                                    }else{
                                        toggleAble(button, false);
                                    }
                                });
                            });

                            $('.addResult').click(function(){
                                $('.previewResultModal').modal('toggle');
                                var student = $(this).data('student-id');
                                document.getElementById('add_student_id').value = student;
                                $('.addResultModal').modal('toggle');
                            });

                        }).fail((error) => {
                            toggleAble(button, false);
                            toastr.error(error.responseJSON.message);
                            console.log(error);
                        });

                    });

                    $('.editPlayResult').click(function(e){
                    e.preventDefault();
                    var button = $(this);
                    toggleAble(button, true);

                    var id = $(this).data('id');
                    var period = $(this).data('period');
                    var term = $(this).data('term');

                    $.ajax({
                        method: 'GET',
                        url: '{{ route('result.playgroup.student', ["student_id" => ":student_id", "period_id" => ":period_id", "term_id" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term).replace(':student_id', id),
                    }).done((response) => {
                        toggleAble(button, false);
                        var results = response.results;
                        var html = '';

                        $.each(results, function(index, result) {
                            if (typeof result.remark !== 'string') {
                                var formattedRemark = [];

                                for( var key in result.remark) {
                                    if(result.remark.hasOwnProperty(key)){
                                        formattedRemark.push(key + ': ' + result.remark[key]);
                                    }
                                }

                                result.remark   = formattedRemark.join('. ');

                            }

                            html += '<tr>';
                            html += '<td style="width: 5%">';
                            html += '<p class="text-left">' + result.subject_name + '</p>';
                            html += '</td>';
                            html += '<td>';
                            html += '<input type="hidden" value="' + result.subject_id + '" name="subject_id[]" />';
                            html += '<input type="text" name="remark[' + result.subject_id + ']" class="form-control block w-full mt-1" style="height: 60px" value="'+ result.remark+'" />';
                            html += '</td>';
                            html += '</tr>';

                        });

                        document.getElementById('edit_playgroup_student').value = response.student_id;
                        document.getElementById('edit_playgroup_period').value = response.period_id;
                        document.getElementById('edit_playgroup_term').value = response.term_id;

                        $('#edit-play-result tbody').html(html);
                        $(".editPlayModal").modal('toggle');
                    }).fail((error) => {
                        toggleAble(button, false);
                        console.log(error.responseJSON.message);
                    });
                });

                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                    console.log(error);
                });
            });

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

                        $('#edit_student_id').val(id);
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