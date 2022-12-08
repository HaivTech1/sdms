<x-app-layout>
    @section('title', application('name')." | Timetable")
        <x-slot name="header">
            <h4 class="mb-sm-0 font-size-18">Timetable</h4>
    
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </x-slot>

    <div class="row">
        <div class="row">
            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i class="bx bx-plus"></i></button>
        </div>
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
                                    <tr>
                                        <td>
                                            {{ $time }}
                                        </td>
                                        @foreach($days as $value)
                                            @if (is_array($value))
                                                <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center" style="background-color:#f0f0f0">
                                                    {{ $value['class_name'] }}<br>
                                                    {{-- Teacher: {{ $value['teacher_name'] }} --}}
                                                </td>
                                            @elseif ($value === 1)
                                                <td></td>
                                            @endif
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Extra large modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="timetable" >

                        <div id="error-list">
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
                                <x-form.label for="teacher_id" value="{{ __('Teacher') }}" />
                                <select class="form-control" name="teacher_id">
                                    @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id() }}">{{ $teacher->name() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.label for="weekday" value="{{ __('Week day') }}" />
                                <x-form.input id="weekday" class="block w-full mt-1"
                                    type="text" name="weekday" :value="old('weekday')" autofocus />
                                <x-form.error for="weekday" />
                            </div>

                            <div class="col-sm-6  mb-3">
                                <x-form.label for="start_time" value="{{ __('Start time') }}" />
                                <div class="input-group" id="timepicker-input-group2">
                                    <input id="timepicker2" type="text" class="form-control"
                                        data-provide="timepicker" name="start_time">

                                    <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                </div>
                                <x-form.error for="start_time" />
                            </div>

                            <div class="col-sm-6  mb-3">
                                <x-form.label for="end_time" value="{{ __('End time') }}" />
                                <div class="input-group" id="timepicker-input-group1">
                                    <input id="timepicker1" type="text" class="form-control"
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
                        Swal.fire({
                            title: "Oops!",
                            text: errors.responseJSON.message,
                            icon: "error",
                            showCancelButton:!0,
                            confirmButtonColor: "#f46a6a",
                        });

                        errors.responseJSON.forEach(function(error) {
                            $("#error-list ul").append('<li>' + error + '</li>');
                        });
                        toggleAble('#submit_button', false);
                    });
            })
         })
        </script>
    @endsection
</x-app-layout>