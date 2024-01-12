<div>
    @section('styles')
        <style>
            #body_content {
                position: relative;
                background: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .bg_img {
                position: absolute;
                opacity: 0.1;
                background-repeat: no-repeat;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .header {
                display: table;
                width: 100%;
                table-layout: fixed;
            }

            .header-item {
                display: table-cell;
                vertical-align: middle;
                text-align: center;    
            }

            .header-item:first-child {
                text-align: left;
                width: 10%
            }

            .header-item:last-child {
                text-align: right;
                width: 10%
            }

            .majorContainer {
                width: 100%;
                margin-bottom: 1em;
            }

            .majorContainer::after {
                content: '';
                display: table;
                clear: both;
                vertical-align: middle;
            }

            .mainContainer {
                float: left;
                width: 30%;
            }

            .minorContainer {
                float: right;
                width: 30%;
            }

            .affectiveContainer {
                float: left;
                width: 45%;
            }

            .result-table {
                width: 100%;
                border-collapse: collapse;
            }

            .result-table th,
            .result-table td {
                padding: 5px;
                border: 1px solid #ccc;
                text-align: center;
            }

            .result-table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            .beh-d th, beh-d td{
                padding: 2px;
                border: 1px solid #ccc;
                text-align: center;
            }

            .result-item {
                font-size: 15px;
            }

            .affect-table {
                width: 100%;
                border-collapse: collapse;
            }

            .affect-table th,
            .affect-table td {
                padding: 2px;
                border: 1px solid #000;
                text-align: center;
            }

            .affect-table th {
                background-color: #f2f2f2;
            }

            .affect-item {
                font-size: 8px;
            }

            .rotate-header {
                transform: rotate(270deg);
                writing-mode: vertical-rl;
                white-space: nowrap;
                {{-- font-size: 8px !important; --}}
                {{-- font-weight: bold; --}}
                vertical-align: middle;
                {{-- font-weight: 900; --}}
                {{-- width: 70px; --}}
                transform-origin: bottom right;
                {{-- padding: 5px 0; --}}
                text-orientation: mixed;
            }
        </style>    
    @endsection

    <x-loading />

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="fetchResult">
                        <div class="row">
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.debounce.300ms="grade_id">
                                    <option value=''>Class</option>
                                    @foreach ($grades as $grade)
                                    <option value="{{  $grade->id() }}">{{  $grade->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-control select2" wire:model.defer="student_id">
                                    <option value=''>Students</option>
                                    @foreach ($students as $student)
                                    <option value="{{  $student['uuid'] }}">{{  $student['last_name'] }} {{  $student['first_name'] }} {{  $student['other_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control " wire:model.defer="period_id">
                                    <option value=''>Select Session</option>
                                    @foreach ($periods as $period)
                                    <option value="{{  $period->id() }}">{{  $period->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>
    
                            <div class="col-lg-2">
                                <select class="form-control select2" wire:model.defer="term_id">
                                    <option value=''>Select Term</option>
                                    @foreach ($terms as $term)
                                    <option value="{{  $term->id() }}">{{  $term->title() }}</option>
                                    @endforeach
                                </select>
    
                            </div>

                            <div class="col-lg-2">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-2">
                                        <i class="bx bx-search-alt" style="background-color: white; color: blue; border-radius: 50%; padding: 3px"></i> Fetch Result
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class='row mt-4'>
                        <div class="card">
                            <div class="card-header">
                                @if(count($results) > 0)
                                    <div id="body_content">
                                        <div class="bg_img">
                                            <img src="{{ asset('storage/' .application('image')) }}" alt="{{ application('name') }}" width="300px">
                                        </div>

                                        <div>
                                            <div class="header">
                                                <div class="header-item">
                                                    <img src="{{ asset('storage/'.application('image')) }}" width="70" height="70" alt="Profile Image">
                                                </div>
                                                <div class="header-item">
                                                    <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ application('name') }}</div>
                                                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                                                        {{ application('address') }}
                                                    </div>
                                                    <div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif">
                                                        {{ application('line1') }}, {{ application('line2') }}
                                                    </div>
                                                </div>
                                                <div class="header-item">
                                                    <img src="{{ asset('storage/'.$student_data->user->image()) }}" width="70" height="70" alt="{{ $student_data->last_name }}">
                                                </div>
                                            </div>

                                            <div style="margin: 10px 0">
                                                <div style="font-weight: 500; text-align: center; text-transform: uppercase">Terminal Evaluation Report Sheet</div>
                                                <div style="font-weight: 500; text-align: center; text-transform: uppercase">{{ $term_data->title() }} {{ $period_data->title() }} Academic Session</div>
                                            </div>

                                            <div class="majorContainer">
                                                <div class="mainContainer">
                                                    <div class="result-item">
                                                        <b>Name:</b> <span>{{ ucfirst($student_data->lastName()) }} {{ ucfirst($student_data->firstName()) }} {{ ucfirst($student_data->otherName()) }}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Admission No.:</b>
                                                        <span>{{ $student_data->user->code()}}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Class:</b>
                                                        <span>{{ $student_data->grade->title()}}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Students in class:</b>
                                                        <span>{{ $student_data->grade->students->count()}}</span>
                                                    </div>
                                                </div>
                                                <div class="mainContainer">
                                                    <div class="result-item">
                                                        <b>Aggregate:</b><span class="s-avg aggregate"> {{ number_format($aggregate , 1)}}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Mark obtainable:</b>
                                                        <span>{{ $markObtainable }}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Mark Obtained:</b>
                                                        <span class="s-avg grand_total"> {{ $marksObtained }}</span>
                                                    </div>
                                                </div>
                                                <div class="minorContainer">
                                                    <div class="result-item">
                                                        <b>No. of times school opened:</b>
                                                        <span>{{ get_settings('no_school_open') }}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>No. of times present:</b>
                                                        <span>{{ $studentAttendance->attendance_present ?? '' }}</span>
                                                    </div>
                                                    <div class="result-item">
                                                        <b>Attendance Average:</b>
                                                        <span>{{  round(calculatePercentage($studentAttendance->attendance_present, get_settings('no_school_open'), 100)) ?? '' }}%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-wrapper table-responsive" style="margin: 5px 0">
                                                <table class="result-table">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">PHYSICAL DEVELOPMENT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <tr>
                                                            <th colspan="2" class="v-align">Height (m)</th>
                                                            <th colspan="2">Width (kg)</th>
                                                            <th rowspan="2" style="width: 20%"> </th>
                                                            <th rowspan="2" style="font-size: 8px">Nature of Illness</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 8px">Beginning of Term</td>
                                                            <td style="font-size: 8px">End of Term</td>
                                                            <td style="font-size: 8px">Beginning of Term</td>
                                                            <td style="font-size: 8px">End of Term</td>
                                                        
                                                        </tr>
                                                        <tr>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td colspan="2"> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div>
                                                
                                                    <table class="result-table">
                                                        @php
                                                            $classPositionAllow = get_application_settings('class_position');
                                                            $gradePositionAllow = get_application_settings('class_position');
                                                            $resultPosition = get_application_settings('result_position');

                                                            $midterm = get_settings('midterm_format');
                                                            $exam = get_settings('exam_format');

                                                            $remarkFormat = \Illuminate\Support\Str::startsWith($student_data->grade->title, "SSS") ? get_settings('exam_remark') : get_settings('exam_remark_jun');
                                                            $gradingFormat = \Illuminate\Support\Str::startsWith($student_data->grade->title, "SSS") ? get_settings('exam_grade') : get_settings('exam_grade_jun');

                                                            $midtermTotal = 0;
                                                            $examTotal = 0;

                                                            if (is_array($midterm)) {
                                                                foreach ($midterm as $key => $value) {
                                                                    if (isset($value['mark'])) {
                                                                        $midtermTotal += $value['mark'];
                                                                    }
                                                                }
                                                            }

                                                            if (is_array($exam)) {
                                                                foreach ($exam as $key => $value) {
                                                                    if (isset($value['mark'])) {
                                                                        $examTotal += $value['mark'];
                                                                    }
                                                                }
                                                            }

                                                            $expectedTotal = $examTotal + $midtermTotal;
                                                            $mapping = generate_mapping($gradingFormat, $remarkFormat);
                                                        @endphp

                                                        <thead id="ch">
                                                            <tr>
                                                                <th style="width: 40%; padding-left: 10px; text-align: left">Subjects</th>
                                                                @foreach ($midterm as $key => $value)
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                        {{ $value['full_name'] }}
                                                                    </th>
                                                                @endforeach
                                                                @foreach ($exam as $key => $value)
                                                                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">{{ $value['full_name'] }}</th>
                                                                @endforeach
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Total 
                                                                </th>
                                                                @if ($term_data->id() === '2')
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                        Brought Forward
                                                                    </th>
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Total cummulative
                                                                    </th>
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Average cummulative
                                                                    </th>
                                                                @endif

                                                                @if ($term_data->id() === '3')
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                        Brought Forward
                                                                    </th>
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    cummulative
                                                                    </th>
                                                                    <th style="width: 10%; font-size: 8px; font-weight: 500; text-align: center">
                                                                        Average cummulative
                                                                    </th>
                                                                @endif
                                                                @if($classPositionAllow == 1)
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Position 
                                                                </th>
                                                                @endif
                                                                @if($gradePositionAllow == 1)
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                    Position in Grade
                                                                </th>
                                                                @endif
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                                                                GRADE
                                                                </th>
                                                                <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">REMARK</th>
                                                            </tr>
                                                        </thead>
                                
                                                        <tbody>
                                                            <tr>
                                                                
                                                                @foreach ($results as $result)
                                                                    <tr>
                                                                        <td style="padding-left: 10px; font-weight: 500; width: 40%; text-align: left; font-size: 11px">{{ $result['subject'] }}</td>
                                                                        @foreach ($midterm as $key => $value)
                                                                            @if (isset($result[$key]))
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ $result[$key] }}</td>
                                                                            @endif
                                                                        @endforeach
                                                                        @foreach ($exam as $key => $value)
                                                                            @if (isset($result[$key]))
                                                                            @php
                                                                                $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                                                            @endphp
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ $result[$key] }}</td>
                                                                            @endif
                                                                        @endforeach
                                                                        <td
                                                                            style="font-size: 10px; font-weight: 500; text-align: center">
                                                                            {{ calculateResult($result) }}</td>

                                                                        @if ($term_data->id() === '1')
                                                                            @if($classPositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_class_subject'] }}
                                                                                </td>
                                                                            @endif
                                                                            @if($gradePositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_grade_subject'] }}
                                                                                </td>
                                                                            @endif
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ examGrade(calculateResult($result), $student_data->grade->title()) }}</td>
                                                                            <td
                                                                            style="font-size: 10px; width: 20%; font-weight: 500; text-align: center">
                                                                                {{ examRemark(calculateResult($result), $student_data->grade->title()) }}
                                                                            </td>

                                                                            
                                                                        @endif

                                                                        @if ($term_data->id() === '2')
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ $result['first_term'] }}</td>
                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ sum($result['first_term'], calculateResult($result)) }}
                                                                            </td>
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ divnum(sum($result['first_term'], calculateResult($result)), 2) }}
                                                                            </td>

                                                                            @if($classPositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_class_subject'] }}
                                                                                </td>
                                                                            @endif

                                                                            @if($gradePositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_grade_subject'] }}
                                                                                </td>
                                                                            @endif

                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ examGrade(divnum(sum($result['first_term'], calculateResult($result)), 2), $student_data->grade->title()) }}
                                                                            </td>
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; width: 20%; text-align: center">
                                                                                {{ examRemark(divnum(sum($result['first_term'], calculateResult($result)), 2), $student_data->grade->title()) }}
                                                                            </td>
                                                                        @endif

                                                                        @if ($term_data->id() === '3')
                                                                            <td
                                                                                style="font-size: 10px; font-weight: 500; text-align: center">{{ divnum(sum($result['first_term'], $result['second_term']), 2) }}</td>
                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ ceil(divnum(sum($result['first_term'], $result['second_term']), 2) + calculateResult($result))}}
                                                                            </td>
                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">{{ ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)) }}</td>
                                                                            
                                                                            @if($classPositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_class_subject'] }}
                                                                                </td>
                                                                            @endif

                                                                            @if($gradePositionAllow == 1)
                                                                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                    {{ $result['position_in_grade_subject'] }}
                                                                                </td>
                                                                            @endif

                                                                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                                                                {{ examGrade(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student_data->grade->title()) }}
                                                                            </td>
                                                                            <td style="font-size: 8px; font-weight: 500; width: 30%; text-align: center">
                                                                                {{ examRemark(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2)), $student_data->grade->title()) }}
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                            </div>

                                            <div style="margin: 10px 0">
                                                <div style="font-size: 8px; text-align: center">
                                                    <span><b>Grading system</b>: </span>
                                                    <span>
                                                        @foreach($mapping as $key => $value)
                                                            <strong>{{ strtoupper($key) }}</strong>:{{ $value }},
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>

                                            <div style="text-align: center; margin: 7px 0">
                                                <div><b style="font-size: 14px; text-align: center">Aggregate:</b> <span style="font-size: 12px;">{{ round($aggregate)}}/100</span></div>
                                                @if($resultPosition == 1)
                                                    <div><b style="font-size: 14px; text-align: center">Position in class:</b> <span style="font-size: 12px">{{ $studentAttendance->position_in_class ?? '' }} of {{ $student_data->grade->students->count() }} students</span></div>
                                                    <div><b style="font-size: 14px; text-align: center">Position in grade:</b> <span style="font-size: 12px">{{ $studentAttendance->position_in_grade ?? '' }} of {{ $gradeStudents }} students</span></div>
                                                @endif
                                            </div>

                                            <div style="margin: 10px 0">
                                                <div class="majorContainer">
                                                    <div class="affectiveContainer">
                                                        <table class="affect-table" style="height: 50px; padding: 5px;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" class="v-align" style="margin: 4px 20px; font-size: 8px">BEHAVIOURS</th>
                                                                    <th colspan="5" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">PSYCHOMOTOR DOMAIN</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 8px">5</td>
                                                                    <td style="font-size: 8px">4</td>
                                                                    <td style="font-size: 8px">3</td>
                                                                    <td style="font-size: 8px">2</td>
                                                                    <td style="font-size: 8px">1</td>
                                                                </tr>
                                                            </thead>

                                                            @foreach ($psychomotors as $psychomotor)
                                                                <tbody class="beh-d">
                                                                    <tr>
                                                                        <th style="font-size: 8px; text-align: left">{{ $psychomotor->title() }}</th>
                                                                        <td>
                                                                            @if ($psychomotor->rate == 5)
                                                                                <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($psychomotor->rate == 4)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($psychomotor->rate == 3)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($psychomotor->rate == 2)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($psychomotor->rate == 1)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>

                                                    <div class="affectiveContainer" style="margin-left: 10px">
                                                        <table class="affect-table" style="height: 50px; padding: 5px;">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" class="v-align" style="margin: 4px 20px; font-size: 8px">BEHAVIOURS</th>
                                                                    <th colspan="5" class="text-center" class="text-center" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500; font-size: 8px">AFFECTIVE DOMAIN</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 8px">5</td>
                                                                    <td style="font-size: 8px">4</td>
                                                                    <td style="font-size: 8px">3</td>
                                                                    <td style="font-size: 8px">2</td>
                                                                    <td style="font-size: 8px">1</td>
                                                                </tr>
                                                            </thead>

                                                            @foreach ($affectives as $affective)
                                                                <tbody class="beh-d">
                                                                    <tr>
                                                                        <th style="font-size: 8px; text-align: left">{{ $affective->title() }}</th>
                                                                        <td>
                                                                            @if ($affective->rate == 5)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($affective->rate == 4)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($affective->rate == 3)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($affective->rate == 2)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($affective->rate == 1)
                                                                            <span style="font-size: 8px">V</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="majorContainer">
                                                    <div class="affectiveContainer">
                                                        <table class="result-table">
                                                            <thead style="text-align: center">
                                                                <tr>
                                                                    <th colspan="7" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">INTERPRETATION OF RESULT</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="font-size: 8px">Color code</th>
                                                                    <th style="font-size: 8px">Over 10</th>
                                                                    <th style="font-size: 8px">Over 20</th>
                                                                    <th style="font-size: 8px">Over 40</th>
                                                                    <th style="font-size: 8px">Over 60</th>
                                                                    <th style="font-size: 8px">Over 100</th>
                                                                    <th style="font-size: 8px">Grade</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="text-align: center">
                                                                <tr>
                                                                    <td style="color: black; font-size: 8px">BLACK</td>
                                                                    <td style="font-size: 8px">8-10</td>
                                                                    <td style="font-size: 8px">16-20</td>
                                                                    <td style="font-size: 8px">32-40</td>
                                                                    <td style="font-size: 8px">48-60</td>
                                                                    <td style="font-size: 8px">80-100</td>
                                                                    <td style="font-size: 8px">A</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="color: black; font-size: 8px">BLACK</td>
                                                                    <td style="font-size: 8px">7-7.9</td>
                                                                    <td style="font-size: 8px">14-15.9</td>
                                                                    <td style="font-size: 8px">28-31.9</td>
                                                                    <td style="font-size: 8px">42-47.9</td>
                                                                    <td style="font-size: 8px">70-79.9</td>
                                                                    <td style="font-size: 8px">B</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="color: green; font-size: 8px">GREEN</td>
                                                                    <td style="font-size: 8px">6-6.9</td>
                                                                    <td style="font-size: 8px">12-13.9</td>
                                                                    <td style="font-size: 8px">24-27.9</td>
                                                                    <td style="font-size: 8px">36-41.9</td>
                                                                    <td style="font-size: 8px">60-99.9</td>
                                                                    <td style="font-size: 8px">C</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="color: blue; font-size: 8px">BLUE</td>
                                                                    <td style="font-size: 8px">5.8-5.9</td>
                                                                    <td style="font-size: 8px">11.6-11.9</td>
                                                                    <td style="font-size: 8px">23.3-23.9</td>
                                                                    <td style="font-size: 8px">34.8-35.9</td>
                                                                    <td style="font-size: 8px">58-59.9</td>
                                                                    <td style="font-size: 8px">D</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="color: blue; font-size: 8px">BLUE</td>
                                                                    <td style="font-size: 8px">5.6-5.79</td>
                                                                    <td style="font-size: 8px">11.2-11.5</td>
                                                                    <td style="font-size: 8px">22.4-23.1</td>
                                                                    <td style="font-size: 8px">33.6-34.7</td>
                                                                    <td style="font-size: 8px">56-57.9</td>
                                                                    <td style="font-size: 8px">E</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="color: red; font-size: 8px">RED</td>
                                                                    <td style="font-size: 8px">Below 5.6</td>
                                                                    <td style="font-size: 8px">Below 11.2</td>
                                                                    <td style="font-size: 8px">Below 22.4</td>
                                                                    <td style="font-size: 8px">Below 33.6</td>
                                                                    <td style="font-size: 8px">Below 56</td>
                                                                    <td style="font-size: 8px">F</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="affectiveContainer" style="margin-left: 5px">
                                                        <table class="result-table">
                                                            <thead style="text-align: center">
                                                                <tr>
                                                                    <th colspan="5" style="padding: 0 5px; background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">CLUB & SOCIETY</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="text-align: center">
                                                                <tr>
                                                                    <td colspan="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="background-color: rgba(37, 41, 88, 0.7); margin: 4px 20px; color: #ffffff; font-weight: 500">Next Term Resumes</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">{{ \Carbon\carbon::parse(get_settings('next_term_resume'))->format('d F, Y') ?? 'Not set'}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div wire:ignore>
                                                <div style="margin: 5px 0" class="cursor-pointer" 
                                                    onClick="editPrincipalComment(this)" 
                                                    data-student="{{ $student_data->id() }}"
                                                    data-term="{{ $term_data->id() }}"
                                                    data-period="{{ $period_data->id() }}"
                                                >
                                                    <span" style="font-weight: bold; font-size: 10px">
                                                        <b>Class Teacher's Remarks</b>: 
                                                    </span>

                                                    <b style="font-size: 12px">{{ $studentAttendance?->comment() ?? 'No comment'}}</b>
                                                </div>

                                                <div style="margin: 5px 0" 
                                                    class="cursor-pointer"
                                                    id="editContainer"
                                                    onClick="editPrincipalComment(this)"
                                                    data-student="{{ $student_data->id() }}"
                                                    data-term="{{ $term_data->id() }}"
                                                    data-period="{{ $period_data->id() }}"
                                                >
                                                    <span style="font-weight: bold; font-size: 10px; cursor: pointer" class="cursor-pointer"><b>Principal's Remarks</b>: </span>
                                                    <b style="font-size: 12px" id="commentPrincipalDisplay">{{ $studentAttendance?->pcomment() ?? '' }}</b>

                                                    <x-form.input id="commentPrincipalInput" class="block w-full mt-1" type="text" style="display: none;" />
                                                    <div class="d-flex">
                                                        <button onclick="submitPrincipalComment()" class="btn btn-sm btn-success mt-1" id="commentPrincipalButton" style="display: none;"><i class="bx bx-check"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function editPrincipalComment(element){
                var studentData = element.getAttribute('data-student');
                var termData = element.getAttribute('data-term');
                var periodData = element.getAttribute('data-period');

                var inputField = document.getElementById('commentPrincipalInput');
                var button = document.getElementById('commentPrincipalButton');

                inputField.style.display = 'block';
                button.style.display = 'block';

                var commentDisplay = document.getElementById('commentPrincipalDisplay');
                commentDisplay.style.display = 'none';

                inputField.value = commentDisplay.innerText;

                inputField.setAttribute('data-student', studentData);
                inputField.setAttribute('data-term', termData);
                inputField.setAttribute('data-period', periodData);

            }
            


            function submitPrincipalComment() {
                var studentData = document.getElementById('editContainer').getAttribute('data-student');
                var termData = document.getElementById('editContainer').getAttribute('data-term');
                var periodData = document.getElementById('editContainer').getAttribute('data-period');
                var newComment = document.getElementById('commentPrincipalInput').value;

                var button = document.getElementById('commentPrincipalButton');
                var inputField = document.getElementById('commentPrincipalInput');
                var commentDisplay = document.getElementById('commentPrincipalDisplay');

                toggleAble(button, true, 'Submitting...');

                var url = '{{ route('result.principal.comment.upload') }}';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    type: 'POST',
                    url,
                    data: {student_uuid: studentData, term_id: termData, period_id: periodData, principal_comment: newComment}
                }).done((res) => {
                    toggleAble(button, false);
                    toastr.success(res.message, 'Success!');
                    
                    button.style.display = 'none';
                    inputField.style.display = 'none';

                    commentDisplay.style.display = 'block';
                    commentDisplay.innerText = newComment;
                }).fail((res) => {
                    toggleAble(button, false);
                    toastr.error(res.responseJSON.message, 'Failed!');
                });
            }
        </script>
    @endsection
</div>