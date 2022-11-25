<x-app-layout>
    @section('title', application('name')." | Attendance Sheet")
    <x-slot name="header">
        <h4 class="mb-sm-0 font-size-18">TimeTable</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">Sheet</li>
            </ol>
        </div>
    </x-slot>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                        <tr>

                            <th>Student Name</th>
                            <th>Class</th>
                            @php
                            $today = today();
                            $dates = [];

                            for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                }

                                @endphp
                                @foreach ($dates as $date)
                                <th style="">
                                    {{ $date }}
                                </th>
                                @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($students as $student)
                            <input type="hidden" name="student_uuid" value="{{ $student->id() }}">
                            <tr>
                              <td>{{ $student->fullName() }}</td>
                                <td>{{ $student->grade->title() }}</td>

                                @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)

                                    @php

                                    $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month,
                                    $i)->format('Y-m-d');

                                    $check_attd = \App\Models\Attendance::query()
                                    ->where('student_uuid', $student->id())
                                    ->where('attendance_date', $date_picker)
                                    ->first();

                                    $check_leave = \App\Models\Leave::query()
                                    ->where('student_uuid', $student->id())
                                    ->where('leave_date', $date_picker)
                                    ->first();

                                    @endphp
                                    <td>

                                        <div class="form-check form-check-inline ">

                                            @if (isset($check_attd))
                                                @if ($check_attd->status==1)
                                                <i class="bx bx-badge-check text-primary"></i>
                                                @else
                                                <i class="bx bx-badge-check text-danger"></i>
                                                @endif
                                            @else
                                                <i class="bx bx-x text-danger"></i>
                                            @endif
                                        </div>
                                        <div class="form-check form-check-inline">

                                            @if (isset($check_leave))
                                            @if ($check_leave->status==1)
                                            <i class="bx bx-badge-check text-primary"></i>
                                            @else
                                            <i class="bx bx-badge-check text-danger"></i>
                                            @endif

                                            @else
                                            <i class="bx bx-x text-danger"></i>
                                            @endif


                                        </div>

                                    </td>

                                    @endfor
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>