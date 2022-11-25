 <div class="card">
        <div class="card-body">
        <div class="row mb-2">
        @admin
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-lg-6">
                        <select class="form-control select2" id="teacher_id" wire:model.debounce.350ms="teacher">
                            <option value=''>Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endadmin
        </div>

            <div class="table-responsive">
                <table class="table table-responsive table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Class</th>
                            @php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month,
                                $i)->format('Y-m-d');
                                }

                                @endphp
                                @foreach ($dates as $date)
                                <th>
                                    {{ $date }}
                                </th>

                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('check.check_store') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success" style="display: flex; margin:10px">Submit</button>
                            @foreach ($students as $student)
                                <input type="hidden" name="student_uuid" value="{{ $student->id() }}">
                                <input type="hidden" name="grade_id" value="{{ $student->grade->id() }}">
                                <tr>
                                    <td>{{ $student->fullName() }}</td>
                                    <td>{{ $student->grade->title() }}</td>

                                    @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)
                                        @php
                                            
                                            $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                            
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
                                           <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="check_box"
                                                    name="attd[{{ $date_picker }}][{{ $student->id() }}]" type="checkbox"
                                                    @if (isset($check_attd))  checked @endif id="inlineCheckbox1" value="1">

                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="check_box"
                                                    name="leave[{{ $date_picker }}][{{ $student->id() }}]]" type="checkbox"
                                                    @if (isset($check_leave))  checked @endif id="inlineCheckbox2" value="1">

                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </form>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>