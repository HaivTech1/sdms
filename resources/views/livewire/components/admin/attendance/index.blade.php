<div>
     <x-loading />

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-6">
                    <x-search />
                </div>
                <div class=" col-sm-6">
                    <div class="text-sm-end">
                        <button class="btn btn-sm btn-primary btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".addAttendance"><i
                        class="mdi mdi-plus me-1"></i> Create Attendance</button>
                    </div>
                </div>
            </div>
            <div class="row">
                 @if($selectedRows)
                    <div class="col-6">
                        <div class="btn-group btn-group-example mb-3" role="group">
                            <button wire:click.prevent="deleteAll" type="button"
                                class="btn btn-outline-danger w-sm">
                                <i class="bx bx-block"></i>
                                Delete All
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                            <th class="align-middle"> Grade </th>
                                            <th class="align-middle"> Date </th>
                                            <th class="align-middle"> Status </th>
                                            <th class="align-middle"> Marked </th>
                                            <th class="align-middle"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $key => $attendance)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" value="{{ $attendance->id() }}"
                                                        type="checkbox" id="{{ $attendance->id() }}"
                                                        wire:model="selectedRows">
                                                    <label class="form-check-label" for="{{ $attendance->id() }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-body fw-bold">{{ $key + 1}}</p>
                                            </td>
                                            <td>
                                                {{ $attendance->grade->title ?? '' }}
                                            </td>
                                             <td>
                                                {{ $attendance->date() }}
                                            </td>
                                            <td>
                                                <livewire:components.toggle-button :model='$attendance' field='status'
                                                    :key='$attendance->id()' />
                                            </td>
                                            <td>
                                                {{ $attendance->markedAttendance->count() ?? '' }}
                                            </td>
                                            <td>
                                                <button data-id="{{ $attendance->id() }}" data-class="{{ $attendance->grade->id() }}" class="btn btn-sm btn-success btn-rounded waves-effect waves-light mb-2 me-2 markAtt" data-bs-toggle="modal" data-bs-target=".addAttend">
                                                    <i class="mdi mdi-plus me-1"></i> Mark Attendance
                                                </button>
                                                <button data-id="{{ $attendance->id() }}" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light mb-2 me-2 show" data-bs-toggle="modal" data-bs-target=".showAttendance"><i
                                                    class="mdi mdi-eye me-1"></i> View</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $attendances->links('pagination::simple-tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade showAttendance" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List of student's attendance taken</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <div class="row">
                            <div class="row">
                                <input name="attendance_id" id="attendance_id" type="hidden" />

                                <div class="col-sm-12 mb-2">
                                    <div class="table-responsive">
                                        <table id="students-attendance" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Registration No.</th>
                                                    <th>Morning</th>
                                                    <th>Afternoon</th>
                                                    <th>Status</th>
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
    </div>

    <div class="modal fade addAttend" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark daily attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <div class="row">
                            <form id="markAttendance" method="POST" action="{{ route('attendance.mark') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <input name="attendance_id" id="attendance" type="hidden" />
                                    <input name="grade" id="attendance_grade" type="hidden" />

                                    {{-- <div class="col-sm-12 mb-2">
                                        @php
                                            $grades = \App\Models\Grade::all();
                                        @endphp
                                        <x-form.label for="grade" :value="__('Grade')" />
                                        <select id="grade" name="grade" value="old('grade')" class="form-control block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                            <option value="">Select a Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class="col-sm-12 mb-2">
                                        <div class="table-responsive">
                                            <table id="students-table" class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Registration No.</th>
                                                        <th>Morning</th>
                                                        <th>Afternoon</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="pull-right">
                                        <button type="submit" id="addStudentAttend" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade addAttendance" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modalErrorr"></div>

                    <div>
                        <div class="row">
                            <form id="addAttendance" method="POST" action="{{ route('attendance.store') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        @php
                                            $grades = \App\Models\Grade::all();
                                        @endphp
                                        <x-form.label for="grade_id" :value="__('Grade')" />
                                        <select id="grade_id" name="grade_id" value="old('grade')" class="form-control block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                            <option value="">Select a Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        @php
                                            $sessions = \App\Models\Period::all();
                                        @endphp
                                        <x-form.label for="session_id" :value="__('Session')" />
                                        <select id="session_id" name="session_id" value="old('session')" class="form-control block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                            <option value="">Select a session</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                     <div class="col-sm-6 mb-2">
                                        @php
                                            $terms = \App\Models\Term::all();
                                        @endphp
                                        <x-form.label for="term_id" :value="__('Term')" />
                                        <select id="term_id" name="term_id" value="old('term_id')" class="form-control block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                                            <option value="">Select a term</option>
                                            @foreach ($terms as $term)
                                                <option value="{{ $term->id }}">{{ $term->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 mb-3 row">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}"
                                                    id="example-date-input" name="date">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Activate</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="pull-right">
                                        <button type="submit" id="attendanceBtn" class="btn btn-primary">Submit</button>
                                    </div>
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
            $('#grade').on('change', function(){
                var gradeId = $(this).val();
                var attendanceId = $('#attendance').val();

                $.ajax({
                    url: "/attendance/students/fetch",
                    method: 'GET',
                    data: { gradeId: gradeId, attendanceId: attendanceId },
                    success: function(response) {
                        var students = response.students;
                        var html = '';

                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td>' + student.name + '</td>';
                            html += '<td>' + student.reg_no + '</td>';
                            html += '<td>';
                            html += '<div class="form-check form-checkbox-outline form-check-success mb-3">';
                            html += '<input class="form-control" type="hidden" name="student[]" value="' + student.id + '">';
                            html += '<input class="form-check-input" type="checkbox" name="morning[]" ' + (student.morning ? 'checked' : '') + '>';
                            html += '</div>';
                            html += '</td>';
                            html += '<td>';
                            html += '<div class="form-check form-checkbox-outline form-check-success mb-3">';
                            html += '<input class="form-check-input" type="checkbox" name="afternoon[]" ' + (student.afternoon ? 'checked' : '') + '>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        });

                        $('#students-table tbody').html(html);
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            });

            $(document).on('submit', '#addAttendance', function (e) {
                e.preventDefault();
                toggleAble('#attendanceBtn', true, 'Submitting...');
                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                        toggleAble('#attendanceBtn', false);
                        toastr.success(res.message, 'Success!');
                        $('.addAttendance').modal('toggle');
                        resetForm('#addAttendance');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1500)

                }).fail((err) => {
                    console.log(err);
                    toggleAble('#attendanceBtn', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $('.markAtt').on('click', function(e){
                e.preventDefault();
                {{-- var id = $(this).data('id'); --}}
                {{-- $(".addStudent").modal('toggle'); --}}

                var gradeId = $(this).data('class');
                var attendanceId = $(this).data('id');

                document.getElementById("attendance").value= attendanceId;
                document.getElementById("attendance_grade").value = gradeId;

                $.ajax({
                    url: "/attendance/students/fetch",
                    method: 'GET',
                    data: { gradeId: gradeId, attendanceId: attendanceId },
                    success: function(response) {
                        var students = response.students;
                        var html = '';

                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td>' + student.name + '</td>';
                            html += '<td>' + student.reg_no + '</td>';
                            html += '<td>';
                            html += '<div class="form-check form-checkbox-outline form-check-success mb-3">';
                            html += '<input class="form-control" type="hidden" name="student[]" value="' + student.id + '">';
                            html += '<input class="form-check-input" type="checkbox" name="morning[]" ' + (student.morning ? 'checked' : '') + '>';
                            html += '</div>';
                            html += '</td>';
                            html += '<td>';
                            html += '<div class="form-check form-checkbox-outline form-check-success mb-3">';
                            html += '<input class="form-check-input" type="checkbox" name="afternoon[]" ' + (student.afternoon ? 'checked' : '') + '>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        });

                        $('#students-table tbody').html(html);
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            });

            $('#markAttendance').on('submit', function(e) {
                e.preventDefault();
                toggleAble('#addStudentAttend', true, 'Submitting...');
                var url = $(this).attr('action');
                var data = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url,
                    data
                }).done((res) => {
                        toggleAble('#addStudentAttend', false);
                        toastr.success(res.message, 'Success!');
                        $('.addStudent').modal('toggle');
                        resetForm('#markAttendance');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1500)

                }).fail((err) => {
                    console.log(err);
                    toggleAble('#addStudentAttend', false);
                    toastr.error(err.responseJSON.message, 'Failed!');
                });
            });

            $(document).on('click', '.show', function() {
                var attendanceId = $(this).data('id');
                document.getElementById("attendance_id").value=attendanceId;

                $.ajax({
                    url: '/attendance/' + attendanceId,
                    method: 'GET',
                    success: function(response) {
                        var students = response.students;

                        var html = '';
                        $.each(students, function(index, student) {
                            html += '<tr>';
                            html += '<td>' + student.name + '</td>';
                            html += '<td>' + student.reg_no + '</td>';
                            html += '<td>';
                            if (student.morning) {
                                html += '<i class="bx bx-user-check text-success"></i>';
                            }else{
                                html += '<i class="bx bx-user-x text-danger"></i>';
                            }
                            html += '</td>';
                            html += '<td>';
                            if (student.afternoon) {
                                html += '<i class="bx bx-user-check text-success"></i>';
                            }else{
                                html += '<i class="bx bx-user-x text-danger"></i>';
                            }
                            html += '</td>';
                            html += '<td><button class="btn btn-sm btn-danger btn-rounded waves-effect waves-light mb-2 me-2 remove" data-id="' + student.id + '">Remove</button></td>';
                            html += '</tr>';
                        });

                        $('#students-attendance tbody').html(html);
                        $('.showAttendance').modal('show');
                    },
                    error: function(response) {
                        console.log(response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.remove', function(e) {
                e.preventDefault();
                var button = $(this);
                toggleAble(button, true);
                var studentId = $(this).data('id');
                var attendanceId = $('#attendance_id').val();
                
                var row = $(this).closest('tr');

                $.ajax({
                    url: "/attendance/" + attendanceId + "/student/"+studentId,
                    method: 'GET',
                    success: function(response) {
                        toggleAble(button, false);
                        toastr.success(response.message);
                        row.remove();
                        setTimeout(function(){
                            window.location.reload();
                        },1000)
                    },
                    error: function(response) {
                        toggleAble(button, false);
                        console.log(response.responseJSON.message);
                    }
                });
            });
        </script>
    @endsection
</div>
