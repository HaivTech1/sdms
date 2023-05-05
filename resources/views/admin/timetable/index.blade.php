<x-app-layout>
    @section('title', application('name')." | Timetable")

    @section('styles')
        <style>
            .lesson {
                display: flex;
                flex-direction: row;
                position: relative;
                margin: 5px 0px;
            }

            .main{
                display: flex;
                width: 100%
            }

            .minor{
                position: absolute;
                top: 0;
                right: 0;
                z-index: 100
            }

            .class-name {
                margin-right: 1em;
            }

            .teacher-name {
                margin-left: 1em;
            }

        </style>
    @endsection
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Timetable</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>

        <div class="row">
            @admin
                <div class="row">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i class="bx bx-plus"></i></button>
                </div>
            @endadmin

            <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th width="125">Time</th>
                                    @foreach($weekDays as $day)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach($calendarData as $time => $days)
                                        <tr data-time="{{ $time }}">
                                            <td>
                                                {{ $time }}
                                            </td>
                                            @foreach($weekDays as $dayKey => $dayName)
                                                <td class="weekCol" data-day-key="{{ $dayKey }}">
                                                    @foreach($days as $key => $value)
                                                        @if (is_array($value) && $value['week'] == $dayKey)
                                                            <div class="lesson">
                                                                <div class="main">
                                                                    @admin
                                                                        <div class="class-name badge badge-soft-info text-center">{{ $value['class_name'] }}</div>
                                                                    @endadmin
                                                                    <div class="subject-name badge badge-soft-danger text-center">{{ $value['subject_name'] }}</div>
                                                                    <div class="teacher-name badge badge-soft-primary text-center">{{ $value['teacher_name'] }}</div>
                                                                </div>
                                                                @admin
                                                                <div class="minor">
                                                                    <button type="button" data-id="{{ $value['id'] }}" class="delete-lesson"><i class="bx bx-trash text-danger"></i></button>
                                                                </div>
                                                                @endadmin
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

        <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Create timetable</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="timetable" >

                            <div id="error-list" style="padding: 5px; margin: 5px">
                                <ul></ul>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="grade_id" value="{{ __('Class') }}" />
                                    <select class="form-control" name="grade_id">
                                        @foreach ($grades as $id => $grade)
                                        <option value="{{ $id }}">{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="subject_id" value="{{ __('Subject') }}" />
                                    <select class="form-control" name="subject_id">
                                        @foreach ($subjects as $id => $subject)
                                        <option value="{{ $id }}">{{ $subject }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="teacher_id" value="{{ __('Teacher') }}" />
                                    <select class="form-control" name="teacher_id">
                                        @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id() }}">{{ $teacher->name() }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <x-form.label for="weekday" value="{{ __('Week day') }}" />
                                    <select class="form-control" id="weekday" name="weekday">
                                        <option>Select</option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                    </select>
                                    <x-form.error for="weekday" />
                                </div>

                                <div class="col-sm-6  mb-3">
                                    <x-form.label for="start_time" value="{{ __('Start time') }}" />
                                    <div class="input-group" id="timepicker-input-group2">
                                        <input id="start_time" type="text" class="form-control"
                                            data-provide="timepicker" name="start_time">

                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    <x-form.error for="start_time" />
                                </div>

                                <div class="col-sm-6  mb-3">
                                    <x-form.label for="end_time" value="{{ __('End time') }}" />
                                    <div class="input-group" id="timepicker-input-group1">
                                        <input id="end_time" type="text" class="form-control"
                                            data-provide="timepicker" name="end_time">

                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                    <x-form.error for="end_time" />
                                </div>

                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button id="submit_button" type="submit" class="btn btn-primary block waves-effect waves-light pull-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @admin
        @section('scripts')
            <script>
                $(document).ready(function () {
                    $("#timepicker1").timepicker({
                        showMeridian: !1,
                        icons: {
                            up: "mdi mdi-chevron-up",
                            down: "mdi mdi-chevron-down",
                        },
                        appendWidgetTo: "#timepicker-input-group1",
                    }),
                    $("#timepicker2").timepicker({
                        showMeridian: !1,
                        icons: {
                            up: "mdi mdi-chevron-up",
                            down: "mdi mdi-chevron-down",
                        },
                        appendWidgetTo: "#timepicker-input-group2",
                    }),

                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    });

                    $('#timetable').submit((e) => {
                            e.preventDefault();
                            toggleAble('#submit_button', true, 'Submitting...');

                            var data = new FormData($('#timetable')[0]);
                            var url = "{{ route('timetable.store') }}";

                            $.ajax({
                                url,
                                method: 'post',
                                data,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                            }).then((response) => {
                                Swal.fire({
                                        title: "Good job!",
                                        text: response.message,
                                        icon: "success",
                                        showCancelButton: !0,
                                        confirmButtonColor: "#556ee6",
                                        cancelButtonColor: "#f46a6a",
                                    });
                                    toggleAble('#submit_button', false);
                                    resetForm('#timetable');
                                    window.location.reload();
                            }).catch((errors) => {
                                console.log(errors.responseJSON.errors);
                                toggleAble('#submit_button', false);

                                $("#error-list ul").empty();

                                if (errors.responseJSON.errors) {
                                    Object.values(errors.responseJSON.errors).forEach(function(errorArray) {
                                        errorArray.forEach(function(errorMessage) {
                                            $("#error-list ul").append('<li class="text-danger">' + errorMessage + '</li>');
                                        });
                                    });
                                }
                            });
                    })
                });
            </script>

            <script>
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    row.addEventListener('click', () => {
                        const dayKey = event.target.closest('td').dataset.dayKey;
                        
                        const timeString = row.cells[0].textContent;
                        const times = timeString.split(' - ');
                        const startTime = times[0];
                        const endTime = times[1];
                        $('.bs-example-modal-xl').modal('toggle');
                        $('#start_time').val(startTime);
                        $('#end_time').val(endTime);
                        $('#weekday').val(dayKey);
                        
                    });
                });
            </script>

            <script>
                const deleteLessonButtons = document.querySelectorAll('.delete-lesson');
                deleteLessonButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const lessonId = button.getAttribute('data-id');
                        Swal.fire({
                            title: 'Are you sure you want to delete the lesson?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/timetable/' + lessonId,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        toastr.success(response.message, 'Success');
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1000);
                                    },
                                    error: function(xhr, status, error) {
                                        toastr.error(error, 'Failed');
                                    }
                                });
                            }
                        });
                    });
                });
            </script>
        @endsection
    @endadmin
</x-app-layout>