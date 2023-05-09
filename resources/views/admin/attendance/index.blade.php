<x-app-layout>
    @section('title', application('name')." | Attendance Page")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">Attendance</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Sheet</li>
            </ol>
        </div>
    </x-slot>

    <livewire:components.admin.attendance.index />
    {{-- <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="table-rep-plugin">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                        <tr>
                                            <th data-priority="1">Date</th>
                                            <th data-priority="3">Name</th>
                                            <th data-priority="4">Attendance</th>
                                            <th data-priority="6">Time In</th>
                                            <th data-priority="7">Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->attendance_date }}</td>
                                            <td>{{ $attendance->student->fullName() }}</td>
                                            <td>{{ $attendance->attendance_time }}
                                                @if ($attendance->status == 1)
                                                <span class="badge badge-primary badge-pill float-right">On Time</span>
                                                @else
                                                <span class="badge badge-danger badge-pill float-right">Late</span>
                                                @endif
                                            </td>

                                            <td>{{ $attendance->student->schedules->first()->time_in }} </td>
                                            <td>{{ $attendance->student->schedules->first()->time_out }}</td>
                                        </tr>

                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> --}}
</x-app-layout>
