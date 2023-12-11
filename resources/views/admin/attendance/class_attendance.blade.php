<x-app-layout>
    @section('title', application('name')." | Mark Attendance Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Mark {{ $attendance->grade->title }} Attendance for {{ $attendance->created_at->format('d-m-Y')}}</li>
            </ol>
        </div>
    </x-slot>

    <div class="row">
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="table-responsive">
                                <table id="students-table" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Morning</th>
                                            <th>Afternoon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                            <tr>
                                            
                                                <input name="attendance_id[]" type="hidden" value="{{ $attendance->id() }}" />
                                                <input name="student_id[]" type="hidden" value="{{ $student->id() }}" />

                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $student->lastName()}} {{ $student->firstName()}} {{ $student->otherName()}}</td>
                                                <td>
                                                    <input type="checkbox" 
                                                        class="attendance-checkbox" 
                                                        id="morning_{{ $student->id() }}" 
                                                        data-attendance-type="morning" 
                                                        {{ isAttendanceMarked($student->id(), $attendance->id(), 'morning') ? 'checked' : '' }}
                                                    />
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="attendance-checkbox" 
                                                        id="afternoon_{{ $student->id() }}" 
                                                        data-attendance-type="afternoon"
                                                        {{ isAttendanceMarked($student->id(), $attendance->id(), 'afternoon') ? 'checked' : '' }}
                                                    />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        
    </div>

    @section('scripts')
        <script>
            $(document).ready(function () {
                $('.attendance-checkbox').change(function () {
                    var attendanceId = $(this).closest('tr').find('input[name="attendance_id[]"]').val();
                    var studentId = $(this).closest('tr').find('input[name="student_id[]"]').val();
                    var attendanceType = $(this).data('attendance-type');
                    var isChecked = $(this).is(':checked');

                    console.log(attendanceId, studentId, attendanceType, isChecked);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('attendance.mark') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            attendance_id: attendanceId,
                            student_id: studentId,
                            attendance_type: attendanceType,
                            is_checked: isChecked ? 1 : 0
                        },
                        success: function (response) {
                            toastr.success(response.message, 'Successful!');
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message, 'Failed!');
                        }
                    });
                });
            });
        </script>
    @endsection
   
</x-app-layout>
