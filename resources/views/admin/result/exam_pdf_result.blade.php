<!DOCTYPE html>
<html>
<head>
    @section('title', $student->last_name." | Exam Result Page")
    <style>
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
            width: 40%;
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
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .result-table th {
            background-color: #f2f2f2;
            font-weight: bold;
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
<body>
    <div class="header">
        <div class="header-item">
            <img src="{{ public_path('storage/'.application('image')) }}" width="100" height="90" alt="Profile Image">
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
            <img src="{{ public_path('storage/'.$student->user->image()) }}" width="100" height="90" alt="{{ $student->last_name }}">
        </div>
    </div>

    <div style="margin: 10px 0">
        <div style="font-weight: bold; text-align: center; text-transform: uppercase">Terminal Evaluation Report Sheet</div>
        <div style="font-weight: bold; text-align: center; text-transform: uppercase">{{ $term->title() }} {{ $period->title() }} Academic Session</div>
    </div>

    <div class="majorContainer">
        <div class="mainContainer">
            <div class="result-item">
                <b>Name:</b> <span>{{ ucfirst($student->lastName()) }} {{ ucfirst($student->firstName()) }} {{ ucfirst($student->otherName()) }}</span>
            </div>
            <div class="result-item">
                <b>Admission No.:</b>
                <span>{{ $student->user->code()}}</span>
            </div>
            <div class="result-item">
                <b>Class:</b>
                <span>{{ $student->grade->title()}}</span>
            </div>
            <div class="result-item">
                <b>Class population:</b>
                <span>{{ $student->grade->students->count()}}</span>
            </div>
        </div>
        <div class="mainContainer">
            <div class="result-item">
                <b>Age:</b>
                <span>
                    @php
                        $year = Carbon\Carbon::parse($student->dob())->age
                    @endphp
                    {{$year}}
                </span>
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
            </div>
        </div>
        <div class="minorContainer">
            <div class="result-item">
                <b>Aggregate:</b><span class="s-avg aggregate"> {{ $aggregate }}</span>
            </div>
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
        </div>
    </div>

   <div>
        <table class="result-table">
            @php
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
                    <th style="width: 50%; padding-left: 10px; text-align: left">Subjects</th>
                    @foreach ($midterm as $key => $value)
                        <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                            {{ $value['full_name'] }}
                        </th>
                    @endforeach
                    @foreach ($exam as $key => $value)
                        <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">{{ $value['full_name'] }}</th>
                    @endforeach
                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                        Total 
                    </th>
                    <th style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">
                        Position 
                    </th>
                    @if ($term->id() === '2')
                        <th>
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">FIRST TERM
                                CUMULATIVE</div>
                        </th>
                        <th class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL CUMULATIVE</div>
                        </th>
                        <th class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">AVERAGE CUMULATIVE</div>
                        </th>
                    @endif

                    @if ($term->id() === '3')
                        <th style='padding-bottom: -15px;' class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">First TERM
                                CUMULATIVE</div>
                        </th>
                        <th style='padding-bottom: -15px;' class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">SECOND TERM
                                CUMULATIVE</div>
                        </th>
                        <th class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">TOTAL CUMULATIVE</div>
                        </th>
                        <th class="">
                            <div style="width: 5%; font-size: 8px; font-weight: 500; text-align: center">AVERAGE CUMULATIVE</div>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($results as $result)
                        <tr>
                            <td style="padding-left: 10px; width: 50%; text-align: left; font-size: 10px">{{ $result['subject'] }}</td>
                            @foreach ($midterm as $key => $value)
                                @if (isset($result[$key]))
                                <td
                                    style="font-size: 10px; font-weight: 400; text-align: center; color: {{ exam20Color($result[$key]) }}">
                                    {{ $result[$key] }}</td>
                                @endif
                            @endforeach
                            @foreach ($exam as $key => $value)
                                @if (isset($result[$key]))
                                @php
                                    $color = ($examTotal == 40) ? exam40Color($result[$key]) : exam60Color($result[$key]);
                                @endphp
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ $color }}">
                                    {{ $result[$key] }}</td>
                                @endif
                            @endforeach
                            <td
                                style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">
                                {{ $result['total'] }}</td>
                            <td style="font-size: 10px; font-weight: 500; text-align: center">
                                {{ calculateStudentSubjectPosition($student->id(), \App\Models\PrimaryResult::class, $period->id(), $term->id(), $student->grade->id(), $result['subject_id']); }}
                            </td>
                            @if ($term->id() === '1')
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">
                                    {{ examGrade($result['total']) }}</td>
                                <td
                                style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['total']) }}">
                                {{ examRemark($result['total']) }}</td>
                            @endif
                            @if ($term->id() === '2')
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">
                                    {{ $result['first_term_cummulative'] }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ sum($result['total'], $result['first_term_cummulative']) }}
                                </td>
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">
                                    {{ divnum(sum($result['total'], $result['first_term_cummulative']), 2) }}
                                </td>
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">
                                    {{ examGrade(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}
                                </td>
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}">
                                    {{ examRemark(divnum(sum($result['total'], $result['first_term_cummulative']), 2)) }}
                                </td>
                            @endif
                            @if ($term->id() === '3')
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['first_term_cummulative']) }}">
                                    {{ $result['first_term_cummulative'] }}</td>
                                <td
                                    style="font-size: 10px; font-weight: 500; text-align: center; color: {{ exam100Color($result['second_term_cummulative']) }}">
                                    {{ $result['second_term_cummulative'] }}</td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']) }}
                                </td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3)) }}
                                </td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ examGrade(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}
                                </td>
                                <td style="font-size: 10px; font-weight: 500; text-align: center">
                                    {{ examRemark(round(divnum(sum($result['total'] + $result['first_term_cummulative'], $result['second_term_cummulative']), 3))) }}
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
        {{-- <div style="font-size: 8px; text-align: center">
            <span class="comment">
                <strong>EXCELLENT</strong>:5,
                <strong>VERYGOOD</strong>:4,
                <strong>GOOD</strong>:3,
                <strong>NORMAL</strong>2,
                <strong>FAIR</strong>:1,
                <strong>NO TICK</strong>:not recorded
            </span>
        </div> --}}
    </div>

    <div class="majorContainer">
        <div class="affectiveContainer">
            <table class="affect-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="v-align" style="font-size: 8px">BEHAVIOURS</th>
                        <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
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
            <table class="affect-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="v-align" style="font-size: 8px">SKILLS</th>
                        <th colspan="5" class="text-center" style="font-size: 8px">RATING</th>
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

    <div style="margin: 5px 0">
        <span style="font-weight: bold; font-size: 15px"><b>Class Teacher's Remarks</b>: </span><span>{{ $studentAtendance->comment ?? ''}}</span>
    </div>
    <div style="margin: 5px 0">
        <span style="font-weight: bold; font-size: 15px"><b>Principal's Remarks</b>: </span><span>{{ $comment }}</span>
    </div>
</body>
</html>
