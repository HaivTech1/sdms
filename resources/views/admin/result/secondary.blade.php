<!DOCTYPE html>
<html>
<head>
    @section('title', $student->last_name." | Exam Result Page")
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
            width: 35%;
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
</head>
<body style="padding: 0 250px">
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
                    <img src="{{ asset('storage/'.$student->user->image()) }}" width="70" height="70" alt="{{ $student->last_name }}">
                </div>
            </div>

            <div style="margin: 10px 0">
                <div style="font-weight: 500; text-align: center; text-transform: uppercase">REPORT SHEET FOR {{ $term->title() }} {{ $period->title() }} Academic Session</div>
            </div>

            <div class="majorContainer">
                <div class="mainContainer">
                    <div class="result-item">
                        <b>Name:</b> <span>{{ ucfirst($student->lastName()) }} {{ ucfirst($student->firstName()) }} {{ ucfirst($student->otherName()) }}</span>
                    </div>
                    <div class="result-item">
                        <b>Class:</b>
                        <span>{{ $student->grade->title()}}</span>
                    </div>
                    <div class="result-item">
                        <b>Students in class:</b>
                        <span>{{ $student->grade->students->count()}}</span>
                    </div>
                    {{-- <div class="result-item">
                        <b>Admission No.:</b>
                        <span>{{ $student->user->code()}}</span>
                    </div> --}}
                </div>
                <div class="mainContainer">
                   <div class="result-item">
                        <b>No. of times school opened:</b>
                        <span>{{ $studentAtendance->attendance_duration ?? 0 ?? ''}}</span>
                    </div>
                    <div class="result-item">
                        <b>No. of times present:</b>
                        <span>{{ $studentAttendance->attendance_present ?? '' }}</span>
                    </div>
                    <div class="result-item">
                        <b>Attendance Average:</b>
                        <span>{{ calculatePercentage($studentAttendance->attendance_duration ?? 0, $studentAttendance->attendance_present ?? 0, 100) ?? '' }}%</span>
                    </div>

                    {{-- <div class="result-item">
                        <b>Aggregate:</b><span class="s-avg aggregate"> {{ number_format($aggregate , 1)}}</span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtainable:</b>
                        <span>{{ $student->subjects->count() * 100 }}</span>
                    </div>
                    <div class="result-item">
                        <b>Mark obtained:</b>
                        <span class="s-avg grand_total"> {{ $marksObtained }}</span>
                    </div>
                    <div class="result-item">
                        <b>Position in class:</b>
                        <span>{!! $position !!}</span>
                    </div> --}}
                </div>
                <div class="minorContainer">
                    <div class="result-item">
                        <b>Next term resumes:</b>
                        <span>{{ \Carbon\carbon::parse(get_settings('next_term_resume'))->format('d F, Y') ?? 'Not set'}}</span>
                    </div>
                </div>
            </div>

            <div>
                <table class="result-table">
                    @php
                        $classPositionAllow = get_application_settings('class_position');
                        $gradePositionAllow = get_application_settings('class_position');
                        $resultPosition = get_application_settings('result_position');

                        $midterm = get_settings('midterm_format');
                        $exam = get_settings('exam_format');
                        $remarkFormat = get_settings('exam_remark');
                        $gradingFormat = get_settings('exam_grade');

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

                    <thead>
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
                            @if ($term->id() === '2')
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

                            @if ($term->id() === '3')
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
                        <tr>
                            <th style="font-size: 8px; text-align: left">Marks Obtainable</th>
                            @foreach ($midterm as $key => $value)
                                <th style="font-size: 8px">{{ $value['mark'] }}</th>
                            @endforeach
                            @foreach ($exam as $key => $value)
                                <th style="font-size: 8px">{{ $value['mark'] }}</th>
                            @endforeach
                            <th style="font-size: 8px">{{ $expectedTotal }}</th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            @if ($term->id() === '2')
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            @endif
                            @if ($term->id() === '3')
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            <th style="font-size: 8px"></th>
                            @endif
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

                                    @if ($term->id() === '1')
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
                                            {{ examGrade(calculateResult($result)) }}</td>
                                        <td
                                        style="font-size: 10px; width: 20%; font-weight: 500; text-align: center">
                                        {{ examRemark(calculateResult($result)) }}</td>

                                        
                                    @endif

                                    @if ($term->id() === '2')
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
                                            {{ examGrade(divnum(sum($result['first_term'], calculateResult($result)), 2)) }}
                                        </td>
                                        <td
                                            style="font-size: 10px; font-weight: 500; width: 20%; text-align: center">
                                            {{ examRemark(divnum(sum($result['first_term'], calculateResult($result)), 2)) }}
                                        </td>
                                    @endif

                                    @if ($term->id() === '3')
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
                                            {{ examGrade(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2))) }}
                                        </td>
                                        <td style="font-size: 8px; font-weight: 500; width: 30%; text-align: center">
                                            {{ examRemark(ceil(secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2))) }}
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
                    <div><b style="font-size: 14px; text-align: center">Position in class:</b> <span style="font-size: 12px">{{ $studentAttendance->position_in_class ?? '' }} of {{ $student->grade->students->count() }} students</span></div>
                    <div><b style="font-size: 14px; text-align: center">Position in grade:</b> <span style="font-size: 12px">{{ $studentAttendance->position_in_grade ?? '' }} of {{ $gradeStudents }} students</span></div>
                @endif
            </div>

            <div class="majorContainer">
                <div class="affectiveContainer">
                    <table class="affect-table" style="height: 50px; padding: 5px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="v-align" style="font-size: 8px">CHARACTER</th>
                                <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">Excellent</td>
                                <td style="font-size: 8px">Very Good</td>
                                <td style="font-size: 8px">Good</td>
                                <td style="font-size: 8px">Below average</td>
                                <td style="font-size: 8px">Poor</td>
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
                                <th rowspan="2" class="v-align" style="font-size: 8px">PRACTICAL</th>
                                <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
                            </tr>
                            <tr>
                                <td style="font-size: 8px">Excellent</td>
                                <td style="font-size: 8px">Very Good</td>
                                <td style="font-size: 8px">Good</td>
                                <td style="font-size: 8px">Below average</td>
                                <td style="font-size: 8px">Poor</td>
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

            <div style="margin: 5px 0">
                <span style="font-weight: bold; font-size: 10px">
                    <b>Class Teacher's Remarks</b>: 
                </span>
                <b style="font-size: 12px">{{ $studentAttendance?->comment() ?? 'No comment'}}</b>
            </div>
            <div style="margin: 5px 0">
                <span style="font-weight: bold; font-size: 10px"><b>Principal's Remarks</b>: </span><b style="font-size: 12px">{{ $studentAttendance?->pcomment() ?? '' }}</b>
            </div>
        </div>
    </div>
</body>
</html>
